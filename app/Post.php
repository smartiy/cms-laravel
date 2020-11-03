<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    //
    // protected $fillable = ['title', 'blabla'];
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    //mutator lekcija 201
    // public function setPostImageAttribute($value) {
    //     $this->attributes['post_image'] = asset($value);
    // }

    //accessor
    public function getPostImageAttribute($value) {
        return asset($value);
    }

}

