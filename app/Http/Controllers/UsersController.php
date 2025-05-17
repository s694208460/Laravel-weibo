<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Routing\Controller;

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
        $this->authorize('update', $user);
        return view('users.show', compact('user'));
    }

    public function store(UserRequest $request)
    {

        $validatedData = $request->validated()->ignore(['']);

        $user = User::create($validatedData);

        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $validatedData = $request->validated();
        $user->update($validatedData);

        session()->flash('success', '用户信息更新成功！');
        return redirect()->route('users.show', [$user]);
    }
    public function destroy(User $user)
    {
        $this->authorize('update', $user);
        $user->delete();
        session()->flash('success', '删除成功！');
        return redirect()->route('users.index');
    }

}
