@extends('layouts.app')

@section('content')
<div class="hero" id="beranda">
  <div class="wrap">
    <div>
      <h1>{{ config('site.hero_title') }}</h1>
      <p class="lead">{{ config('site.hero_lead') }}</p>
      <div class="cta">
        <a class="btn btn-gold" href="{{ route('goats.index') }}">Lihat kambing tersedia</a>
        <a class="btn btn-line" href="{{ config('site.wa_url') }}" target="_blank" rel="noopener">Tanya lewat WhatsApp</a>
      </div>
    </div>
    <img class="emblem" src="{{ asset('images/logo.jpg') }}" alt="Lambang Berkah Samudera Farm, Breeder Boer Goat BGBAA Kemlagi Mojokerto">
  </div>
</div>

<div class="trust"><ul>
  <li>Foto dan video asli per ekor</li>
  <li>Dikirim dari Mojokerto ke seluruh Indonesia</li>
  <li>Pesan langsung lewat WhatsApp</li>
</ul></div>

<section id="kambing">
  <div class="wrap">
    <div class="head"><h2>Kambing terbaru</h2><p>Pilih jenis kambing, atau lihat semuanya di halaman khusus.</p></div>
    <nav class="tabs" aria-label="Jenis kambing">
      @foreach (config('site.breeds') as $key => $label)
        <a class="tab" href="{{ route('goats.index', ['jenis' => $key]) }}">{{ $label }}</a>
      @endforeach
    </nav>
    <div class="grid">
      @forelse ($goats as $goat)
        @include('partials.goat-card')
      @empty
        <p class="meta">Belum ada kambing yang ditampilkan.</p>
      @endforelse
    </div>
    <div class="more"><a class="btn btn-gold" href="{{ route('goats.index') }}">Lihat semua kambing</a></div>
  </div>
</section>

<section class="alt" id="panduan">
  <div class="wrap">
    <div class="head"><h2>Bingung pilih jenis?</h2><p>Kenali perbedaan Boer Fullblood dan Crossboer F1 sampai F5 sebelum memilih.</p></div>
    <div class="choices">
      <div class="choice"><h3>Boer Fullblood</h3><p>Boer murni dengan postur paling besar. Cocok untuk pejantan, indukan, dan pembibitan.</p></div>
      <div class="choice"><h3>Crossboer F1 sampai F5</h3><p>Hasil persilangan dengan pejantan Boer. Makin besar angka F, makin besar porsi darah Boer.</p></div>
      <div class="choice"><h3>Cara memilih</h3><p>Untuk kurban, potong, atau beternak, jenis yang cocok bisa berbeda.</p></div>
    </div>
    <div class="more"><a class="btn btn-gold" href="{{ route('guide') }}">Baca panduan lengkap</a></div>
  </div>
</section>

@if ($gallery->count())
<section id="galeri">
  <div class="wrap">
    <div class="head"><h2>Galeri peternakan</h2><p>Dokumentasi asli dari kandang kami, supaya Anda tahu kambing dirawat dengan baik.</p></div>
    <div class="gal">
      @foreach ($gallery as $item)
        <a class="tile" href="{{ route('gallery') }}">
          @if ($item->thumb_url)
            <img src="{{ $item->thumb_url }}" alt="{{ $item->title ?: 'Dokumentasi peternakan' }}" loading="lazy">
          @else
            <span class="ph">▶</span>
          @endif
          @if ($item->kind !== 'image')<span class="play">▶</span>@endif
          @if ($item->title)<span class="cap">{{ $item->title }}</span>@endif
        </a>
      @endforeach
    </div>
    <div class="more"><a class="btn btn-gold" href="{{ route('gallery') }}">Lihat galeri lengkap</a></div>
  </div>
</section>
@endif

<section class="alt" id="cara-pesan">
  <div class="wrap">
    <div class="head"><h2>Cara pesan</h2><p>Tanpa daftar akun dan tanpa keranjang. Semua lewat WhatsApp.</p></div>
    <ol class="steps">
      <li><b>Pilih kambing</b><span>Lihat foto, berat, dan harga di daftar.</span></li>
      <li><b>Klik pesan</b><span>Pesan otomatis berisi nama dan kode kambing.</span></li>
      <li><b>Sepakati harga dan kirim</b><span>Ongkir dan jadwal dibicarakan lewat chat.</span></li>
      <li><b>Kambing diantar</b><span>Dikirim dengan dokumen kesehatan hewan bila diperlukan.</span></li>
    </ol>
  </div>
</section>

<section id="pengiriman">
  <div class="wrap two">
    <div class="about">
      <h2>Info pengiriman</h2>
      <p>{!! nl2br(e(config('site.shipping'))) !!}</p>
    </div>
    <div class="cta-box">
      <h3>Mau tahu ongkir ke kota Anda?</h3>
      <p>Sebutkan kota tujuan dan kambing yang diminati, kami hitungkan lewat WhatsApp.</p>
      <a class="btn btn-gold" href="{{ config('site.wa_url') }}" target="_blank" rel="noopener">Tanya ongkir</a>
    </div>
  </div>
</section>

@if ($testimonials->count())
<section class="alt" id="testimoni">
  <div class="wrap">
    <div class="head"><h2>Kata pembeli</h2><p>Cerita dari pembeli yang sudah mempercayakan kambingnya pada kami.</p></div>
    <div class="quotes">
      @foreach ($testimonials as $t)
        <blockquote class="quote">
          <p>“{{ $t->message }}”</p>
          <div class="who">
            @if ($t->photo_url)
              <img class="avatar" src="{{ $t->photo_url }}" alt="{{ $t->name }}" loading="lazy">
            @else
              <span class="avatar">{{ mb_strtoupper(mb_substr($t->name, 0, 1)) }}</span>
            @endif
            <span><b>{{ $t->name }}</b>@if ($t->city)<br><small>{{ $t->city }}</small>@endif</span>
          </div>
        </blockquote>
      @endforeach
    </div>
  </div>
</section>
@endif

@if ($faqs->count())
<section id="faq">
  <div class="wrap">
    <div class="head"><h2>Pertanyaan yang sering diajukan</h2></div>
    <div class="faq">
      @foreach ($faqs as $faq)
        <details>
          <summary>{{ $faq->question }}</summary>
          <p>{!! nl2br(e($faq->answer)) !!}</p>
        </details>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="alt" id="tentang">
  <div class="wrap two">
    <div class="about">
      <h2>Peternakan Boer dari Kemlagi</h2>
      <p>{{ config('site.about_1') }}</p>
      <p>{{ config('site.about_2') }}</p>
    </div>
    <div class="info" id="lokasi">
      <dl style="margin:0;display:grid;gap:18px">
        <div><dt>Alamat kandang</dt><dd>{{ config('site.address') }}</dd></div>
        <div><dt>WhatsApp</dt><dd>{{ config('site.wa_display') }}</dd></div>
      </dl>
      <iframe class="map" src="{{ config('site.maps_embed') }}" title="Peta lokasi kandang Berkah Samudera Farm" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      <div class="cta"><a class="btn btn-gold" href="{{ config('site.maps') }}" target="_blank" rel="noopener">Buka di Google Maps</a></div>
    </div>
  </div>
</section>
@endsection
