<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AliasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Get the AliasLoader instance
        $loader = AliasLoader::getInstance();

        // Add your aliases
        $loader->alias('Setting', \App\Helpers\SettingHelper::class);
        $loader->alias('UtlHelper', \App\Helpers\UtlHelper::class);
        $loader->alias('LocalizationHelper', \App\Helpers\LocalizationHelper::class);
        $loader->alias('PermissionHelper', \App\Helpers\PermissionHelper::class);
        $loader->alias('ImageHelper', \App\Helpers\ImageHelper::class);
        $loader->alias('PostHelper', \App\Helpers\PostHelper::class);
        $loader->alias('VideoHelper', \App\Helpers\VideoHelper::class);
        $loader->alias('AudioHelper', \App\Helpers\AudioHelper::class);
        $loader->alias('TermHelper', \App\Helpers\TermHelper::class);
        $loader->alias('ThemeHelper', \App\Helpers\ThemeHelper::class);
        $loader->alias('UserHelper', \App\Helpers\UserHelper::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
