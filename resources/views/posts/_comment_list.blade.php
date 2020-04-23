<ul class="list-unstyled @if(isset($comments[0]['parent_id'])) nested-comment @endif">
    @foreach ($comments as $index => $comment)
        <li class=" media" name="comment{{ $comment->id }}" id="comment{{ $comment->id }}">
            <div class="media-left">
                <a href="#">
                    <img class="media-object img-thumbnail mr-3" alt="{{ $comment->user->name }}"
                         src="{{ $comment->user->avatar }}" style="width:48px;height:48px;"/>
                </a>
            </div>
            <div class="media-body">
                <div class="media-heading mt-0 mb-1 text-secondary">
                    <a href="#" title="{{ $comment->user->name }}">
                        {{ $comment->user->name }}
                        @if($comment->user->id === 1)
                            <span class="badge badge-success">博主</span>
                            @endif
                    </a>
                    <span class="text-secondary"> • </span>
                    <span class="meta text-secondary"
                          title="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</span>
                    {{-- 删除按钮 --}}
                    <div class="meta float-right comment-title-right">
                        @can('own', $comment)
                        <form action="{{ route('comments.destroy', $comment->id) }}"
                              onsubmit="return confirm('确定要删除此评论？');"
                              method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-default btn-xs pull-left text-secondary">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                        @endcan
                        @auth
                            <span class="reply-icon" title="回复" style="display: none;"><i class="fa fa-reply"></i></span>
                        @endauth
                    </div>
                </div>
                <div class="comment-content text-secondary">
                    @if(! $comment->approved)
                        评论审核中
                    @else
                    {!! $comment->content !!}
                    @endif
                </div>
                {{-- 回复表单 --}}
                @auth
                    <div class="reply-box mt-3" style="display: none;">
                        <form action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="支持 Markdown 语法" name="content"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-reply mr-1"></i> 回复</button>
                            <button class="btn btn-light btn-sm reply-box-cancel-btn">取消</button>
                        </form>
                    </div>
                @endauth
            </div>
        </li>
        @includeWhen(count($comment->replies), 'posts._comment_list', ['comments' => $comment->replies])

        @if ( ! $loop->last)
            <hr>
        @endif
    @endforeach
</ul>
