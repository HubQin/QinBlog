@if (count($posts))
    <ul class="list-unstyled">
        @foreach ($posts as $post)
            <li class="media">
                <div class="media-left">
                    <a href="#">
                        <svg class="icon" aria-hidden="true">
                            <use xlink:href="#{{ $post->category->icon }}"></use>
                        </svg>
                    </a>
                </div>

                <div class="media-body">

                    <div class="media-heading mt-0 mb-1">
                        <a class="post-title" href="{{ $post->link() }}">
                            {{ $post->title }}
                        </a>
                        @if(!isset($topics))
                        <a class="float-right hide-on-mobile" href="{{ $post->link() }}">
                            <span class="post-time"> {{ $post->created_at }} </span>
                        </a>
                        @endif
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
