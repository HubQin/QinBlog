@extends('layouts.app')

@section('title', $post->title)
@section('description', '##')

@section('content')
    <!-- Back to top button -->
    <a id="back-to-top"></a>
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="card ">
                <div class="card-body">
                    <h1 class="text-center mt-3 mb-3">
                        {{ $post->title }}
                    </h1>

                    <div class="article-meta text-center text-secondary">
                        <a href="{{ route('categories.show', ['category' => $post->category->id]) }}">
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#{{ $post->category->icon }}"></use>
                            </svg>
                        </a>
                        <span>
                            &nbsp;{{ $post->category->name }}
                            ⋅
                            {{ $post->created_at->format('Y-m-d') }}
                            ⋅
                            <i class="far fa-comment"></i>
                            {{ $post->comment_count }}
                        </span>

                    </div>

                    <div class="post-body markdown-body mt-4 mb-4" v-html="postBody">

                    </div>

                    @can('own', $post)
                    <div class="operate">
                        <hr>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
                            <i class="far fa-edit"></i> 编辑
                        </a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="post"
                              style="display: inline-block;"
                              onsubmit="return confirm('确定要删除吗？');">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                <i class="far fa-trash-alt"></i> 删除
                            </button>
                        </form>
                    </div>
                    @endcan

                </div>
            </div>
            {{-- 用户评论列表 --}}
            <div class="card post-comment mt-4">
                <div class="card-body">
                    @include('posts._comment_box', ['post' => $post])
                    @include('posts._comment_list', ['comments' => $post->comments()->with(['user:id,name,avatar', 'replies', 'replies.user:id,name,avatar'])->get()])
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
            @if($post->topic_id > 0)
                <div class="card mb-4">
                    <div class="card-body toc-container">
                        <div class="text-center">
                            专题文章
                        </div>
                        <hr>
                        <div class="table-of-contents">
                            <ul>
                                @foreach($topicPosts as $topicPost)
                                    <li>
                                        @if($topicPost->id === $post->id)
                                            {{ $topicPost->title }}
                                        @else
                                            <a href="{{ route('posts.show', $topicPost) }}">{{ $topicPost->title }}</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-body toc-container">
                    <div class="text-center">
                        目录
                    </div>
                    <hr>
                    <div class="table-of-contents">
                        <toc target-class=".post-body">

                        </toc>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        const app = new Vue({
            el: "#app",
            data : {
                postBody: {!! json_encode($post->body) !!},
            }
        })

        let auth = "{{ \Auth::check() }}";

        if(auth) {
            document.querySelectorAll("li[name^='comment']").forEach((item) => {
                let replyIcon = item.getElementsByClassName("reply-icon")[0];
                let replyBox = item.getElementsByClassName("reply-box")[0];
                let cancelBtn = item.getElementsByClassName("reply-box-cancel-btn")[0];

                item.addEventListener('mouseover', function () {
                    replyIcon.style.display = "block";
                });
                item.addEventListener('mouseout', function () {
                    replyIcon.style.display = "none";
                });
                replyIcon.addEventListener('click', function () {
                    replyBox.style.display = "block";
                })
                cancelBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    this.parentNode.parentNode.style.display = "none";
                })
            })
        }

        let btn = $('#back-to-top');

        $(window).scroll(function() {
            if ($(window).scrollTop() > 300) {
                btn.addClass('back-to-top-show');
            } else {
                btn.removeClass('back-to-top-show');
            }
        });

        btn.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop:0}, '300');
        });
    </script>
@endsection
