<?php

namespace Modules\Guest\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Modules\Guest\Repositories\GuestRepository;
use Modules\Mon\Auth\Contracts\Authentication;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Lesson;
use Modules\Mon\Http\Controllers\WebController;


class GuestController extends WebController
{
    /**
     * @var GuestRepository
     */
    public $guestRepository;
    public function __construct(Authentication $auth, GuestRepository $guestRepository)
    {
        parent::__construct($auth);
        $this->guestRepository = $guestRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return $this->view('home');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function course()
    {
        return $this->view('course');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function about()
    {
        return $this->view('about');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function contact()
    {
        return $this->view('contact');
    }
    public function handleCheckin(Request $request,Lesson $lesson)
    {
        $username = $request->get('username');
        $user = $this->guestRepository->getUser($username);
        if (!$user) {
            $validator = Validator::make($request->all(), [

            ]);
            $validator->errors()->add('username', trans('base::frontend.message.Student id not found'));
            return redirect(route('checkin',['lesson'=> $lesson->id]))
                -> withErrors($validator)
                -> withInput();
        }
        // save checkin
        $result = $this->guestRepository->userCheckin($user, $lesson);
        $status = false;
        if ($result === true) {
            $message='Cảm ơn Anh, Chị đã đăng nhập. Chúc Anh, Chị sẽ có một chương trình thú vị';
            $status = true;

        } elseif ($result === false) {
            $message="Xác nhận không thành công, Anh, Chị chưa đăng ký tham gia chương trình";
            $status = false;
        } else {
            $message=trans('base::frontend.message.you checked in at', ['time' => $result]);
            $status = false;
        }

        return $this->view('message', compact('message', 'status'));
    }
    public function registGrade(Grade $grade)
    {

        $this->seo()->setTitle('Regist course');
        return $this->view('regist_grade', compact('grade' ));
    }
    public function checkout(Lesson $lesson)
    {

        $this->seo()->setTitle('Checkout');
        return $this->view('checkout', compact('lesson' ));
    }
    public function handleCheckout(Request $request,Lesson $lesson)
    {
        $username = $request->get('username');
        $user = $this->guestRepository->getUser($username);
        if (!$user) {
            $validator = Validator::make($request->all(), [

            ]);
            $validator->errors()->add('username', trans('base::frontend.message.Student id not found'));
            return redirect(route('checkout',['lesson'=> $lesson->id]))
                -> withErrors($validator)
                -> withInput();
        }
        // save checkin
        $result = $this->guestRepository->userCheckout($user, $lesson);
        $status = false;
        if ($result === false) {
            $message=trans('base::frontend.message.check out false, you not register grade', ['grade' => $lesson->grade->name ]);
            $status = false;
        } else {
            $message="Cảm ơn Anh, Chị đã xác nhận hoàn thành chương trình";
            $status = true;
        }

        return $this->view('message', compact('message', 'status'));
    }
    public function review()
    {
        $this->seo()->setTitle('Review');
        return $this->view('review');
    }

}
