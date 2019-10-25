<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use DB;
use App\User;
use App\Items;
use App\category;

class UserController extends Controller
{
    // all views
    public function getAdminPage()
    {
        if (session() -> has('user') && (session() -> get('user'))['type'] == 0) {
            return redirect('/');
        }

        $items = Items::all();
        return view('admin', compact('items'));
    }
    public function getLoginPage()
    {
        if (session() -> has('user')) {
            return redirect('/');
        }

        return view('login');
    }
    public function getHistoryPage()
    {
        if (!(session() -> has('user'))) {
            return redirect('/');
        }

        $username = (session()-> get('user'))['username'];
        $user_id = DB::table('users') -> select('id') -> where('username', $username) -> get() -> first() -> id;

        $result = DB::table('histories') -> join('items', 'items.id', '=', 'histories.item_id') -> where('user_id', $user_id) -> get();
        return view('history', compact('result'));
    }
    public function getAdminHistoryPage()
    {
        if (session() -> has('user') && (session() -> get('user'))['type'] == 0) {
            return redirect('/');
        }

        $result = DB::table('histories') -> join('items', 'items.id', '=', 'histories.item_id') -> join('users', 'users.id', '=', 'histories.user_id') -> get();
        return view('history', compact('result'));
    }
    public function getRegistrationPage()
    {
        if (session() -> has('user')) {
            return redirect('/');
        }

        return view('registration');
    }

    // all functions
    public function makeRegistration(Request $request)
    {
        $validation = $this -> validateUser($request->all());
        if ($validation -> fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }
        $result = $this -> createUser($request -> all(), $this -> getToken());

        if ($result)
        {
            return redirect('registration') -> with('exist', 'Your accounts username is already exist');
        } else {
            return redirect('login') -> with('success', 'Your account is activated. You can login now.');
        }
    }
    public function makeLogin(Request $request)
    {
        $result = $this -> loginUser($request -> all());

        if ($result == 0)
        {
            Session::put('user', ['username' => $request -> username, 'type' => $result]);
            return redirect('/');
        } else if ($result == 1) {
            Session::put('user', ['username' => $request -> username, 'type' => $result]);
            return redirect('/admin');
        } else {
            return redirect('login') -> with('error', 'Your username or password were wrong!');
        }
    }

    // all rest functions
    protected function createUser(array $data, $token)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'token' => $token
        ]);
    }
    protected function loginUser(array $data)
    {
        return User::login([
            'username' => $data['username'],
            'password' => $data['password']
        ]);
    }
    public function getToken() {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    // admins
    public function addElement(Request $request)
    {
        $category = new category;
        $item = new Items;
        $item -> name = $request['name'];
        $item -> description = $request['description'];
        $item -> price = $request['price'];
        $item -> category = $request['category'];
        $item -> save();

        return redirect('/admin');
    }
    public function removeElement($id)
    {
        $result = Items::findOrFail($id);

        $result->delete();

        return redirect('/admin');
    }
    public function deleteUser()
    {
        session() -> pull('user', 'default');
        return redirect('login');
    }

    // validation

    protected function validateUser(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:7',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
            ]
        ]);
    }
    public function changePassword(Request $request)
    {
        $new_password = $request -> password;
        $username = (session() -> get('user'))['name'];

        User::changePassword(['username' => $username, 'password' => bcrypt($new_password)]);
        return redirect('/');
    }
    public function takeAll(Request $request)
    {
        User::takeAll();
        return redirect('/');
    }
}
