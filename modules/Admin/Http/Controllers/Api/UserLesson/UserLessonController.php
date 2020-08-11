<?php

namespace Modules\Admin\Http\Controllers\Api\UserLesson;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Http\Requests\UserLesson\CheckinoutRequest;
use Modules\Admin\Transformers\UserLesson\UserLessonTransformer;
use Modules\Guest\Repositories\GuestRepository;
use Modules\Mon\Entities\Lesson;
use Modules\Mon\Entities\UserLesson;
use Modules\Admin\Http\Requests\UserLesson\CreateUserLessonRequest;
use Modules\Admin\Http\Requests\UserLesson\UpdateUserLessonRequest;
use Modules\Admin\Repositories\UserLessonRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class UserLessonController extends ApiController
{
    /**
     * @var UserLessonRepository
     */
    private $userlessonRepository;

    /**
     * @var GuestRepository
     */
    private $guestRepository;

    public function __construct(Authentication $auth, UserLessonRepository $userlesson, GuestRepository $guestRepository)
    {
        parent::__construct($auth);

        $this->userlessonRepository = $userlesson;
        $this->guestRepository = $guestRepository;
    }


    public function index(Request $request)
    {
        return UserLessonTransformer::collection($this->userlessonRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return UserLessonTransformer::collection($this->userlessonRepository->newQueryBuilder()->get());
    }


    public function store(CreateUserLessonRequest $request)
    {
        $this->userlessonRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::userlesson.message.create success'),
        ]);
    }


    public function find(UserLesson $userlesson)
    {
        return new  UserLessonTransformer($userlesson);
    }

    public function update(UserLesson $userlesson, UpdateUserLessonRequest $request)
    {
        $this->userlessonRepository->update($userlesson, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::userlesson.message.update success'),
        ]);
    }

    public function destroy(UserLesson $userlesson)
    {
        $this->userlessonRepository->destroy($userlesson);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::userlesson.message.delete success'),
        ]);
    }
    public function checkinout(CheckinoutRequest $request ) {
        $type = $request->get('type');
        $username = $request->get('username');
        $user = $this->guestRepository->getUser($username);

        $lesson = Lesson::find($request->get('lesson_id'));

        if (strtolower($type) == 'checkin') {
            // save checkin
            $result = $this->guestRepository->userCheckin($user, $lesson);
            $status = false;
            if ($result === true) {
                $message=trans('backend::checkinout.message.check in success', ['lesson' => $lesson->name ]);
                $status = true;

            } elseif ($result === false) {
                $message=trans('backend::checkinout.message.check in false, you not register grade', ['grade' => $lesson->grade->name ]);
                $status = false;
            } else {
                $message=trans('backend::checkinout.message.check in success', ['lesson' => $lesson->name ]);
                $status = true;
            }
        } else {
            // save checkout
            $result = $this->guestRepository->userCheckout($user, $lesson);
            $status = false;
            if ($result === false) {
                $message=trans('backend::checkinout.message.check out false, you not register grade', ['grade' => $lesson->grade->name ]);
                $status = false;
            } else {
                $message=trans('backend::checkinout.message.check out success', ['lesson' => $lesson->name ]);
                $status = true;
            }
        }
        return response()->json([
            'errors' => $status,
            'message' => $message,
        ]);
    }
}
