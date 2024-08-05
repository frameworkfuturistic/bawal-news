<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        using: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        
            Route::middleware('web')
                ->namespace('App\Http\Controllers')
                ->group(base_path('routes/admin.php'));
        
            Route::middleware('web')
                ->namespace('App\Http\Controllers')
                ->group(base_path('routes/contact.php'));
        
            Route::middleware('web')
                ->namespace('App\Http\Controllers')
                ->group(base_path('routes/front.php'));
        
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'public' => \App\Http\Middleware\MaintenanceMode::class,
            'XSS' => \App\Http\Middleware\XSSProtection::class,
            'is-ban' => \App\Http\Middleware\ForbidBannedUserCustom::class,
            'auth.locale' => \App\Http\Middleware\AuthLocale::class,
            'language' => \App\Http\Middleware\Language::class,
            'user-locale' => \App\Http\Middleware\UserLocale::class,
            'frontend.locale' => \App\Http\Middleware\FrontendLocale::class,
            'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'=> \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
            'checkExistsSettings' => \App\Http\Middleware\CheckExistSettingsTable::class,
            'LocalizeApiRequests' => \App\Http\Middleware\LocalizeApiRequests::class,
            'setLocale' => \App\Http\Middleware\SetLocale::class,
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'NoCaptcha' => Anhskohbo\NoCaptcha\Facades\NoCaptcha::class,
            'Share' => Jorenvh\Share\ShareFacade::class,
            'Excel' => Maatwebsite\Excel\Facades\Excel::class,
            'LaravelLocalization' => Mcamara\LaravelLocalization\Facades\LaravelLocalization::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
