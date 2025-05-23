<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['create', 'store', 'show']
        ]);
        $this->middleware('guest', [
            'only' => ['create']
        ]);
        $this->middleware('throttle:10,60', [
            'only' => ['store']
        ]);
    }
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        Gate::authorize('update-user', $user);
        $statuses = $user->statuses()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('users.show', compact('user', 'statuses'));
    }

    public function store(UserRequest $request)
    {

        $validatedData = $request->validated();

        $user = User::create($validatedData);
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
        if (Auth::attempt($validatedData, $request->has('remember'))) {
            if (Auth::user()->activated) {
                session()->flash('success', '欢迎回来！');
                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
            } else {
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }
    public function edit(User $user)
    {
        Gate::authorize('update-user', $user);
        return view('users.edit', compact('user'));
    }
    public function update(UserRequest $request, User $user)
    {
        Gate::authorize('update-user', $user);
        $validatedData = $request->validated();
        $user->update($validatedData);

        session()->flash('success', '用户信息更新成功！');
        return redirect()->route('users.show', [$user]);
    }
    public function destroy(User $user)
    {
        Gate::authorize('destroy-user', $user);
        $user->delete();
        session()->flash('success', '删除成功！');
        return redirect()->route('users.index');
    }
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();
        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }

    public function followings(User $user)
    {
        $users = $user->followings()->paginate(30);
        $title = $user->name . '关注的人';
        return view('users.show_follow', compact('users', 'title'));
    }

    public function followers(User $user)
    {
        $users = $user->followers()->paginate(30);
        $title = $user->name . '的粉丝';
        return view('users.show_follow', compact('users', 'title'));
    }
}
