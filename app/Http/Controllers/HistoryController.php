<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
//    public function getHistory()
//    {
//        $username = (session()-> get('user'))['username'];
//        $user_id = DB::table('users') -> select('user_id') -> where('username', $username) -> get() -> first() -> id;
//
//        $result = DB::table('history') -> where('user_id', $user_id) -> get();
//        return view('history', compact('result'));
//    }
}
