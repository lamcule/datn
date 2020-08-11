<?php

namespace Modules\Admin\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;

use Modules\Admin\Repositories\LessonRepository;
use Modules\Mon\Entities\Lesson;
use Modules\Mon\Entities\User;
use Modules\Mon\Repositories\PermissionRepository;
use Modules\Mon\Repositories\UserRepository;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateLessonStatus extends Command
{
    /**
     * The console command name.
     * php artisan admin:create-root-user email password
     * @var string
     */
    protected $name = 'admin:update-lesson-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update lesson status.';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * @var $lessonRepository LessonRepository
         */
        $lessonRepository = app(LessonRepository::class);
        Lesson::chunk(200, function ($lessons) {
            foreach ($lessons as $lesson) {
                var_dump($lesson->id);
                if ($lesson->start_time) {

                    if ($lesson->start_time->lessThanOrEqualTo(Carbon::now())) {
                        $lesson->status = Lesson::STATUS_STARTED;
                    }else {
                        $lesson->status = Lesson::STATUS_NOT_START;
                    }
                    if ($lesson->end_time && $lesson->end_time->lessThanOrEqualTo(Carbon::now())) {
                        $lesson->status = Lesson::STATUS_FINISHED;
                    }
                }else {
                    $lesson->status = Lesson::STATUS_NOT_START;
                }

                $lesson->save();
            }
        });


    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [

        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
        ];
    }

}
