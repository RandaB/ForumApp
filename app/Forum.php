<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $with=['children'];
public function children(){
    return $this->hasMany(Forum :: Class,'respond_to_id');
}

}
