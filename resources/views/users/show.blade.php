@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
            <div class="card ">
                <img class="card-img-top" src="{{ $user->avatar ?? asset('images/default_avartar.jpg')}}" alt="{{ $user->name }}">
                <div class="card-body">
                    <h5><strong>个人简介</strong></h5>
                    <p>{{ $user->introduction }}</p>
                    <hr>
                    <h5><strong>注册于</strong></h5>
                    <p>{{ $user->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="card ">
                <div class="card-body">
                    <h1 class="mb-0" style="font-size:22px;">{{ $user->name }}
                        <small>{{ $user->email }}</small>
                    </h1>
                </div>
            </div>
            <hr>

            {{-- 用户发布的内容 --}}
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link bg-transparent @if(!query_if('tab', 'comments')) active @endif" href="{{ route('users.show', $user->id) }}">
                                @if(auth()->id() == $user->id) 我的文章 @else Ta 的文章 @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(query_if('tab', 'comments')) active @endif" href="{{ route('users.show', [$user->id, 'tab' => 'comments']) }}">
                                @if(auth()->id() == $user->id) 我的评论 @else Ta 的评论 @endif
                            </a>
                        </li>
                    </ul>
                    @if(query_if('tab', 'comments'))
                        @include('users._comments', ['comments' => $user->comments()->recently()->paginate(5)])
                    @else
                        @include('users._posts', ['posts' => $user->posts()->recently()->paginate(5)])
                    @endif
                </div>
            </div>

        </div>
    </div>
@stop
