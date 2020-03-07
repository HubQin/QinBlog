@extends('layouts.app')

@if(isset($category))
    @section('title', $category->name)
@elseif(isset($tag))
    @section('title', $tag->name)
@else
    @section('title', '文章列表')
@endif


@section('content')

    <div class="row mb-5">
        <div class="col-lg-9 col-md-9 post-list">
            <div class="card ">

                <div class="card-header bg-transparent">
                    <span style="color: #a8a8a8">{{ \Illuminate\Foundation\Inspiring::quote() }}</span>
                </div>

                <div class="card-body">
                    {{-- 文章列表 --}}
                    @include('posts._post_list', ['posts' => $posts])
                    {{-- 分页 --}}
                    <div class="mt-5">
                        {!! $posts->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 sidebar">
            @include('posts._sidebar')
        </div>
    </div>

@endsection
