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
     * @param array|null $columnNames
     * @return void
     */
    public static function addUserstampColumns(Blueprint $table, bool $softDeletes = false, string $columnType = null, array $columnNames = null)
    {
        $columnType = $columnType ?? config('codiliateur.userstamps.column_type' ?? 'bigInteger');

        if (is_null($columnNames)) {
            $columnNames = UserstampNames::baseColumnNames();
        }

        if (!$softDeletes && array_key_exists(2, $columnNames)) {
            unset($columnNames[2]);
        }

        foreach ($columnNames as $columnName) {
            $table->$columnType($columnName)->nullable();
        }
    }

    /**
     * @param Blueprint $table
     * @param bool $softDeletes
     * @param array|null $columnNames
     * @return void
     */
    public static function dropUserstampColumns(Blueprint $table, bool $softDeletes = false, array $columnNames = null)
    {
        if (is_null($columnNames)) {
            $columnNames = UserstampNames::baseColumnNames();
        }

        if (!$softDeletes && array_key_exists(2, $columnNames)) {
            unset($columnNames[2]);
        }

        foreach ($columnNames as $columnName) {
            $table->dropColumn($columnName);
        }

    }

}
