<div class="widget widget-twitter-feed clearfix bottommargin-lg">
    <h4>Zadnje Novosti</h4>

  @foreach ($latest as $page)
        <div class="spost clearfix">
            <div class="entry-image">
                @if (isset($page->image) && ! empty($page->image))
                    <a href="#"><img src="{{ Image::cache(function ($image) use ($page) { $image->make(asset($page->image))->fit(100)->crop(70, 70, 10, 10)->encode('data-url'); }, env('CACHE_LIFETIME')) }}" alt="{{ $page->name }}"></a>
                @endif
            </div>
            <div class="entry-c">
                <div class="entry-title">
                    @if (isset($page->subcat))
                        <h4><a href="{{ route('blogovi', ['cat' => $page->subcat->parent->slug, 'subcat' => $page->subcat->slug, 'page' => $page->slug]) }}">{{ $page->name }}</a></h4>
                    @else
                        <h4><a href="{{ route('blogovi', ['cat' => $page->cat->slug, 'subcat' => $page->slug]) }}">{{ $page->name }}</a></h4>
                    @endif
                </div>
                <ul class="entry-meta">
                    <li><i class="icon-calendar3"></i> {{ \Carbon\Carbon::make($page->created_at)->locale('hr')->format('d.m.Y') }}</li>
                    @if (isset($page->blocks->groupBy('type')['image']))
                        <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                    @endif
                    @if (isset($page->blocks->groupBy('type')['pdf']))
                        <li><a href="#"><i class="icon-download"></i></a></li>
                    @endif
                </ul>
            </div>
        </div>
    @endforeach

</div>
