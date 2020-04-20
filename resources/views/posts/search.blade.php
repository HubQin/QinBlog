@extends('layouts.app')
@section('title', '搜索结果')
@section('content')
    <div class="row mb-5">
        <div class="col-lg-9 col-md-9 post-list">
            <div class="card">
                <div class="card-header bg-transparent">
                    搜索 <span style="color: red;">{{ request()->get('query') }}</span> 的结果
                </div>
                <div class="card-body">
                    @if (count($posts))
                        <ul class="list-unstyled">
                            @foreach ($posts as $post)
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-heading mt-0 mb-1">
                                            <a class="post-title mb-2" href="{{ $post->link() }}">
                                                {!! $highlighter->highlight($post->title, request()->get('query')) !!}
                                            </a>
                                            <div class="mt-2 mb-2 text-secondary">
                                                {!! $highlighter->highlight($post->excerpt, request()->get('query')) !!}
                                            </div>
                                            <div class="article-meta text-secondary">
                                                <span>
                                                    {{ $post->category->name }}
                                                    ⋅
                                                    <i class="fa fa-calendar"></i>
                                                    {{ $post->created_at->format('Y-m-d') }}
                                                    ⋅
                                                    <i class="far fa-comment"></i>
                                                    {{ $post->comment_count }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @if ( ! $loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        </ul>
                        {{-- 分页 --}}
                        <div class="mt-5">
                            {!! $posts->appends(request()->except('page'))->render() !!}
                        </div>
                    @else
                        <div class="empty-block">暂无数据 ~_~ </div>
                    @endif
                </div>
            </div>
        </div>

    </div>


@endsection
