<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guildwar extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id', 'uid', 'rank', 'gameid', 'attack_times', 'contribution', 'reward', 'is_delete'
    ];
}


// id、uid、rank、gameid、attack_times、contribution、reward