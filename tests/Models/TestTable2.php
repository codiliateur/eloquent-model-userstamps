<?php

namespace Codiliateur\Userstamps\Tests\Models;

use Codiliateur\Userstamps\Models\HasUserstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestTable2 extends Model
{
    use HasUserstamps;
    use SoftDeletes;

    protected $table = 'test_table_2';
}
