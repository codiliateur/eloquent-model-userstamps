<?php

namespace Codiliateur\Userstamps;

use Codiliateur\Userstamps\Database\UserstampColumns;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class UserstampsServiceProvider extends ServiceProvider
{
    /**
     * Service booting
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/userstamps.php' => config_path('codiliateur/userstamps.php'),
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../config/userstamps.php', 'codiliateur.userstamps');
    }

    /**
     * Service registering
     *
     * @return void
     */
    public function register()
    {
        Blueprint::macro('userstamps', function ($softDeletes = false, $columnType = null, $columnNames = null) {
            UserstampColumns::addUserstampColumns($this, $softDeletes, $columnType, $columnNames);
        });

        Blueprint::macro('dropUserstamps', function ($softDeletes = false, $columnNames = null) {
            UserstampColumns::dropUserstampColumns($this, $softDeletes, $columnNames);
        });
    }
}
