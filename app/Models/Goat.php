<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goat extends Model
{
    protected $fillable = [
        'code','name','breed','sex','age_months','weight_kg',
        'price','status','description','photo','video','gallery',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];

    /** Kode otomatis untuk kambing baru, contoh: BSF-011 */
    public static function nextCode(): string
    {
        return 'BSF-' . str_pad((string) ((static::max('id') ?? 0) + 1), 3, '0', STR_PAD_LEFT);
    }

    private static function fileUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        // 'goats/xxx.jpg' = hasil upload dashboard (storage). 'g1.jpg' = file lama di public/foto.
        return str_contains($path, '/') ? asset('storage/' . $path) : asset('foto/' . $path);
    }

    public function getPhotoUrlAttribute(): string
    {
        return self::fileUrl($this->photo) ?? asset('images/logo.jpg');
    }

    public function getVideoUrlAttribute(): ?string
    {
        return self::fileUrl($this->video);
    }

    public function getGalleryUrlsAttribute(): array
    {
        return collect($this->gallery ?? [])
            ->map(fn ($path) => self::fileUrl($path))
            ->filter()
            ->values()
            ->all();
    }

    public function getBreedLabelAttribute(): string
    {
        return config('site.breeds')[$this->breed] ?? $this->breed;
    }

    public function getWaUrlAttribute(): string
    {
        $pesan = "Halo Berkah Samudera Farm, saya tertarik dengan {$this->name} "
               . "({$this->breed_label}, kode {$this->code}) seharga Rp " . number_format($this->price, 0, ',', '.')
               . ". Apakah masih tersedia?";

        return 'https://wa.me/' . config('site.wa') . '?text=' . rawurlencode($pesan);
    }
}
