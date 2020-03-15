@if (count($posts))
    <ul class="list-unstyled">
        @foreach ($posts as $post)
            <li class="media">
                <div class="media-left">
                    <a href="#">
                        <svg class="icon" aria-hidden="true">
                            <use xlink:href="#{{ $post->category->icon }}"></use>
                        </svg>
{{--                        <span style="width: 20px; height: 20px;"><i class="media-object mr-3 iconfont {{ $post->category->icon }}" ></i></span>--}}
                    </a>
                    </div>

                    <div class="media-body">

                        <div class="media-heading mt-0 mb-1">
                            <a class="post-title" href="{{ route('posts.show', $post->id) }}">
                            {{ $post->title }}
                        </a>
                        <a class="float-right hide-on-mobile" href="{{ route('posts.show', $post->id) }}">
                            <span class="post-time"> {{ $post->created_at }} </span>
                        </a>
                    </div>
                </div>
            </li>

            @if ( ! $loop->last)
                <hr>
            @endif

        @endforeach
    </ul>

@else
    <div class="empty-block">暂无数据 ~_~ </div>
@endif
