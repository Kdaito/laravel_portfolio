<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = [
        'user_id', 'post_id', 'text'
    ];

    public function post() {
        return $this->belongsTo('App\Models\Post');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
