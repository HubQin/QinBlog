@extends('layouts.app')

@section('title', $post->title)
@section('description', '##')

@section('content')

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="card ">
                <div class="card-body">
                    <h1 class="text-center mt-3 mb-3">
                        {{ $post->title }}
                    </h1>

                    <div class="article-meta text-center text-secondary">
                        {{ $post->created_at->diffForHumans() }}
                        ⋅
                        <i class="far fa-comment"></i>
                        {{ $post->reply_count }}
                    </div>

                    <div class="post-body markdown-body mt-4 mb-4">
                        {!! $post->body !!}
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
                    @includeWhen(Auth::check(), 'posts._comment_box', ['post' => $post])
                    @include('posts._comment_list', ['comments' => $post->comments()->with(['user:id,name,avatar', 'replies', 'replies.user:id,name,avatar'])->get()])
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
            <div class="card ">
                <div class="card-body toc-container">
                    <div class="text-center">
                        目录
                    </div>
                    <hr>
                    <div class="media">
                        <div class="table-of-contents">
                            <toc target-class=".post-body">

                            </toc>
                        </div>
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
        })

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
    </script>
@endsection
