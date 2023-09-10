<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
class Pet extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = ['breed_id','pet_name', 'gender', 'pet_age','owner_id','img_path'];



    public function customer() {
        return $this->belongsTo('App\Models\Customer');
    }

    public function services() {
        // return $this->belongsTo('App\Models\Albums');
        return $this->belongsToMany('App\Models\Service');
        // ->withPivot(['id','album_id']);

    }


      public function consult() {
        return $this->belongsToMany('App\Models\Disease','checkup_infos','pet_id','disease_id');
     }

     public function getSearchResult(): SearchResult
    {
        $url = $this->id;
 
        return new SearchResult(
            $this,
            $this->pet_name,
            $url
        );
    }

}
