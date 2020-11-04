<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 11/23/18
 * Time: 8:58 AM
 */

namespace Modules\Guest\Events\Handlers;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Modules\Admin\Events\GradeCreated;
use Modules\Admin\Repositories\LessonRepository;
use Modules\Guest\Events\StudentRegistedCourse;
use Modules\Mon\Entities\Course;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\User;

class SendEmailRegistSuccess implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param  GradeCreated $event
     * @return void
     */
    public function handle(StudentRegistedCourse $event)
    {

//        /** @var Grade $grade */
//        $grade = $event->grade;
//        $course = Course::query()->where('id', $grade->course_id)->first();
//        if ($course && $course->has_email) {
//            /** @var User $user */
//            $user = $event->user;
//            Mail::send('emails.register_success', ['user' => $user, 'grade'=> $grade], function ($m) use ($user, $grade) {
//                $title = "[SVF] Chúc mừng bạn đã đăng ký thành công chương trình ".$grade->name;
//                $m->from('admin@svf.org.vn', 'Startup Vietnam Foundation');
//
//                $m->to($user->email, $user->username)->subject($title);
//            });
//        }


    }


}
