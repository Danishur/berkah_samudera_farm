<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Asal pengunjung ({{ $days }} hari terakhir)
        </x-slot>

        @php
            $kolom = 'display:grid;gap:1.5rem;grid-template-columns:repeat(auto-fit,minmax(230px,1fr))';
            $daftar = 'list-style:none;margin:0;padding:0;display:grid;gap:.6rem';
            $baris = 'display:flex;justify-content:space-between;gap:1rem';
            $judul = 'font-weight:600;margin:0 0 .75rem';
            $pudar = 'opacity:.65;font-size:.9rem;margin:0';
        @endphp

        @if (! $ready)
            <p style="{{ $pudar }}">
                Database lokasi belum dipasang. Jalankan <code>php artisan geoip:update</code> di server,
                lalu lokasi pengunjung baru akan tercatat.
            </p>
        @else
            <p style="margin:0 0 1.25rem">
                Dari luar negeri: <strong>{{ number_format($abroad, 0, ',', '.') }}</strong>
                pengunjung ({{ $abroadPct }}% dari yang lokasinya terdeteksi).
                @if ($unknown > 0)
                    <span style="opacity:.65">Lokasi tidak terdeteksi: {{ number_format($unknown, 0, ',', '.') }}.</span>
                @endif
            </p>

            <div style="{{ $kolom }}">
                <div>
                    <h4 style="{{ $judul }}">Kota di Indonesia</h4>
                    @forelse ($cities as $item)
                        @if ($loop->first)<ul style="{{ $daftar }}">@endif
                        <li style="{{ $baris }}"><span>{{ $item->label }}</span><strong>{{ number_format($item->total, 0, ',', '.') }}</strong></li>
                        @if ($loop->last)</ul>@endif
                    @empty
                        <p style="{{ $pudar }}">Belum ada data.</p>
                    @endforelse
                </div>

                <div>
                    <h4 style="{{ $judul }}">Provinsi</h4>
                    @forelse ($regions as $item)
                        @if ($loop->first)<ul style="{{ $daftar }}">@endif
                        <li style="{{ $baris }}"><span>{{ $item->label }}</span><strong>{{ number_format($item->total, 0, ',', '.') }}</strong></li>
                        @if ($loop->last)</ul>@endif
                    @empty
                        <p style="{{ $pudar }}">Belum ada data.</p>
                    @endforelse
                </div>

                <div>
                    <h4 style="{{ $judul }}">Negara</h4>
                    @forelse ($countries as $item)
                        @if ($loop->first)<ul style="{{ $daftar }}">@endif
                        <li style="{{ $baris }}"><span>{{ $item->country_name ?: $item->label }}</span><strong>{{ number_format($item->total, 0, ',', '.') }}</strong></li>
                        @if ($loop->last)</ul>@endif
                    @empty
                        <p style="{{ $pudar }}">Belum ada data.</p>
                    @endforelse
                </div>
            </div>
        @endif

        <p style="opacity:.55;font-size:.8rem;margin:1.25rem 0 0">
            Lokasi adalah perkiraan dari alamat IP. Hasil biasanya tepat sampai negara dan provinsi,
            sedangkan kota bisa meleset (terutama pengguna jaringan seluler).
            <a href="https://db-ip.com" target="_blank" rel="noopener" style="text-decoration:underline">IP Geolocation by DB-IP</a>
        </p>
    </x-filament::section>
</x-filament-widgets::widget>
