<?php

namespace Modules\Admin\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Admin\Events\GradeCreated;
use Modules\Admin\Events\Handlers\GenerateLesson;
use Modules\Admin\Events\Sidebar\Admin\CourseSidebarExtender;
use Modules\Admin\Events\Sidebar\Admin\GradeSidebarExtender;
use Modules\Admin\Events\Sidebar\Admin\ManageWebsiteSidebarExtender;
use Modules\Admin\Events\Sidebar\Admin\MediaSidebarExtender;
use Modules\Admin\Events\Sidebar\Admin\ReportSidebarExtender;
use Modules\Admin\Events\Sidebar\Admin\ReviewSidebarExtender;
use Modules\Admin\Events\Sidebar\Admin\StudentImportSidebarExtender;
use Modules\Admin\Events\Sidebar\Admin\StudentSidebarExtender;
use Modules\Admin\Events\Sidebar\Admin\TeacherSidebarExtender;
use Modules\Admin\Events\Sidebar\Admin\UserSidebarExtender;
use Modules\Admin\Events\Sidebar\BuildingSidebar;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BuildingSidebar::class => [
            UserSidebarExtender::class,
            MediaSidebarExtender::class,
            ManageWebsiteSidebarExtender::class,
            StudentSidebarExtender::class,
            TeacherSidebarExtender::class,
            GradeSidebarExtender::class,
            CourseSidebarExtender::class,
            ReportSidebarExtender::class,
            ReviewSidebarExtender::class,
        ],
        GradeCreated::class => [
            GenerateLesson::class
        ]

    ];
}
