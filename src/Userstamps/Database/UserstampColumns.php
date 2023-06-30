<?php

namespace Codiliateur\Userstamps\Database;

use Illuminate\Database\Schema\Blueprint;

class UserstampColumns
{
    public static function addUserstampColumns(Blueprint $table)
    {
        $table->bigInteger(config('codiliateur'))
    }

    public static function dropUserstampColumns(Blueprint $table)
    {

    }
}
