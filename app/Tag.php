<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name'
    ];

    public function rooms() {
        return $this->belongsToMany('App\Room', 'room_tag', 'tag_id', 'room_id');
    }
}
