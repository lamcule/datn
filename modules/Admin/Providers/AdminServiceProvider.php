<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Admin\Console\CreateAdminUser;
use Modules\Admin\Console\CreateStudent;
use Modules\Admin\Console\GenerateAdminPermission;
use Modules\Admin\Console\GenerateArea;
use Modules\Admin\Console\UpdateLessonStatus;
use Modules\Admin\Console\UpdateProfile;
use Modules\Admin\Console\UpdateStudent;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $commands = [
        CreateAdminUser::class,
        GenerateAdminPermission::class,
        CreateStudent::class,
        GenerateArea::class,
        UpdateLessonStatus::class,
	    UpdateStudent::class,
        UpdateProfile::class
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->registerBindings();
        $this->commands($this->commands);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('admin.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'admin'
        );
        $this->publishes([
            __DIR__.'/../Config/student.php' => config_path('student.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/student.php', 'student'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/admin');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/admin';
        }, \Config::get('view.paths')), [$sourcePath]), 'admin');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/admin');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'admin');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'admin');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
    private function registerBindings()
    {


        $this->app->bind(
            'Modules\Admin\Repositories\StudentRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentStudentRepository(new \Modules\Mon\Entities\User());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\TeacherRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentTeacherRepository(new \Modules\Mon\Entities\User());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\UploadStudentRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentUploadStudentRepository(new \Modules\Mon\Entities\UploadStudent());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\CourseRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentCourseRepository(new \Modules\Mon\Entities\Course());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\GradeRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentGradeRepository(new \Modules\Mon\Entities\Grade());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\LessonRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentLessonRepository(new \Modules\Mon\Entities\Lesson());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\ProvinceRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentProvinceRepository(new \Modules\Mon\Entities\Province());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\DistrictRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentDistrictRepository(new \Modules\Mon\Entities\District());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\PhoenixRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentPhoenixRepository(new \Modules\Mon\Entities\Phoenix());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\UserLessonRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentUserLessonRepository(new \Modules\Mon\Entities\UserLesson());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\QuestionRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentQuestionRepository(new \Modules\Mon\Entities\Question());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\ReviewRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentReviewRepository(new \Modules\Mon\Entities\Review());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\StudentImportRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentStudentImportRepository(new \Modules\Mon\Entities\StudentImport());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\ImportDetailRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentImportDetailRepository(new \Modules\Mon\Entities\ImportDetail());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\QuestionGroupRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentQuestionGroupRepository(new \Modules\Mon\Entities\QuestionGroup());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\UserReviewRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentUserReviewRepository(new \Modules\Mon\Entities\UserReview());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\ReportRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentReportRepository(new \Modules\Mon\Entities\Grade());
                return $repository;
            }
        );
// add bindings



























    }
}
