@include('shared._errors')

<div class="comment-box">
    <form action="{{ route('comments.store') }}" method="POST" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <div class="form-group">
            <textarea class="form-control" rows="3" placeholder="支持Markdown语法" name="content"></textarea>
        </div>
        @auth
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-comment mr-1"></i> 评论</button>
        @elseauth
            <button type="submit" class="btn btn-secondary btn-sm" disabled title="请先登录">登录后可评论</button>
        @endauth
    </form>
</div>
<hr>
