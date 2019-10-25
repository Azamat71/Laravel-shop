<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'description', 'price',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}
