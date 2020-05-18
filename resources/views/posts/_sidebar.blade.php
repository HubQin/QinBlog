@if (!empty($siteConfigs['notice']))
    <div class="card mb-4">
        <div class="card-body pt-2">
            <div class="text-center mt-1 mb-0 text-muted">站点公告</div>
            <hr class="mt-2 mb-3">
            <p>{{ $siteConfigs['notice'] }}</p>
        </div>
    </div>
@endif
@if (!empty($siteConfigs['qr_wechat_office']))
    <div class="card mb-4">
        <div class="card-body pt-2">
            <div class="text-center mt-1 mb-0 text-muted">公众号</div>
            <hr class="mt-2 mb-3">
            <img src="{{ $siteConfigs['qr_wechat_office'] }}" alt="公众号二维码">
        </div>
    </div>
@endif
@if (!empty($siteConfigs['qr_weapp']))
    <div class="card mb-4">
        <div class="card-body pt-2">
            <div class="text-center mt-1 mb-0 text-muted">小程序</div>
            <hr class="mt-2 mb-3">
            <img src="{{ $siteConfigs['qr_weapp'] }}" alt="小程序二维码">
        </div>
    </div>
@endif

@if (count($tags))
    <div class="card mb-4">
        <div class="card-body pt-2">
            <div class="text-center mt-1 mb-0 text-muted">标签</div>
            <hr class="mt-2 mb-3">
            @foreach ($tags as $tag)
                <a href="{{ route('tags.show', $tag) }}" class="btn btn-outline-{{ $tag->color }} btn-sm m-1">{{ $tag->name }}({{ $tag->post_count }})</a>
            @endforeach
        </div>
    </div>
@endif

@if (count($categories))
    <div class="card mb-4">
        <div class="card-body pt-2">
            <div class="text-center mt-1 mb-0 text-muted">分类</div>
            <hr class="mt-2 mb-3">
            @foreach ($categories as $category)
                <a class="media mt-1" href="{{ route('categories.show', $category) }}">
                    <div class="media-body sidebar-media-body">
                        <span class="media-heading text-muted">{{ $category->name }}</span>
                        <span class="media-heading text-muted">{{ $category->post_count }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif

@if (count($archives))
    <div class="card mb-4">
        <div class="card-body pt-2">
            <div class="text-center mt-1 mb-0 text-muted">归档</div>
            <hr class="mt-2 mb-3">
            @foreach ($archives as $date => $archive)
                <a class="media mt-1" href="{{ route('archives.show', ['year_month' => $date]) }}">
                    <div class="media-body sidebar-media-body">
                        <span class="media-heading text-muted">{{ $date }}</span>
                        <span class="media-heading text-muted">{{ count($archive) }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
@if (count($links))
    <div class="card mt-4">
        <div class="card-body pt-2">
            <div class="text-center mt-1 mb-0 text-muted">友情链接</div>
            <hr class="mt-2 mb-3">
            @foreach ($links as $link)
                <a class="media mt-1" href="{{ $link->url }}" target="_blank">
                    <div class="media-body">
                        <span class="media-heading text-muted">{{ $link->name }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
