<div class="inner">
    <div class="widget">
        <div class="widget-title">
            <p class="main-title">
                <span>Info Stranice</span><br>
                <span style="color: #a8ba00;">{{ $client->name }}</span>
            </p>
            <p class="widget-title-separator"><i class="icon-line-cross"></i></p>
        </div>
        <ul class="plain-menu cat">
            @foreach($pages as $page)
                <li>
                    <a href="{{ route('klijent.page', ['client' => $client->slug, 'page' => $page->slug]) }}" style="color: black;">{{ $page->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

