<?php

namespace Codiliateur\Userstamps\Database;

use Codiliateur\Userstamps\Support\UserstampNames;
use Illuminate\Database\Schema\Blueprint;

class UserstampColumns
{

    /**
     * @param Blueprint $table
     * @param bool $softDeletes
     * @param string|null $columnType
     * @param array $columnNames
     * @return void
     */
    public static function addUserstampColumns(Blueprint $table, bool $softDeletes = false, string $columnType = null, array $columnNames = null)
    {
        $columnType = $columnType ?? config('codiliateur.userstamps.column_type' ?? 'bigInteger');

        $columnNames = array_replace(UserstampNames::baseColumnNames(), $columnNames ?? []);

        if (!$softDeletes && array_key_exists(UserstampNames::DELETED, $columnNames)) {
            unset($columnNames[UserstampNames::DELETED]);
        }

        foreach ($columnNames as $columnName) {
            $table->$columnType($columnName)->nullable();
        }
    }

    /**
     * @param Blueprint $table
     * @param bool $softDeletes
     * @param array $columnNames
     * @return void
     */
    public static function dropUserstampColumns(Blueprint $table, bool $softDeletes = false, array $columnNames = null)
    {
        $columnNames = array_replace(UserstampNames::baseColumnNames(), $columnNames ?? []);

        if (!$softDeletes && array_key_exists(UserstampNames::DELETED, $columnNames)) {
            unset($columnNames[UserstampNames::DELETED]);
        }

        foreach ($columnNames as $columnName) {
            $table->dropColumn($columnName);
        }
    }

}
