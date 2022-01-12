<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sections extends Model
{
    protected $fillable=[
        'section_name',
        'description',
        'created_by'
    ];
    public function products(){
        return $this->hasMany('App\products');
    }
}
