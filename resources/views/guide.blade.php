@extends('layouts.app')

@section('title', 'Panduan Jenis Kambing Boer')
@section('description', 'Kenali kambing Boer Fullblood dan Crossboer F1 sampai F5, silsilah, dan cara memilih kambing yang tepat untuk kurban, potong, atau beternak.')

@section('content')
<section>
  <div class="wrap">
    <div style="margin-bottom:26px">
      <a class="btn btn-line" href="{{ route('home') }}">← Kembali ke beranda</a>
    </div>

    <div class="head">
      <h1 style="font-size:clamp(2rem,5vw,3rem)">Panduan jenis kambing Boer</h1>
      <p>Bingung membedakan Fullblood dan Crossboer F1 sampai F5? Baca ringkasannya di sini sebelum memilih.</p>
    </div>

    <div class="prose">
      <h2>Mengenal kambing Boer</h2>
      <p>Boer berasal dari Afrika Selatan dan dikenal sebagai kambing pedaging. Tubuhnya besar dan padat, pertumbuhannya cepat, dan ciri khasnya berbulu putih dengan kepala coklat kemerahan. Karena itu Boer banyak dipilih untuk kurban, aqiqah, usaha potong, dan pembibitan.</p>
    </div>
  </div>
</section>

<section class="alt">
  <div class="wrap">
    <div class="head">
      <h2>Fullblood dan Crossboer F1 sampai F5</h2>
      <p>Boer Fullblood adalah Boer murni. Crossboer adalah hasil persilangan kambing lokal dengan pejantan Boer. Makin besar angka F, makin besar porsi darah Boer-nya.</p>
    </div>

    <div class="table-wrap">
      <table class="compare">
        <thead>
          <tr><th>Jenis</th><th>Perkiraan darah Boer</th><th>Gambaran singkat</th><th>Cocok untuk</th><th></th></tr>
        </thead>
        <tbody>
          <tr><td><b>Boer Fullblood</b></td><td>100%</td><td>Keturunan Boer murni, postur paling besar dan padat.</td><td>Pejantan, indukan, pembibitan</td><td><a href="{{ route('goats.index', ['jenis' => 'fullblood']) }}">Lihat</a></td></tr>
          <tr><td><b>Crossboer F1</b></td><td>± 50%</td><td>Silangan pertama Boer dengan kambing lokal.</td><td>Kurban dan potong dengan harga terjangkau</td><td><a href="{{ route('goats.index', ['jenis' => 'f1']) }}">Lihat</a></td></tr>
          <tr><td><b>Crossboer F2</b></td><td>± 75%</td><td>Bobot dan postur lebih menyerupai Boer.</td><td>Kurban, potong, penggemukan</td><td><a href="{{ route('goats.index', ['jenis' => 'f2']) }}">Lihat</a></td></tr>
          <tr><td><b>Crossboer F3</b></td><td>± 87,5%</td><td>Tampilan makin mirip Boer murni.</td><td>Potong, calon indukan</td><td><a href="{{ route('goats.index', ['jenis' => 'f3']) }}">Lihat</a></td></tr>
          <tr><td><b>Crossboer F4</b></td><td>± 93,75%</td><td>Mendekati Boer murni.</td><td>Pembibitan, indukan</td><td><a href="{{ route('goats.index', ['jenis' => 'f4']) }}">Lihat</a></td></tr>
          <tr><td><b>Crossboer F5</b></td><td>± 96,9%</td><td>Sangat mendekati Fullblood.</td><td>Pembibitan dengan harga di bawah Fullblood</td><td><a href="{{ route('goats.index', ['jenis' => 'f5']) }}">Lihat</a></td></tr>
        </tbody>
      </table>
    </div>
    <p class="note">Persentase adalah perkiraan dari pola persilangan. Hasil tiap kambing bisa berbeda, jadi tanyakan kondisi kambing yang Anda minati.</p>
  </div>
</section>

<section>
  <div class="wrap two">
    <div class="prose">
      <h2>Apa itu silsilah (pedigree)?</h2>
      <p>Silsilah adalah catatan keturunan seekor kambing: siapa induknya, siapa pejantannya, dan kapan lahirnya. Untuk pembibitan, silsilah membantu menilai kualitas keturunan yang akan dihasilkan.</p>
      <p>Tertarik dengan data silsilah kambing tertentu? Tanyakan ketersediaannya langsung lewat WhatsApp.</p>
    </div>
    <div class="prose">
      <h2>Cek ini sebelum membeli</h2>
      <ul class="tips">
        <li>Mata cerah dan nafsu makan baik.</li>
        <li>Bulu bersih dan kaki kokoh, jalannya normal.</li>
        <li>Minta foto dan video terbaru lewat WhatsApp.</li>
        <li>Tanyakan umur, berat, dan riwayat perawatan.</li>
        <li>Untuk pengiriman antar provinsi, tanyakan dokumen kesehatan hewan.</li>
      </ul>
    </div>
  </div>
</section>

<section class="alt">
  <div class="wrap">
    <div class="head"><h2>Mau pilih yang mana?</h2><p>Tiga kebutuhan paling umum dan jenis yang biasanya dipertimbangkan.</p></div>
    <div class="choices">
      <div class="choice">
        <h3>Untuk kurban atau aqiqah</h3>
        <p>Pilih berdasarkan bobot dan anggaran. Crossboer F1 sampai F3 biasanya paling terjangkau. Pastikan umur dan kondisi kambing sesuai ketentuan, kami bantu menyesuaikan.</p>
        <a class="btn btn-gold" href="{{ route('goats.index') }}">Lihat semua kambing</a>
      </div>
      <div class="choice">
        <h3>Untuk usaha potong</h3>
        <p>Cari kambing dengan pertumbuhan cepat dan bobot bagus. Crossboer F2 sampai F4 sering dipilih karena menyeimbangkan harga dan bobot.</p>
        <a class="btn btn-gold" href="{{ route('goats.index', ['jenis' => 'f2']) }}">Lihat Crossboer F2</a>
      </div>
      <div class="choice">
        <h3>Untuk beternak</h3>
        <p>Boer Fullblood atau Crossboer F4 dan F5 cocok sebagai pejantan dan indukan. Tanyakan silsilah dan riwayat kambingnya.</p>
        <a class="btn btn-gold" href="{{ route('goats.index', ['jenis' => 'fullblood']) }}">Lihat Fullblood</a>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="wrap">
    <div class="cta-box">
      <h2>Masih bingung memilih?</h2>
      <p>Ceritakan kebutuhan dan anggaran Anda, kami bantu pilihkan kambing yang paling cocok.</p>
      <a class="btn btn-gold" href="https://wa.me/{{ config('site.wa') }}?text={{ rawurlencode('Halo Berkah Samudera Farm, saya ingin dibantu memilih jenis kambing Boer.') }}" target="_blank" rel="noopener">Tanya lewat WhatsApp</a>
    </div>
  </div>
</section>
@endsection
