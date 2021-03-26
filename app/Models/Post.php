<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id','title','text',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function users() {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
