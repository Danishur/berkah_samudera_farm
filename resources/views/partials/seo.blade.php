@php
    $seoTitle = $__env->yieldContent('title', 'Jual Kambing Boer Mojokerto') . ' | ' . config('site.name');
    $seoDesc  = $__env->yieldContent('description', 'Jual kambing Boer pedaging dari Kemlagi, Mojokerto. Foto dan video asli, pengiriman ke seluruh Indonesia, pesan lewat WhatsApp.');
    $seoImage = trim($__env->yieldContent('og_image')) ?: asset('images/logo.jpg');
    $sameAs   = array_values(array_filter([config('site.instagram'), config('site.tiktok'), config('site.facebook')]));
@endphp
<link rel="canonical" href="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="id_ID">
<meta property="og:site_name" content="{{ config('site.name') }}">
<meta property="og:title" content="{!! $seoTitle !!}">
<meta property="og:description" content="{!! $seoDesc !!}">
<meta property="og:image" content="{{ $seoImage }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary_large_image">
<script type="application/ld+json">
{!! json_encode([
    '@context'  => 'https://schema.org',
    '@type'     => 'LocalBusiness',
    'name'      => config('site.name'),
    'image'     => asset('images/logo.jpg'),
    'url'       => url('/'),
    'telephone' => '+' . config('site.wa'),
    'address'   => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => 'Dusun Sidowangun RT 03/RW 02, Sidoringin, Kedungsari',
        'addressLocality' => 'Kemlagi, Kabupaten Mojokerto',
        'addressRegion'   => 'Jawa Timur',
        'postalCode'      => '61351',
        'addressCountry'  => 'ID',
    ],
    'geo'       => ['@type' => 'GeoCoordinates', 'latitude' => -7.4415539, 'longitude' => 112.370089],
    'sameAs'    => $sameAs,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
