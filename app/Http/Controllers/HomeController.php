<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Goat;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private const URUTAN = "FIELD(status,'tersedia','dipesan','terjual')";

    public function index()
    {
        $goats = Goat::orderByRaw(self::URUTAN)->latest()->take(6)->get();

        $gallery = GalleryItem::published()->latest()->take(8)->get()
            ->filter(fn ($item) => $item->media_src)
            ->take(4)
            ->values();

        $testimonials = Testimonial::active()->latest()->take(6)->get();
        $faqs = Faq::active()->get();

        return view('home', compact('goats', 'gallery', 'testimonials', 'faqs'));
    }

    public function goats(Request $request)
    {
        $breeds = config('site.breeds');
        $jenis  = $request->query('jenis');
        $jenis  = ($jenis && isset($breeds[$jenis])) ? $jenis : null;

        $f = [
            'q'         => trim((string) $request->query('q', '')),
            'status'    => $request->query('status'),
            'urut'      => $request->query('urut'),
            'harga_min' => $request->query('harga_min'),
            'harga_max' => $request->query('harga_max'),
            'berat_min' => $request->query('berat_min'),
            'berat_max' => $request->query('berat_max'),
        ];

        $query = Goat::query();

        if ($jenis) {
            $query->where('breed', $jenis);
        }

        if ($f['q'] !== '') {
            $kata = '%' . $f['q'] . '%';
            $query->where(function ($w) use ($kata) {
                $w->where('name', 'like', $kata)
                  ->orWhere('code', 'like', $kata)
                  ->orWhere('description', 'like', $kata);
            });
        }

        if (in_array($f['status'], ['tersedia', 'dipesan', 'terjual'], true)) {
            $query->where('status', $f['status']);
        } else {
            $f['status'] = null;
        }

        foreach (['harga_min' => ['price', '>='], 'harga_max' => ['price', '<='],
                  'berat_min' => ['weight_kg', '>='], 'berat_max' => ['weight_kg', '<=']] as $kunci => [$kolom, $op]) {
            if (is_numeric($f[$kunci])) {
                $query->where($kolom, $op, (float) $f[$kunci]);
            } else {
                $f[$kunci] = null;
            }
        }

        $query->orderByRaw(self::URUTAN);
        match ($f['urut']) {
            'termurah' => $query->orderBy('price'),
            'termahal' => $query->orderByDesc('price'),
            'terberat' => $query->orderByDesc('weight_kg'),
            'teringan' => $query->orderBy('weight_kg'),
            default    => $query->latest(),
        };

        $goats  = $query->get();
        $counts = Goat::selectRaw('breed, count(*) as total')->groupBy('breed')->pluck('total', 'breed');

        // Filter yang ikut terbawa saat pindah tab jenis
        $keep = array_filter(
            array_diff_key($f, ['aktif' => 1]),
            fn ($v) => $v !== null && $v !== ''
        );
        $aktif = count($keep) > 0;

        return view('goats.index', compact('goats', 'breeds', 'jenis', 'counts', 'f', 'keep', 'aktif'));
    }

    public function show(Goat $goat)
    {
        return view('goats.show', compact('goat'));
    }
}
