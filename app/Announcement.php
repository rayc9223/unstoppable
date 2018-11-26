<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $primaryKey = 'aid';

    public $timestamps = false;

    protected $fillable = [
        'aid', 'uid', 'type', 'content', 'updated_by', 'last_update'
    ];
}
