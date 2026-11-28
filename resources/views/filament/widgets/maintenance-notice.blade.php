<x-filament-widgets::widget>
    <x-filament::section>
        <div style="display:flex;flex-wrap:wrap;gap:1rem;align-items:center;justify-content:space-between;border-left:4px solid {{ $closed ? '#f59e0b' : '#22c55e' }};padding-left:1rem">
            <div>
                @if ($closed)
                    <strong style="display:block;font-size:1.05rem">Website sedang ditutup untuk pengunjung</strong>
                    <span style="opacity:.7">Pengunjung melihat halaman "sedang dalam perawatan". Anda yang sedang login tetap bisa melihat web seperti biasa.</span>
                @else
                    <strong style="display:block;font-size:1.05rem">Website terbuka untuk umum</strong>
                    <span style="opacity:.7">Semua pengunjung bisa melihat web seperti biasa.</span>
                @endif
            </div>
            <x-filament::button tag="a" :href="$url" :color="$closed ? 'warning' : 'gray'">
                {{ $closed ? 'Buka website untuk umum' : 'Atur mode perawatan' }}
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
