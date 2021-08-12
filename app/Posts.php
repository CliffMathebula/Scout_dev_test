<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    //
    
    protected $fillable = ['id', 'author_id', 'title','content', 'posted_at'];
}
