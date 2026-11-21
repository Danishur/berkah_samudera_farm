@extends('layouts.app')

@section('title', $kategori ? $categories[$kategori] : 'Galeri Peternakan')
@section('description', 'Dokumentasi asli Berkah Samudera Farm: kandang, perawatan kambing, kelahiran, video, dan pengiriman.')

@section('content')
<section>
  <div class="wrap">
    <div style="margin-bottom:26px">
      <a class="btn btn-line" href="{{ route('home') }}">← Kembali ke beranda</a>
    </div>

    <div class="head">
      <h1 style="font-size:clamp(2rem,5vw,3rem)">{{ $kategori ? $categories[$kategori] : 'Galeri peternakan' }}</h1>
      <p>Dokumentasi asli dari kandang kami. Ketuk foto atau video untuk melihat lebih besar.</p>
    </div>

    <nav class="tabs" aria-label="Kategori galeri">
      <a class="tab {{ $kategori ? '' : 'on' }}" href="{{ route('gallery') }}">Semua <small>{{ $counts->sum() }}</small></a>
      @foreach ($categories as $key => $label)
        <a class="tab {{ $kategori === $key ? 'on' : '' }}" href="{{ route('gallery', ['kategori' => $key]) }}">{{ $label }} <small>{{ $counts[$key] ?? 0 }}</small></a>
      @endforeach
    </nav>

    @if ($items->count())
      <div class="gal">
        @foreach ($items as $item)
          <button type="button" class="tile" data-kind="{{ $item->kind }}" data-src="{{ $item->media_src }}" data-title="{{ $item->title }}" data-caption="{{ $item->caption }}">
            @if ($item->thumb_url)
              <img src="{{ $item->thumb_url }}" alt="{{ $item->title ?: 'Dokumentasi peternakan' }}" loading="lazy">
            @else
              <span class="ph">▶</span>
            @endif
            @if ($item->kind !== 'image')<span class="play">▶</span>@endif
            @if ($item->title)<span class="cap">{{ $item->title }}</span>@endif
          </button>
        @endforeach
      </div>
    @else
      <p class="meta">Belum ada foto atau video di kategori ini.</p>
    @endif
  </div>
</section>

<dialog id="lb" aria-label="Pratinjau galeri">
  <button type="button" class="lbx" id="lbx" aria-label="Tutup">×</button>
  <div id="lbmedia"></div>
  <p id="lbtext"></p>
</dialog>

<script>
(function () {
  var lb = document.getElementById('lb'), media = document.getElementById('lbmedia'), teks = document.getElementById('lbtext');
  function esc(s) { var d = document.createElement('div'); d.textContent = s || ''; return d.innerHTML; }
  document.querySelectorAll('.tile[data-kind]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var kind = btn.dataset.kind, src = btn.dataset.src, el;
      if (kind === 'youtube') {
        el = document.createElement('iframe');
        el.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(src) + '?autoplay=1';
        el.allow = 'autoplay; encrypted-media; picture-in-picture';
        el.allowFullscreen = true;
      } else if (kind === 'video') {
        el = document.createElement('video');
        el.src = src; el.controls = true; el.autoplay = true; el.playsInline = true;
      } else {
        el = document.createElement('img');
        el.src = src; el.alt = btn.dataset.title || '';
      }
      media.innerHTML = '';
      media.appendChild(el);
      teks.innerHTML = (btn.dataset.title ? '<b>' + esc(btn.dataset.title) + '</b>' : '') + esc(btn.dataset.caption);
      lb.showModal();
    });
  });
  lb.addEventListener('close', function () { media.innerHTML = ''; });
  document.getElementById('lbx').addEventListener('click', function () { lb.close(); });
  lb.addEventListener('click', function (e) { if (e.target === lb) lb.close(); });
})();
</script>
@endsection
