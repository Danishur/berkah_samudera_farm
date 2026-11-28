<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<meta name="theme-color" content="#0a0a0c">
<title>Website kami sedang dalam perbaikan | {{ config('site.name') }}</title>
<link rel="icon" href="{{ asset('favicon.ico') }}?v=2" sizes="any">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; }
  html, body { height: 100%; }
  body {
    margin: 0; display: grid; place-items: center; padding: 24px;
    background: radial-gradient(circle at 85% 8%, rgba(232, 184, 74, .22) 0 120px, transparent 121px), #0a0a0c;
    color: #f3eee2; font: 400 16px/1.65 "Space Grotesk", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
  }
  .box {
    width: min(100%, 560px); text-align: center; padding: 40px 28px 34px;
    background: #16161a; border: 2px solid #c8962f; border-radius: 28px; box-shadow: 8px 8px 0 #e8b84a;
  }
  .logo { width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 2px solid #e8b84a; margin: 0 auto 22px; display: block; }
  .tag { display: inline-block; padding: 4px 14px; border: 2px solid #c8962f; border-radius: 999px; font-size: .8rem; font-weight: 700; color: #f6d77f; margin-bottom: 14px; }
  h1 { margin: 0 0 12px; font-size: clamp(1.7rem, 6vw, 2.3rem); line-height: 1.15; letter-spacing: -.02em; color: #fff; }
  p { margin: 0 0 14px; color: #cfc9b8; }
  .eta { display: inline-block; margin: 4px 0 18px; padding: 10px 16px; background: #1f1f25; border: 1px solid #3a3320; border-radius: 14px; color: #f3eee2; }
  .eta strong { color: #f6d77f; }
  .btn {
    display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 999px;
    background: linear-gradient(180deg, #f6d77f, #e8b84a); color: #15110a; border: 2px solid #f6d77f;
    font: 700 .95rem "Space Grotesk", sans-serif; text-decoration: none; box-shadow: 4px 4px 0 #c8962f;
  }
  .btn:hover { transform: translate(-2px, -2px); box-shadow: 6px 6px 0 #c8962f; }
  .foot { margin-top: 22px; font-size: .85rem; color: #8c8677; }
  @media (prefers-reduced-motion: reduce) { .btn { transition: none; } }
</style>
</head>
<body>
  <main class="box">
    <img class="logo" src="{{ asset('images/logo.jpg') }}" alt="Logo {{ config('site.name') }}">
    <span class="tag">Mohon menunggu sebentar</span>
    <h1>Website kami sedang dalam perbaikan</h1>

    @if (filled($message))
      <p>{!! nl2br(e($message)) !!}</p>
    @else
      <p>Kami sedang melengkapi data kambing, foto, dan video terbaru supaya informasi yang Anda lihat lengkap dan akurat. Website akan segera dibuka kembali.</p>
    @endif

    @if (filled($eta))
      <div class="eta">Perkiraan dibuka kembali: <strong>{{ $eta }}</strong></div>
    @endif

    <div>
      <a class="btn" href="{{ config('site.wa_url') }}" target="_blank" rel="noopener">Tanya lewat WhatsApp</a>
    </div>

    <div class="foot">{{ config('site.name') }} · Kemlagi, Mojokerto</div>
  </main>
</body>
</html>
