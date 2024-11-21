<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $casts =[
        'is_active' => 'bool',
    ];

    protected $fillable = [
        'key',
        'role',
        'is_active'

    ];
}
