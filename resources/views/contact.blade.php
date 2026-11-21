@extends('layouts.app')

@section('title', 'Kontak dan Lokasi Kandang')
@section('description', 'Hubungi Berkah Samudera Farm lewat WhatsApp dan lihat lokasi kandang di Kemlagi, Mojokerto.')

@section('content')
<section>
  <div class="wrap">
    <div style="margin-bottom:26px">
      <a class="btn btn-line" href="{{ route('home') }}">← Kembali ke beranda</a>
    </div>

    <div class="head">
      <h1 style="font-size:clamp(2rem,5vw,3rem)">Kontak dan lokasi</h1>
      <p>Cara tercepat menghubungi kami adalah lewat WhatsApp.</p>
    </div>

    <div class="two">
      <div class="about">
        <h2>Hubungi kami</h2>
        <p>Tanyakan stok, harga, atau ongkir ke kota Anda. Kami balas lewat chat.</p>
        <p><b>{{ config('site.wa_display') }}</b></p>
        <div class="cta" style="margin-top:18px">
          <a class="btn btn-gold" href="{{ config('site.wa_url') }}" target="_blank" rel="noopener">Chat WhatsApp</a>
        </div>
        <div style="margin-top:18px">@include('partials.social')</div>
      </div>

      <div class="info">
        <dl style="margin:0;display:grid;gap:18px">
          <div><dt>Alamat kandang</dt><dd>{{ config('site.address') }}</dd></div>
        </dl>
        <iframe class="map" src="{{ config('site.maps_embed') }}" title="Peta lokasi kandang Berkah Samudera Farm" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
        <div class="cta"><a class="btn btn-gold" href="{{ config('site.maps') }}" target="_blank" rel="noopener">Buka di Google Maps</a></div>
      </div>
    </div>
  </div>
</section>

<section class="alt">
  <div class="wrap two">
    <div class="about">
      <h2>Info pengiriman</h2>
      <p>{!! nl2br(e(config('site.shipping'))) !!}</p>
    </div>
  </div>
</section>
@endsection
