<?php

namespace Modules\Blog_Projet\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name','slug'];
    public function articles(){

        return $this->hasMany(Article::class);
    }
}
