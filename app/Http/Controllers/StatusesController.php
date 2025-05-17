<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Status;
use App\Http\Requests\UserRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {

        $request->user()->statuses()->create([
            'content' => $request->input('content'),
        ]);
        session()->flash('success', '发布成功！');
        return redirect()->back();
    }

    public function destroy(Status $status)
    {
        Gate::authorize('destroy-status', $status);
        $status->delete();
        session()->flash('success', '删除成功！');
        return redirect()->back();
    }
}
