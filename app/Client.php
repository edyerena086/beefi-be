<?php

namespace MetodikaTI;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function user()
    {
    	return $this->belongsTo('MetodikaTI\User');
    }
}
