<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
    
class Customer extends Model implements Searchable
{
    use HasFactory, SoftDeletes;
  
    protected $guarded = ['id'];
   
    protected $table="customers";


    
    public function pet() {
        return $this->hasMany('App\Models\Pet','owner_id');
    }

    public function users() {
        return $this->hasOne('App\Models\Users','id','user_id');
    }

    public function getSearchResult(): SearchResult
    {
        $url = $this->id;
 
        return new SearchResult(
            $this,
            $this->fname.' '.$this->lname,
            $url
        );
    }
   
}
