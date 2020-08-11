<?php

namespace Modules\Guest\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\StudentRepository;
use Modules\Guest\Events\StudentRegistedCourse;
use Modules\Guest\Http\Requests\CreateReviewRequest;
use Modules\Guest\Http\Requests\CreateStudentRequest;
use Modules\Guest\Repositories\GuestRepository;
use Modules\Guest\Transformers\GradeFullTransformer;
use Modules\Guest\Transformers\LessonFullTransformer;
use Modules\Guest\Transformers\QuestionGroupTransformer;
use Modules\Guest\Transformers\QuestionTransformer;
use Modules\Mon\Auth\Contracts\Authentication;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Lesson;
use Modules\Mon\Entities\Question;
use Modules\Mon\Entities\User;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Repositories\ProfileRepository;
use Modules\Mon\Repositories\UserRepository;


class PublicController extends ApiController
{
    /**
     * @var GuestRepository
     */
    public $guestRepository;

    /**
     * @var StudentRepository
     */
    public $studentRepository;

    /**
     * @var ProfileRepository
     */
    public $profileRepository;

    public function __construct(
        Authentication $auth,
        GuestRepository $guestRepository,
        StudentRepository $studentRepository,
        ProfileRepository $profileRepository
    ) {
        parent::__construct($auth);
        $this->guestRepository = $guestRepository;
        $this->studentRepository = $studentRepository;
        $this->profileRepository = $profileRepository;
    }

    public function registGrade(Request $request, Grade $grade)
    {
        $username = $request->get('username');
        $user = $this->guestRepository->getUser($username);
        if (!$user) {
            return [
                'success' => false,
                'message' =>trans('base::frontend.message.Student id not found')
            ];

        }
        $result = $this->guestRepository->registGrade($user, $grade);
        if ($result === true) {
            event(new StudentRegistedCourse($user, $grade));
            $message = trans('base::frontend.message.regist grade success', ['grade' => $grade->name]);
            $status = true;

        } else {
            $message = trans('base::frontend.message.regist grade fail', ['grade' => $grade->name]);
            $status = false;
        }
        return [
            'success' => $status,
            'message' => $message
        ];
    }

    public function registGradeNoAccount(CreateStudentRequest $request, Grade $grade)
    {
        $data = $request->all();
        $data['type'] = User::TYPE_STUDENT;
        $user = $this->guestRepository->getUserByEmail($data['email']);
        if ($user) {
            return [
                'success' => false,
                'message' => trans('base::frontend.message.regist grade fail')
            ];

        }
        DB::beginTransaction();
        try {
            $user = $this->studentRepository->create($data);

            $result = $this->guestRepository->registGrade($user, $grade);
            if ($result === true) {
                event(new StudentRegistedCourse($user, $grade));
                $message = trans('base::frontend.message.regist grade success', ['grade' => $grade->name]);
                $status = true;

            } else {
                $message = trans('base::frontend.message.regist grade fail', ['grade' => $grade->name]);
                $status = false;
            }
            DB::commit();
        } catch (\Exception $exception) {
            \Log::info($exception->getMessage());
            DB::rollBack();
            $message = trans('base::frontend.message.regist grade fail', ['grade' => $grade->name]);
            $status = false;
        }

        return [
            'success' => $status,
            'message' => $message
        ];
    }

    public function questions(Request $request) {
        $groups = $this->guestRepository->getQuestionGroup();
        return QuestionGroupTransformer::collection($groups);
    }
    public function getLesson(Request $request, Lesson $lesson) {

        return new LessonFullTransformer($lesson);
    }

    public function handleReview(CreateReviewRequest $request, Lesson $lesson)
    {


        $user = $this->guestRepository->getUser($request->get('username'));

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Mã học viên không tồn tại'
            ];

        }

        $result = $this->guestRepository->storeReview($user, $lesson, $request->get('questions'));
        if ($result === true) {
            $profileData = $this->parseProfileData($request);
            $profile = $this->profileRepository->findByAttributes(['user_id' => $user->id]);
            if ($profile) {
                $this->profileRepository->update($profile, $profileData);
            }
            $success = true;
            $message = "Cảm ơn đánh giá của Anh, Chị";
        } else {
            $success = false;
            $message = $result;
        }
        return [
            'success' => $success,
            'message' =>$message
        ];
    }
    public function parseProfileData($request) {
        $data = $request->get('profile');
        $dataForSave = [];
        if (isset($data['birth_date']) && !empty($data['birth_date'])) {
            $dataForSave['birth_date'] =$data['birth_date'];
        }
        if (isset($data['gender']) && !empty($data['gender'])) {
            $dataForSave['gender'] =$data['gender'];
        }
        if (isset($data['address']) && !empty($data['address'])) {
            $dataForSave['address'] =$data['address'];
        }
        if (isset($data['company_address']) && !empty($data['company_address'])) {
            $dataForSave['company_address'] =$data['company_address'];
        }
        return $dataForSave;
    }
}
