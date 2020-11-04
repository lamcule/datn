<?php

namespace Modules\Guest\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Guest\Events\Handlers\SendEmailRegistSuccess;
use Modules\Guest\Events\Handlers\SendSmsRegistSuccess;
use Modules\Guest\Events\StudentRegistedCourse;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        StudentRegistedCourse::class => [
//            SendEmailRegistSuccess::class,
//            SendSmsRegistSuccess::class
        ]

    ];
}
