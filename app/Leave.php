<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $primaryKey = 'lid';

    public $timestamps = false;

    protected $fillable = [
        'uid','gameid', 'reason', 'call_leave_time'
    ];
}
