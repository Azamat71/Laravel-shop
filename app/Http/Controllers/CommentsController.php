<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Comments;

class CommentsController extends Controller
{
    public function addComments(Request $request)
    {
        $desciption = $request['description'];
        $id = $request['id'];
        $username = (session() -> get('user'))['username'];

        $comment = new Comments;
        $user_id = DB::table('users') -> select('id') -> where ('username', $username) -> get() -> first();

        $comment -> description = $desciption;
        $comment -> user_id = $user_id -> id;
        $comment -> item_id = $id;

        $comment -> save();

        return redirect('/item/' . $id);
    }
}
