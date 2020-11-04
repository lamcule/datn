<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 11/23/18
 * Time: 8:58 AM
 */

namespace Modules\Admin\Events\Handlers;


use Modules\Admin\Events\GradeCreated;
use Modules\Admin\Repositories\LessonRepository;

class GenerateLesson
{

    /**
     * @var LessonRepository
     */
    protected $lessonRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        LessonRepository $lessonRepository
    )
    {
        $this->lessonRepository = $lessonRepository;

    }

    /**
     * Handle the event.
     *
     * @param GradeCreated $event
     * @return void
     */
    public function handle(GradeCreated $event)
    {

        $grade = $event->grade;
        if ($grade->number_of_lesson) {
            for($i = 0; $i< $grade->number_of_lesson; $i++) {
                $this->lessonRepository->create([
                    'name' => $grade->name . ' - Buổi '. ($i+1),

                    'course_id' => $grade->course_id,
                    'grade_id' => $grade->id,
                    'place' => $grade->place,
                    'province_id'=> $grade->province_id,
                    'district_id'=> $grade->district_id,
                    'phoenix_id'=> $grade->phoenix_id,
                    'teacher'=> $grade->teacher,
                    'start_time'=> $grade->start_time,

                ]);
            }
        }
    }


}
