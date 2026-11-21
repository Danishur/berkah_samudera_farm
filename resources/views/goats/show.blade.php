@extends('layouts.app')

@section('title', $goat->name)
@section('description', $goat->name.' ('.$goat->code.'), '.$goat->weight_kg.' kg, umur '.$goat->age_months.' bulan. Jual kambing Boer Mojokerto.')

@section('og_image', $goat->photo_url)

@section('content')
<div class="wrap">
  <a class="back" href="{{ route('goats.index', ['jenis' => $goat->breed]) }}">Kembali ke daftar kambing</a>
  <div class="detail">
    <div>
      <div class="photo"><img src="{{ $goat->photo_url }}" alt="{{ $goat->name }}"><span class="badge s-{{ $goat->status }}">{{ ucfirst($goat->status) }}</span></div>
      @if ($goat->video_url)
        <video controls preload="metadata" src="{{ $goat->video_url }}"></video>
      @endif
      @if (count($goat->gallery_urls))
        <div class="gallery">
          @foreach ($goat->gallery_urls as $url)
            <img src="{{ $url }}" alt="Foto tambahan {{ $goat->name }}" loading="lazy">
          @endforeach
        </div>
      @endif
    </div>
    <div class="info-col">
      <div><h1 style="font-size:clamp(2rem,5vw,2.8rem)">{{ $goat->name }}</h1><div class="meta">Kode {{ $goat->code }} · {{ $goat->breed_label }}</div></div>
      <dl class="facts">
        <div><dt>Jenis kelamin</dt><dd>{{ $goat->sex }}</dd></div>
        <div><dt>Umur</dt><dd>{{ $goat->age_months }} bulan</dd></div>
        <div><dt>Berat</dt><dd>{{ $goat->weight_kg }} kg</dd></div>
        <div><dt>Status</dt><dd>{{ ucfirst($goat->status) }}</dd></div>
      </dl>
      <p class="meta" style="margin:0">{{ $goat->description }}</p>
      <div class="price" style="padding:0">Rp {{ number_format($goat->price, 0, ',', '.') }}</div>
      <a class="btn btn-gold" style="justify-content:center" href="{{ $goat->wa_url }}" target="_blank" rel="noopener">
        {{ $goat->status === 'terjual' ? 'Sudah terjual, tanya stok serupa' : 'Pesan lewat WhatsApp' }}
      </a>
    </div>
  </div>
</div>
<script type="application/ld+json">
{!! json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Product',
    'name'        => $goat->name . ' (' . $goat->breed_label . ')',
    'image'       => [$goat->photo_url],
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