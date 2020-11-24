<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'post_id'
    ];

    public function post(){
        return $this->belongsTo('App\Models\Post');
    }

    public function user(){
        $post = Post::find($this->post_id);
        return User::find($post->user_id);

    }
}
