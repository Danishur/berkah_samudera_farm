@extends('layouts.app')

@section('title', $goat->name)
@section('description', $goat->name.' ('.$goat->code.'), '.$goat->weight_kg.' kg, umur '.$goat->age_months.' bulan. Jual kambing Boer Mojokerto.')
@section('og_image', $goat->photo_url)

@section('content')
@php
    $photos = array_values(array_filter(array_merge([$goat->photo_url], $goat->gallery_urls)));
@endphp
<div class="wrap">
  <a class="back" href="{{ route('goats.index', ['jenis' => $goat->breed]) }}">Kembali ke daftar kambing</a>

  <div class="detail">
    <div class="media">
      <div class="photo main">
        <span class="badge s-{{ $goat->status }}">{{ ucfirst($goat->status) }}</span>
        <button type="button" id="openPhoto" aria-label="Perbesar foto">
          <img id="mainPhoto" src="{{ $photos[0] }}" alt="{{ $goat->name }}, {{ $goat->breed_label }}">
        </button>
      </div>

      @if (count($photos) > 1)
        <div class="thumbs" role="group" aria-label="Foto kambing">
          @foreach ($photos as $i => $url)
            <button type="button" class="thumb {{ $i === 0 ? 'on' : '' }}" aria-label="Lihat foto {{ $i + 1 }}">
              <img src="{{ $url }}" alt="" loading="lazy">
            </button>
          @endforeach
        </div>
      @endif

      @if ($goat->video_url)
        <video controls playsinline preload="metadata" poster="{{ $photos[0] }}" src="{{ $goat->video_url }}"></video>
      @endif
    </div>

    <div class="info-col">
      <div>
        <h1 style="font-size:clamp(2rem,5vw,2.8rem)">{{ $goat->name }}</h1>
        <div class="meta">Kode {{ $goat->code }} · {{ $goat->breed_label }}</div>
      </div>
      <dl class="facts">
        <div><dt>Jenis kelamin</dt><dd>{{ $goat->sex }}</dd></div>
        <div><dt>Umur</dt><dd>{{ $goat->age_months }} bulan</dd></div>
        <div><dt>Berat</dt><dd>{{ $goat->weight_kg }} kg</dd></div>
        <div><dt>Status</dt><dd>{{ ucfirst($goat->status) }}</dd></div>
      </dl>
      @if ($goat->description)
        <p class="meta" style="margin:0">{!! nl2br(e($goat->description)) !!}</p>
      @endif
      <div class="price" style="padding:0">Rp {{ number_format($goat->price, 0, ',', '.') }}</div>
      <a class="btn btn-gold" style="justify-content:center" href="{{ $goat->wa_url }}" target="_blank" rel="noopener">
        {{ $goat->status === 'terjual' ? 'Sudah terjual, tanya stok serupa' : 'Pesan lewat WhatsApp' }}
      </a>
    </div>
  </div>
</div>

<dialog id="lb" aria-label="Foto kambing">
  <button type="button" class="lbx" id="lbx" aria-label="Tutup">×</button>
  @if (count($photos) > 1)
    <button type="button" class="lbprev" id="lbprev" aria-label="Foto sebelumnya">‹</button>
    <button type="button" class="lbnext" id="lbnext" aria-label="Foto berikutnya">›</button>
  @endif
  <div id="lbmedia"></div>
  <p id="lbtext">{{ $goat->name }}</p>
</dialog>

<script>
(function () {
  var photos = @json($photos), cur = 0;
  var main = document.getElementById('mainPhoto'), thumbs = document.querySelectorAll('.thumb');
  var lb = document.getElementById('lb'), media = document.getElementById('lbmedia');

  function show(i) {
    cur = (i + photos.length) % photos.length;
    main.src = photos[cur];
    thumbs.forEach(function (t, k) { t.classList.toggle('on', k === cur); });
    var big = media.firstChild;
    if (big) { big.src = photos[cur]; }
  }

  thumbs.forEach(function (t, k) { t.addEventListener('click', function () { show(k); }); });

  document.getElementById('openPhoto').addEventListener('click', function () {
    var img = document.createElement('img');
    img.src = photos[cur];
    img.alt = main.alt;
    media.innerHTML = '';
    media.appendChild(img);
    lb.showModal();
  });

  var prev = document.getElementById('lbprev'), next = document.getElementById('lbnext');
  if (prev) { prev.addEventListener('click', function () { show(cur - 1); }); }
  if (next) { next.addEventListener('click', function () { show(cur + 1); }); }

  lb.addEventListener('keydown', function (e) {
    if (photos.length < 2) { return; }
    if (e.key === 'ArrowLeft') { show(cur - 1); }
    if (e.key === 'ArrowRight') { show(cur + 1); }
  });
  lb.addEventListener('close', function () { media.innerHTML = ''; });
  document.getElementById('lbx').addEventListener('click', function () { lb.close(); });
  lb.addEventListener('click', function (e) { if (e.target === lb) { lb.close(); } });
})();
</script>

<script type="application/ld+json">
{!! json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Product',
    'name'        => $goat->name . ' (' . $goat->breed_label . ')',
    'image'       => $photos,
    'description' => $goat->description ?: $goat->name,
    'sku'         => $goat->code,
    'brand'       => ['@type' => 'Brand', 'name' => config('site.name')],
    'offers'      => [
        '@type'         => 'Offer',
        'priceCurrency' => 'IDR',
        'price'         => (int) $goat->price,
        'url'           => url()->current(),
        'availability'  => $goat->status === 'tersedia'
            ? 'https://schema.org/InStock'
            : ($goat->status === 'dipesan' ? 'https://schema.org/LimitedAvailability' : 'https://schema.org/SoldOut'),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection
