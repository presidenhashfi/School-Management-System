<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke School Management System untuk mengelola data siswa, guru, kelas, dan mata pelajaran.">
    <title>Masuk — School Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/ui.css') }}?v={{ @filemtime(public_path('css/ui.css')) }}" rel="stylesheet">
    <style>
        body { overflow: auto; }
        .auth { min-height: 100vh; min-height: 100dvh; display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(0, 1fr); }

        /* Brand side */
        .auth-aside {
            position: relative; overflow: hidden;
            background: linear-gradient(145deg, #1e1b4b 0%, #312e81 45%, #4338ca 100%);
            color: #e0e7ff; display: flex; flex-direction: column; justify-content: space-between; padding: 2.5rem 3rem;
        }
        .auth-aside::before {
            content: ''; position: absolute; inset: 0; opacity: .45;
            background-image: radial-gradient(rgba(255,255,255,.18) 1.5px, transparent 1.5px);
            background-size: 24px 24px;
            -webkit-mask-image: radial-gradient(ellipse at 20% 80%, #000, transparent 70%);
            mask-image: radial-gradient(ellipse at 20% 80%, #000, transparent 70%);
        }
        .auth-aside::after {
            content: ''; position: absolute; width: 440px; height: 440px; right: -160px; top: -160px; border-radius: 50%;
            border: 1px solid rgba(165, 180, 252, .2); box-shadow: 0 0 0 60px rgba(165,180,252,.05), 0 0 0 120px rgba(165,180,252,.025);
        }
        .auth-aside > * { position: relative; z-index: 1; }
        .auth-aside .brand, .auth-aside .brand:hover { color: #fff; }
        .auth-aside .brand-mark { background: #fff; color: #4338ca; box-shadow: 0 4px 12px rgba(0,0,0,.15); }
        .auth-hero h1 { font-family: 'Nunito', sans-serif; font-size: clamp(2rem, 3.2vw, 2.9rem); font-weight: 900; line-height: 1.1; letter-spacing: -.035em; color: #fff; margin: 0 0 1rem; max-width: 14ch; }
        .auth-hero p { color: #c7d2fe; font-size: 1.02rem; max-width: 38ch; margin: 0; }
        .auth-points { list-style: none; margin: 0; padding: 0; display: grid; gap: .75rem; }
        .auth-points li { display: flex; align-items: center; gap: .7rem; font-size: .88rem; color: #e0e7ff; font-weight: 600; }
        .auth-points i { color: #818cf8; font-size: 1.1rem; }

        /* Form side */
        .auth-main { display: flex; align-items: center; justify-content: center; padding: 2rem 1.5rem; background: var(--surface); }
        .auth-box { width: 100%; max-width: 380px; animation: rise .5s var(--ease) both; }
        .auth-box .brand { display: none; margin-bottom: 2rem; }
        .auth-box h2 { font-size: 1.65rem; font-weight: 800; margin: 0 0 .4rem; }
        .auth-box .lead { color: var(--muted); margin: 0 0 2rem; font-size: .9rem; }
        .field { margin-bottom: 1.1rem; }
        .field label { display: block; font-size: .78rem; font-weight: 600; color: var(--ink-2); margin-bottom: .4rem; }
        .input-ico { position: relative; }
        .input-ico > i.lead-ico { position: absolute; left: .9rem; top: 50%; transform: translateY(-50%); color: var(--faint); pointer-events: none; }
        .input-ico input {
            width: 100%; min-height: 46px; padding: .65rem 2.6rem .65rem 2.6rem; font: inherit; font-size: .92rem; color: var(--ink);
            background: var(--surface); border: 1px solid var(--line-strong); border-radius: var(--r-sm); outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .input-ico input:hover { border-color: var(--faint); }
        .input-ico input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-ring); }
        .input-ico input.is-invalid { border-color: var(--danger); }
        .reveal { position: absolute; right: .35rem; top: 50%; transform: translateY(-50%); width: 36px; height: 36px; border: 0; background: none; color: var(--muted); border-radius: 8px; cursor: pointer; display: grid; place-items: center; }
        .reveal:hover { color: var(--ink); background: #f5f5f4; }
        .err { display: flex; align-items: center; gap: .35rem; color: var(--danger); font-size: .78rem; font-weight: 600; margin-top: .4rem; }
        .btn-login { width: 100%; min-height: 48px; margin-top: .5rem; background: var(--ink); color: #fff; border: 0; border-radius: var(--r-sm); font: inherit; font-weight: 700; font-size: .92rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: .5rem; transition: background .15s, transform .15s; }
        .btn-login:hover { background: #292524; }
        .btn-login:active { transform: scale(.99); }
        .btn-login:disabled { opacity: .7; cursor: wait; }
        .foot { margin-top: 2.5rem; text-align: center; font-size: .74rem; color: var(--faint); }

        @media (max-width: 860px) {
            .auth { grid-template-columns: minmax(0, 1fr); }
            .auth-aside { display: none; }
            .auth-main { background: var(--bg); align-items: flex-start; padding-top: 10vh; }
            .auth-box { background: var(--surface); border: 1px solid var(--line); border-radius: var(--r-lg); padding: 1.75rem 1.5rem; box-shadow: var(--shadow-md); }
            .auth-box .brand { display: flex; }
        }
        @media (max-width: 400px) { .auth-main { padding-left: .75rem; padding-right: .75rem; } }
    </style>
</head>
<body>
<div class="auth">
    <aside class="auth-aside" aria-hidden="false">
        <a class="brand" href="/"><span class="brand-mark"><i class="bi bi-mortarboard" aria-hidden="true"></i></span><span class="brand-name">SchoolMS</span></a>

        <div class="auth-hero">
            <h1>Kelola sekolah, tanpa ribet.</h1>
            <p>Satu tempat untuk data siswa, guru, kelas, dan mata pelajaran.</p>
        </div>

        <ul class="auth-points">
            <li><i class="bi bi-check2-circle" aria-hidden="true"></i> Data siswa &amp; guru terpusat</li>
            <li><i class="bi bi-check2-circle" aria-hidden="true"></i> Kelas dan mata pelajaran terstruktur</li>
            <li><i class="bi bi-check2-circle" aria-hidden="true"></i> Akses berdasarkan peran pengguna</li>
        </ul>
    </aside>

    <main class="auth-main">
        <div class="auth-box">
            <a class="brand" href="/"><span class="brand-mark"><i class="bi bi-mortarboard" aria-hidden="true"></i></span><span class="brand-name">SchoolMS</span></a>

            <h1 class="visually-hidden">Masuk</h1>
            <h2>Selamat datang</h2>
            <p class="lead">Masuk dengan akun Anda untuk melanjutkan.</p>

            <form action="/login" method="POST" id="loginForm" novalidate>
                @csrf
                <div class="field">
                    <label for="email">Email</label>
                    <div class="input-ico">
                        <i class="bi bi-envelope lead-ico" aria-hidden="true"></i>
                        <input type="email" name="email" id="email" placeholder="nama@sekolah.com" autocomplete="username"
                               value="{{ old('email') }}" class="@error('email') is-invalid @enderror" autofocus required>
                    </div>
                    @error('email')
                        <div class="err" role="alert"><i class="bi bi-exclamation-circle" aria-hidden="true"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-ico">
                        <i class="bi bi-lock lead-ico" aria-hidden="true"></i>
                        <input type="password" name="password" id="password" placeholder="Masukkan password" autocomplete="current-password" required>
                        <button type="button" class="reveal" id="reveal" aria-label="Tampilkan password"><i class="bi bi-eye" aria-hidden="true"></i></button>
                    </div>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <span>Masuk</span> <i class="bi bi-arrow-right" aria-hidden="true"></i>
                </button>
            </form>

            <p class="foot">&copy; {{ date('Y') }} School Management System</p>
        </div>
    </main>
</div>
<script>
    var pw = document.getElementById('password'), rv = document.getElementById('reveal');
    rv.addEventListener('click', function () {
        var show = pw.type === 'password';
        pw.type = show ? 'text' : 'password';
        rv.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
        rv.firstElementChild.className = 'bi ' + (show ? 'bi-eye-slash' : 'bi-eye');
    });
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        if (!this.checkValidity()) { return; }
        var b = document.getElementById('loginBtn');
        b.disabled = true;
        b.innerHTML = '<i class="bi bi-arrow-repeat" style="animation:spin 1s linear infinite" aria-hidden="true"></i> Memproses...';
    });
</script>
</body>
</html>