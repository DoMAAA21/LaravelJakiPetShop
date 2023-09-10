<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

     public function pets() {
        // return $this->belongsTo('App\Models\Albums');
        return $this->belongsToMany('App\Models\Pets');
        // ->withPivot(['id','album_id']);

    }

  
}
