<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
    ];

    public function images(){
        return $this->hasMany('App\Models\Image');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
