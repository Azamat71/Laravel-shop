<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'username', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'token',
    ];

    protected function create($array)
    {
        if (User::where('username', '=', $array['username']) -> exists()) {
            return true;
        }

        $user = new User;
        $user -> username = $array['username'];
        $user -> name = $array['name'];
        $user -> password = $array['password'];
        $user -> token = $array['token'];
        $user -> save();
        return false;
    }
    protected function login($array)
    {
        $validate_user = DB::table('users')
            ->select('username', 'password', 'is_admin')
            ->where('username', $array['username'])
            ->first();


        if ($validate_user && Hash::check($array['password'], $validate_user -> password))
        {
            return $validate_user -> is_admin;
        } else {
            return 2;
        }
    }

    protected function changePassword($array)
    {
        $result = DB::table('users')
            -> where('username', $array['username'])
            -> update(['password' => $array['password']]);
    }
}
