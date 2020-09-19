<div class="widget widget-twitter-feed clearfix bottommargin-lg">
    <h4>Zadnje Novosti</h4>

  @foreach ($latest as $blog)
        <div class="spost clearfix">
          <!--  <div class="entry-image">
                @if (isset($blog->image) && ! empty($blog->image))
                    <a href="#"><img src="{{ Image::cache(function ($image) use ($blog) { $image->make(asset($blog->image))->fit(100)->crop(70, 70, 10, 10)->encode('data-url'); }, env('CACHE_LIFETIME')) }}" alt="{{ $blog->title }}"></a>
                @endif
            </div>-->
            <div class="entry-c">
                <div class="entry-title">
                    @if (isset($blog->subcat))
                        <h4><a href="{{ route('blogovi', ['cat' => $blog->cat->slug, 'subcat' => $blog->subcat->slug, 'blog' => $blog->slug]) }}">{{ $blog->title }}</a></h4>
                    @else
                        <h4><a href="{{ route('blogovi', ['cat' => $blog->cat->slug, 'subcat' => $blog->slug]) }}">{{ $blog->title }}</a></h4>
                    @endif
                </div>
                <ul class="entry-meta">
                    <li><i class="icon-calendar3"></i> {{ \Carbon\Carbon::make(isset($blog->publish_date) ? $blog->publish_date : $blog->updated_at)->locale('hr')->format('d.m.Y') }}</li>
                    @if (isset($blog->blocks->groupBy('type')['image']))
                        <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                    @endif
                    @if (isset($blog->blocks->groupBy('type')['pdf']))
                        <li><a href="#"><i class="icon-download"></i></a></li>
                    @endif
                </ul>
            </div>
        </div>
    @endforeach







</div>
