<?php

namespace Modules\Mon\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Mon\Auth\AccessTokenGuard;
use Modules\Mon\Console\ThemeVueI18nGenerate;
use Modules\Mon\Entities\Profile;
use Modules\Mon\Events\LoadingTranslations;
use Modules\Mon\Http\Middleware\Admin;
use Modules\Mon\Http\Middleware\ApiPermission;
use Modules\Mon\Http\Middleware\ApiRole;
use Modules\Mon\Http\Middleware\ApiToken;
use Modules\Mon\Http\Middleware\SaveSettings;
use Modules\Mon\Http\Middleware\SetLocale;
use Modules\Mon\Http\Middleware\ThemeViews;
use Modules\Mon\Support\Theme;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MonServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $commands = [
        \Modules\Mon\Console\Theme::class,
        \Modules\Mon\Console\EntityScaffoldCommand::class,
        ThemeVueI18nGenerate::class
    ];

    protected $middleware = [
        'locale' => SetLocale::class,
        'admin' => Admin::class,
        'api.token' => ApiToken::class,
        'api.role' => ApiRole::class,
        'api.permission' => ApiPermission::class,
        'role' => RoleMiddleware::class,
        'permission' => PermissionMiddleware::class,
    ];

    protected $groupMiddleware = [
        'web' => [
            SaveSettings::class,
            SetLocale::class,
            ThemeViews::class,
        ],
        'api.token' => [
            'throttle:60,1',
            'bindings',
            SaveSettings::class,
            SetLocale::class,
        ]
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
        $this->registerMiddleware($this->app['router']);
        $this->registerRepositories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->app->register(RouteServiceProvider::class);

        \Auth::extend('access_token', function ($app, $name, array $config) {
            // automatically build the DI, put it as reference
            $userProvider = app(UserTokenProvider::class);
            $request = app('request');
            return new AccessTokenGuard($userProvider, $request, $config);
        });

        $this->registerThemeTranslation();

        $this->app['events']->listen(LoadingTranslations::class, function (LoadingTranslations $event) {
            $event->load('mon', array_dot(trans('mon::mon')));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('theme', function () {
            return new Theme();
        });

        $this->app->bind(
            'Modules\Mon\Auth\Contracts\Authentication',
            function () {
                return new \Modules\Mon\Auth\Authentication('web');
            }
        );


        $this->commands($this->commands);
    }

    public function registerMiddleware(Router $router)
    {
        foreach ($this->middleware as $name => $middleware) {
            $router->aliasMiddleware($name, $middleware);
        }

        foreach ($this->groupMiddleware as $group => $middlewares) {
            foreach ($middlewares as $mw) {
                $router->pushMiddlewareToGroup($group, $mw);
            }
        }
    }

    public function registerRepositories()
    {
        $this->app->bind(
            'Modules\Mon\Repositories\UserRepository',
            function () {
                return new \Modules\Mon\Repositories\Eloquent\UserRepository(new \Modules\Mon\Entities\User());
            }
        );

        $this->app->bind(
            'Modules\Mon\Repositories\UserTokenRepository',
            function () {
                return new \Modules\Mon\Repositories\Eloquent\UserTokenRepository(new \Modules\Mon\Entities\UserToken());
            }
        );
        $this->app->bind(
            'Modules\Mon\Repositories\RoleRepository',
            function () {
                return new \Modules\Mon\Repositories\Eloquent\RoleRepository(new Role());
            }
        );
        $this->app->bind(
            'Modules\Mon\Repositories\PermissionRepository',
            function () {
                return new \Modules\Mon\Repositories\Eloquent\PermissionRepository(new Permission());
            }
        );
        $this->app->bind(
            'Modules\Mon\Repositories\ProfileRepository',
            function () {
                return new \Modules\Mon\Repositories\Eloquent\ProfileRepository(new Profile());
            }
        );
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('mon.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'mon'
        );

        $this->publishes([
            __DIR__ . '/../Config/user.php' => config_path('user.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/user.php', 'user'
        );
        $this->publishes([
            __DIR__ . '/../Config/locales.php' => config_path('locales.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/locales.php', 'locales'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/mon');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/mon';
        }, \Config::get('view.paths')), [$sourcePath]), 'mon');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/mon');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'mon');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'mon');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production')) {
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
    public function registerThemeTranslation() {
        $adminTheme = 'backend';

        $frontendTheme = 'base';


        //Language
        $langPath = base_path("themes/{$adminTheme}/lang");
        $this->app['translator']->addNamespace($adminTheme, $langPath);

        $langPath = base_path("themes/{$frontendTheme}/lang");
        $this->app['translator']->addNamespace($frontendTheme, $langPath);


        $this->app['events']->listen(LoadingTranslations::class, function (LoadingTranslations $event) use ($frontendTheme) {
            $event->load($frontendTheme, array_dot(trans($frontendTheme."::frontend")));
        });
    }
}
