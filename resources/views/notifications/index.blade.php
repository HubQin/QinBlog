@extends('layouts.app')

@section('title', '我的通知')

@section('content')
    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="card ">
                <div class="card-body">
                    <h3 class="text-xs-center">
                        <i class="far fa-bell" aria-hidden="true"></i> 我的通知
                        @if(Auth::id() === 1)
                        <a href="{{ url('/admin/comments?_scope_=approved') }}" target="_blank" class="btn btn-success btn-sm" style="float: right;">审核评论</a>
                        @endif
                    </h3>
                    <hr>
                    @if ($notifications->count())
                        <div class="list-unstyled notification-list">
                            @foreach ($notifications as $notification)
                                @include('notifications.types._' . Str::snake(class_basename($notification->type)))
                            @endforeach
                            {!! $notifications->render() !!}
                        </div>
                    @else
                        <div class="empty-block">没有消息通知！</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
