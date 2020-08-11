<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 11/23/18
 * Time: 8:58 AM
 */

namespace Modules\Guest\Events\Handlers;


use App\Services\SendSmsService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Admin\Events\GradeCreated;
use Modules\Admin\Repositories\LessonRepository;
use Modules\Guest\Events\StudentRegistedCourse;
use Modules\Mon\Entities\Course;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Profile;
use Modules\Mon\Entities\User;

class SendSmsRegistSuccess implements ShouldQueue
{
    public $smsClient;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SendSmsService  $sendSmsService)
    {
        $this->smsClient = $sendSmsService;
    }

    /**
     * Handle the event.
     *
     * @param  GradeCreated $event
     * @return void
     */
    public function handle(StudentRegistedCourse $event)
    {

        /** @var Grade $grade */
        $grade = $event->grade;
        /** @var User $user */
        $user = $event->user;

        $profile = Profile::where('user_id', $user->id)->first();
        $course = Course::query()->where('id', $grade->course_id)->first();
        if ($course->has_notification) {
            if ($profile && $profile->phone) {
                $courseName = $grade->course->name;
                $userID = $user->username;
                $startTime = Carbon::createFromFormat( 'Y-m-d H:i:s', $grade->start_time)->format('H'). 'h'. Carbon::createFromFormat( 'Y-m-d H:i:s', $grade->start_time)->format('i');
                $startDay = Carbon::createFromFormat( 'Y-m-d H:i:s', $grade->start_time)->format('d/m/Y');
                $content = "[SVF] Cam on Anh/Chi da dang ky tham gia chuong trinh $courseName. Thoi gian $startTime ngay $startDay. Vui long co mat truoc thoi gian bat dau 15 phut. ID: $userID";
                $result = $this->smsClient->sendToPhone($profile->phone, $content);
                Log::info($result);
            }
        }


    }


}
