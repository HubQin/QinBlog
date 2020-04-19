@extends('layouts.app')

@if(isset($category))
    @section('title', $category->name)
@elseif(isset($tag))
    @section('title', $tag->name)
@elseif(isset($topic))
    @section('title', $topic->name)
@elseif(isset($year) && isset($month))
    @section('title', $year . '年' . $month . '月归档')
@else
    @section('title', '文章列表')
@endif


@section('content')

    <div class="row mb-5">
        <div class="col-lg-9 col-md-9 post-list">
            <div class="card ">

                <div class="card-header bg-transparent">
                    <span>
                        @if(isset($category))
                            分类：{{ $category->name }}
                        @elseif(isset($tag))
                            标签：{{ $tag->name }}
                        @elseif(isset($topic))
                            专题：{{ $topic->name }}
                            @elseif(isset($year) && isset($month))
                            归档：{{ $year }}年{{ $month }}月
                        @else
                            文章列表
                        @endif
                    </span>
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
