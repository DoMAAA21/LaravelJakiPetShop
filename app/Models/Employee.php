<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
   
    protected $table="employees";

    public function users() {
        return $this->hasOne('App\Models\Users','id','user_id');
    }
}
