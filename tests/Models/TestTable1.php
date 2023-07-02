<?php

namespace Codiliateur\Userstamps\Tests\Models;

use Codiliateur\Userstamps\Models\HasUserstamps;
use Illuminate\Database\Eloquent\Model;


class TestTable1 extends Model
{
    use HasUserstamps;

    protected $table = 'test_table_1';
}
