<?php

namespace Codiliateur\Userstamps\Support;

class UserstampNames
{
    const CREATED = 0;
    const UPDATED = 1;
    const DELETED = 2;

    /**
     * @return array
     */
    public static function baseColumnNames()
    {
        static $baseColumnNames;

        if (is_null($baseColumnNames)) {
            $baseColumnNames = config('codiliateur.userstamps.columns', [
                self::CREATED => 'created_by',
                self::UPDATED => 'updated_by',
                self::DELETED => 'deleted_by',
            ]);
        }

        return $baseColumnNames;
    }

    /**
     * @param $val
     * @return mixed|null
     */
    public static function baseColumnName($val)
    {
        return self::baseColumnNames()[$val];
    }
}
