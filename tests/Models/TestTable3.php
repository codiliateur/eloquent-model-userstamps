<?php

namespace Codiliateur\Userstamps\Tests\Models;

use Codiliateur\Userstamps\Models\HasUserstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestTable3 extends Model
{
    use HasUserstamps;
    use SoftDeletes;

    const CREATED_BY = 'created_by_user_id';
    const UPDATED_BY = 'updated_by_user_id';
    const DELETED_BY = 'deleted_by_user_id';

    protected $table = 'test_table_3';
}
