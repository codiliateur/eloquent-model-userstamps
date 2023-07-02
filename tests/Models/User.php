<?php

namespace Codiliateur\Userstamps\Tests\Models;

use Codiliateur\Userstamps\Models\HasUserstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory;

    public $incrementing = false;
}
