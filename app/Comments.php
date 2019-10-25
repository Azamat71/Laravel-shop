<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    public function addComment($username, $description)
    {
        $comment = new Comments;
        $user_id = DB::table('users') -> select('id') -> where ('username', $username) -> get() -> first();
        dd($user_id, $username, $description);
    }
}
