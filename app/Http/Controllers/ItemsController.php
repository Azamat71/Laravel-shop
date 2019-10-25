<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Items;
use App\Comments;

class ItemsController extends Controller
{
    public function getAll()
    {
        $items = Items::all();
        return view('welcome', compact('items'));
    }

    public function getOne($id)
    {
        $item = Items::find($id);
        $comments = DB::table('comments')
            ->select('comments.user_id','comments.item_id','comments.description', 'users.name', 'users.is_admin')
            ->join('users','users.id','=','comments.user_id')
            ->where('comments.item_id',$id)
            ->get();

        return view('item', compact('item', 'comments'));
    }
}
