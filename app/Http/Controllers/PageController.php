<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\Goat;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function gallery(Request $request)
    {
        $categories = GalleryItem::CATEGORIES;
        $kategori   = $request->query('kategori');
        $query      = GalleryItem::published();

        if ($kategori && isset($categories[$kategori])) {
            $query->where('category', $kategori);
        } else {
            $kategori = null;
        }

        $items = $query->latest()->get()->filter(fn ($item) => $item->media_src)->values();

        $counts = GalleryItem::published()
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('gallery.index', compact('items', 'categories', 'kategori', 'counts'));
    }

    public function guide()
    {
        return view('guide');
    }

    public function contact()
    {
        return view('contact');
    }

    public function sitemap()
    {
        $urls = [
            [route('home'), null],
            [route('goats.index'), null],
            [route('guide'), null],
            [route('gallery'), null],
            [route('contact'), null],
        ];

        foreach (Goat::all() as $goat) {
            $urls[] = [route('goats.show', $goat->code), $goat->updated_at?->toAtomString()];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
             . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as [$loc, $lastmod]) {
            $xml .= '  <url><loc>' . htmlspecialchars($loc, ENT_XML1) . '</loc>'
                  . ($lastmod ? '<lastmod>' . $lastmod . '</lastmod>' : '')
                  . "</url>\n";
        }

        return response($xml . '</urlset>', 200)->header('Content-Type', 'application/xml');
    }
}
