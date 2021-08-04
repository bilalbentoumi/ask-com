<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model {

    protected $fillable = [
        'user_id', 'name'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

}
