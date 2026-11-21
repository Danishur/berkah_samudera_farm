@extends('layouts.app')

@section('title', $jenis ? $breeds[$jenis] : 'Semua Kambing Boer')
@section('description', 'Daftar kambing '.($jenis ? $breeds[$jenis] : 'Boer Fullblood dan Crossboer F1 sampai F5').' dari Berkah Samudera Farm, Kemlagi, Mojokerto.')

@section('content')
<section>
  <div class="wrap">
    <div style="margin-bottom:26px">
      <a class="btn btn-line" href="{{ route('home') }}">← Kembali ke beranda</a>
    </div>

    <div class="head">
      <h1 style="font-size:clamp(2rem,5vw,3rem)">{{ $jenis ? $breeds[$jenis] : 'Semua kambing' }}</h1>
      <p>Pilih jenis, cari, atau saring berdasarkan harga dan berat. Ketuk kambing untuk melihat detailnya.</p>
    </div>

    <form class="filter" method="get" action="{{ route('goats.index') }}">
      @if ($jenis)<input type="hidden" name="jenis" value="{{ $jenis }}">@endif
      <div class="f-row">
        <label class="f-search">
          <span class="sr">Cari kambing</span>
          <input type="search" name="q" value="{{ $f['q'] }}" placeholder="Cari nama atau kode kambing">
        </label>
        <button class="btn btn-gold" type="submit">Cari</button>
      </div>
      <details class="f-more" @if ($f['status'] || $f['urut'] || $f['harga_min'] || $f['harga_max'] || $f['berat_min'] || $f['berat_max']) open @endif>
        <summary>Filter dan urutkan</summary>
        <div class="f-grid">
          <label>Status
            <select name="status">
              <option value="">Semua</option>
              <option value="tersedia" @selected($f['status'] === 'tersedia')>Tersedia</option>
              <option value="dipesan" @selected($f['status'] === 'dipesan')>Dipesan</option>
              <option value="terjual" @selected($f['status'] === 'terjual')>Terjual</option>
            </select>
          </label>
          <label>Urutkan
            <select name="urut">
              <option value="">Terbaru</option>
              <option value="termurah" @selected($f['urut'] === 'termurah')>Harga termurah</option>
              <option value="termahal" @selected($f['urut'] === 'termahal')>Harga termahal</option>
              <option value="terberat" @selected($f['urut'] === 'terberat')>Berat terbesar</option>
              <option value="teringan" @selected($f['urut'] === 'teringan')>Berat terkecil</option>
            </select>
          </label>
          <label>Harga minimal (Rp)<input type="number" name="harga_min" min="0" step="100000" value="{{ $f['harga_min'] }}" placeholder="0"></label>
          <label>Harga maksimal (Rp)<input type="number" name="harga_max" min="0" step="100000" value="{{ $f['harga_max'] }}" placeholder="Tanpa batas"></label>
          <label>Berat minimal (kg)<input type="number" name="berat_min" min="0" value="{{ $f['berat_min'] }}" placeholder="0"></label>
          <label>Berat maksimal (kg)<input type="number" name="berat_max" min="0" value="{{ $f['berat_max'] }}" placeholder="Tanpa batas"></label>
        </div>
        <button class="btn btn-line" type="submit" style="margin-bottom:16px">Terapkan</button>
      </details>
      @if ($aktif)
        <a class="f-reset" href="{{ route('goats.index', array_filter(['jenis' => $jenis])) }}">Hapus semua filter</a>
      @endif
    </form>

    <nav class="tabs" aria-label="Jenis kambing">
      <a class="tab {{ $jenis ? '' : 'on' }}" href="{{ route('goats.index', $keep) }}">Semua <small>{{ $counts->sum() }}</small></a>
      @foreach ($breeds as $key => $label)
        <a class="tab {{ $jenis === $key ? 'on' : '' }}" href="{{ route('goats.index', array_merge($keep, ['jenis' => $key])) }}">{{ $label }} <small>{{ $counts[$key] ?? 0 }}</small></a>
      @endforeach
    </nav>

    <p class="meta" style="margin:0 0 18px">Menampilkan {{ $goats->count() }} kambing</p>

    <div class="grid">
      @forelse ($goats as $goat)
        @include('partials.goat-card')
      @empty
        <p class="empty">Tidak ada kambing yang cocok. Coba ubah filter, atau hubungi kami lewat WhatsApp untuk info stok terbaru.</p>
      @endforelse
    </div>
  </div>
</section>
@endsection
