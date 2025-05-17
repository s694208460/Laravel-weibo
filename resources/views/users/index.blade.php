@extends('layouts.default')
@section('title', '用户列表')
@section('content')
@foreach ($users as $user)
<div class="card mb-3">
    <div class="card-header">
        <h5>{{ $user->name }}</h5>
    </div>
    <div class="card-body">
        <p>Email: {{ $user->email }}</p>
        <a href="{{ route('users.show', $user) }}" class="btn btn-primary">查看</a>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-secondary">编辑</a>
        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">删除</button>
        </form>
    </div>
@endforeach
<div class="mt-3">
    {!! $users->render() !!}
</div>
@endsection
