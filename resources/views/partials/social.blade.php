@php
    $socials = array_filter([
        'Instagram' => config('site.instagram'),
        'TikTok'    => config('site.tiktok'),
        'Facebook'  => config('site.facebook'),
    ]);
@endphp
@if ($socials)
  <div class="social">
    @foreach ($socials as $label => $url)
      <a class="btn btn-line" href="{{ $url }}" target="_blank" rel="noopener">{{ $label }}</a>
    @endforeach
  </div>
@endif
