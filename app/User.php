<?php

namespace App;

use Auth;
use App\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'uid';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gameid', 'lineid','title', 'thumbnail', 'team_line_up', 'approx_entry_time', 'capability', 'roll_qty','guildwar_times', 'last_update'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin(){
        if(Role::where('uid', Auth::user()->uid)->value('role') == 'Admin'){
            return true;
        }
        return false;
    }
}
