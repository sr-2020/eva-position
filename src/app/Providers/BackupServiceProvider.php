<?php

namespace App\Providers;

class BackupServiceProvider extends \Spatie\Backup\BackupServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/backup'),
        ]);

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'backup');
    }
}
