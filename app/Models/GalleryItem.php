<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    public const CATEGORIES = [
        'kandang'    => 'Foto kandang',
        'perawatan'  => 'Perawatan kambing',
        'kelahiran'  => 'Kelahiran',
        'video'      => 'Video kambing',
        'pengiriman' => 'Pengiriman',
    ];

    protected $fillable = ['category', 'title', 'caption', 'image', 'video', 'youtube_url'];

    /** Hanya item yang punya foto, video, atau link YouTube. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function ($w) {
            $w->whereNotNull('image')->orWhereNotNull('video')->orWhereNotNull('youtube_url');
        });
    }

    private static function fileUrl(?string $path): ?string
    {
        return $path ? asset('storage/' . $path) : null;
    }

    public function getImageUrlAttribute(): ?string
    {
        return self::fileUrl($this->image);
    }

    public function getVideoUrlAttribute(): ?string
    {
        return self::fileUrl($this->video);
    }

    public function getYoutubeIdAttribute(): ?string
    {
        if (! $this->youtube_url) {
            return null;
        }

        $pola = '~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})~';

        return preg_match($pola, $this->youtube_url, $m) ? $m[1] : null;
    }

    /** youtube / video / image */
    public function getKindAttribute(): string
    {
        if ($this->youtube_id) {
            return 'youtube';
        }

        return $this->video ? 'video' : 'image';
    }

    public function getThumbUrlAttribute(): ?string
    {
        if ($this->image_url) {
            return $this->image_url;
        }

        return $this->youtube_id ? "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg" : null;
    }

    public function getMediaSrcAttribute(): ?string
    {
        return match ($this->kind) {
            'youtube' => $this->youtube_id,
            'video'   => $this->video_url,
            default   => $this->image_url,
        };
    }
}
