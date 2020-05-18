<footer class="footer">
    <div class="container">
        <p class="float-left">
            {{ $siteConfigs['footer'] }} <span style="color: #e27575;font-size: 14px;">❤</span>
            @if(!empty($siteConfigs['beian'])) |&nbsp;<span>备案号：{{ $siteConfigs['beian'] }}</span>@endif
        </p>

        <p class="float-right"><a href="mailto:{{ $siteConfigs['email'] }}">联系我们</a></p>
    </div>
</footer>
