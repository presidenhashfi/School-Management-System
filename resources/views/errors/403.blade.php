<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak | School Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/ui.css') }}" rel="stylesheet">
    <style>
        .err-page { min-height: 100vh; min-height: 100dvh; display: grid; place-items: center; padding: 1.5rem; }
        .err-box { text-align: center; max-width: 420px; animation: rise .5s var(--ease) both; }
        .err-code { font-size: clamp(4.5rem, 18vw, 7rem); font-weight: 800; letter-spacing: -.06em; line-height: 1; color: var(--line-strong); margin: 0 0 .5rem; }
        .err-box h1 { font-size: 1.4rem; font-weight: 800; margin: 0 0 .5rem; }
        .err-box p { color: var(--muted); margin: 0 0 1.75rem; }
        .err-actions { display: flex; gap: .6rem; justify-content: center; flex-wrap: wrap; }
    </style>
</head>
<body>
<main class="err-page">
    <div class="err-box">
        <div class="err-code" aria-hidden="true">403</div>
        <h1>Akses ditolak</h1>
        <p>Anda tidak memiliki izin untuk membuka halaman ini. Hubungi administrator jika menurut Anda ini keliru.</p>
        <div class="err-actions">
            <a href="javascript:history.back()" class="btn-ui btn-ui-ghost"><i class="bi bi-arrow-left" aria-hidden="true"></i> Kembali</a>
            <a href="{{ url('/dashboard') }}" class="btn-ui btn-ui-primary"><i class="bi bi-grid-1x2" aria-hidden="true"></i> Ke Dashboard</a>
        </div>
    </div>
</main>
</body>
</html>
