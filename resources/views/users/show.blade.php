@extends('layouts.default')
@section('title', $user->name)

@section('content')
<div class="row">
  <div class="offset-md-2 col-md-8">
    @if (Auth::check())
      @include('users._follow_form')
    @endif
    <section class="stats mt-2">
        @include('shared._stats', ['user' => $user])
      </section>
    <section class="status">
      @if ($statuses->count() > 0)
        <ul class="list-unstyled">
          @foreach ($statuses as $status)
            @include('statuses._status')
          @endforeach
        </ul>
        <div class="mt-5">
          {!! $statuses->render() !!}
        </div>
      @else
        <p>没有数据！</p>
      @endif
    </section>
  </div>
</div>
@stop
