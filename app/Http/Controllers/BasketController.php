<?php

namespace App\Http\Controllers;

use DB;
use App\History;
use App\Basket;
use App\Items;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function addToBasket(Request $request, $id)
    {
        $count = $request['count'];
        $username = (session() -> get('user'))['username'];
        $user_id = DB::table('users') -> select('id') -> where('username', $username) -> get() -> first() -> id;

        $basket = new Basket;
        $basket -> item_id = $id;
        $basket -> user_id = $user_id;
        $basket -> count   = $count;
        $basket -> save();

        return redirect('/basket');
    }

    public function getBasketPage()
    {
        $username = (session()->get('user'))['username'];
        $user_id = DB::table('users')->select('id')->where('username', $username)->get()->first()->id;
        $items = DB::table('baskets')
            ->select('items.name', 'items.description', 'items.price', 'baskets.id', 'baskets.count', 'baskets.item_id')
            ->join('users', 'users.id', '=', 'baskets.user_id')
            ->join('items', 'items.id', '=', 'baskets.item_id')
            ->where('baskets.user_id', $user_id)->get();

        $sum = 0;
        foreach ($items as $item)
        {
            $sum += (int) ($item -> price) * (int) ($item -> count);
        }

        return view('basket', compact('items','sum'));
    }

    public function removeElement($id)
    {
        $result = Basket::findOrFail($id);

        $result->delete();

        return redirect('/basket');
    }

    public function takeAll(Request $request)
    {
        $username = (session() -> get('user'))['username'];
        $user_id = DB::table('users') -> select('id') -> where('username', $username) -> get() -> first();
        $result = DB::table('baskets') -> select('user_id', 'item_id', 'count') -> where('user_id', $user_id -> id) -> get();

        foreach($result as $item)
        {
            $history = new History;
            $history -> user_id = $item -> user_id;
            $history -> item_id = $item -> item_id;
            $history -> count = $item -> count;
            $history -> save();
        }

        $new_result = DB::table('baskets') -> where('user_id', $user_id -> id) -> delete();

        return redirect('/');
    }
}
