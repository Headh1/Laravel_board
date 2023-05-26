<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boards extends Model
{
    use HasFactory ,SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id','created_at'];
}
