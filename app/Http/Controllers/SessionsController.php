<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    public function create()
    {
        return view('sessions.create');
    }
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials, )) {
            session()->flash('success', '欢迎回来！');
            return redirect()->route('users.show', [auth()->user()]);
        } else {
            session()->flash('danger', '抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }
    public function destroy()
    {
        auth()->logout();
        session()->flash('success', '您已成功退出！');
        return redirect()->route('home');
    }
}
