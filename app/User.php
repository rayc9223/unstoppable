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
        $query = Auth::user()->roles()->first();
        if ($query) {
            if ($query->role == 'admin' || $query->role == 'leader') {
                return true;
            }
        }
        return false;
    }

    public function roles(){
        return $this->belongsToMany('App\Role', 'role_users', 'user_id', 'role_id');
    }

    public function scopeByLineUserId($query, $lineUserId)
    {
        return $query->where('line_userid', $lineUserId);
    }
}








