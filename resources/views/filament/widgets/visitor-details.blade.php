<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Rincian pengunjung ({{ $days }} hari terakhir)
        </x-slot>

        @php
            $kolom = 'display:grid;gap:1.5rem;grid-template-columns:repeat(auto-fit,minmax(230px,1fr))';
            $daftar = 'list-style:none;margin:0;padding:0;display:grid;gap:.6rem';
            $baris = 'display:flex;justify-content:space-between;gap:1rem';
            $judul = 'font-weight:600;margin:0 0 .75rem';
            $pudar = 'opacity:.65;font-size:.9rem;margin:0';
        @endphp

        <div style="{{ $kolom }}">
            <div>
                <h4 style="{{ $judul }}">Halaman paling sering dibuka</h4>
                @forelse ($pages as $item)
                    @if ($loop->first)<ul style="{{ $daftar }}">@endif
                    <li style="{{ $baris }}"><span>{{ $item['label'] }}</span><strong>{{ number_format($item['total'], 0, ',', '.') }}</strong></li>
                    @if ($loop->last)</ul>@endif
                @empty
                    <p style="{{ $pudar }}">Belum ada data. Buka web lewat jendela penyamaran (incognito) untuk mencoba.</p>
                @endforelse
            </div>

            <div>
                <h4 style="{{ $judul }}">Kambing paling banyak dilihat</h4>
                @forelse ($topGoats as $item)
                    @if ($loop->first)<ul style="{{ $daftar }}">@endif
                    <li style="{{ $baris }}"><span>{{ $item['label'] }}</span><strong>{{ number_format($item['total'], 0, ',', '.') }}</strong></li>
                    @if ($loop->last)</ul>@endif
                @empty
                    <p style="{{ $pudar }}">Belum ada kambing yang dibuka.</p>
                @endforelse
            </div>

            <div>
                <h4 style="{{ $judul }}">Pengunjung datang dari</h4>
                @forelse ($sources as $label => $total)
                    @if ($loop->first)<ul style="{{ $daftar }}">@endif
                    <li style="{{ $baris }}"><span>{{ $label }}</span><strong>{{ number_format($total, 0, ',', '.') }}</strong></li>
                    @if ($loop->last)</ul>@endif
                @empty
                    <p style="{{ $pudar }}">Belum ada data.</p>
                @endforelse
            </div>

            <div>
                <h4 style="{{ $judul }}">Perangkat</h4>
                @forelse ($devices as $item)
                    @if ($loop->first)<ul style="{{ $daftar }}">@endif
                    <li style="{{ $baris }}"><span>{{ $item['label'] }}</span><strong>{{ $item['percent'] }}%</strong></li>
                    @if ($loop->last)</ul>@endif
                @empty
                    <p style="{{ $pudar }}">Belum ada data.</p>
                @endforelse
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
