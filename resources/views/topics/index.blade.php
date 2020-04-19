@extends('layouts.app')

@section('title', '专题列表')


@section('content')

    <div class="row mb-5">
        @foreach($topics as $topic)
        <div class="col-lg-6 col-md-6 post-list">
            <div class="card ">
                <div class="card-header bg-transparent">
                    <span>{{ $topic->name }}</span>
                    <a href="{{ route('topics.show', $topic) }}" style="float:right;">更多</a>
                </div>
                <div class="card-body">
                    {{-- 文章列表 --}}
                    @include('posts._post_list', ['posts' => $topic->posts])
                </div>
            </div>
        </div>
        @endforeach
    </div>

@endsection
