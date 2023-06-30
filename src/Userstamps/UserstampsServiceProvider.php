<?php

namespace Codiliateur\Userstamps;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class UserstampsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/userstamps.php' => config_path('codiliateur/userstamps.php'),
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../config/userstamps.php', 'codiliateur.userstamps');
    }

    public function register()
    {
        Blueprint::macro('userstamps', function () {
            //
        });

        Blueprint::macro('dropUserstamps', function () {
            //
        });
    }
}
