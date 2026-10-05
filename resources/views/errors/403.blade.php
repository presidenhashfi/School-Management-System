<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 – Akses Ditolak | School Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --accent: #6366f1;
            --accent2: #8b5cf6;
            --bg-main: #f1f5f9;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        /* Animated background blobs */
        .bg-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            z-index: 0;
            animation: float 8s ease-in-out infinite;
        }
        .bg-blob-1 {
            width: 400px; height: 400px;
            background: var(--accent);
            top: -100px; left: -100px;
            animation-delay: 0s;
        }
        .bg-blob-2 {
            width: 350px; height: 350px;
            background: var(--accent2);
            bottom: -80px; right: -80px;
            animation-delay: 4s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-30px) scale(1.05); }
        }

        /* Card */
        .error-card {
            position: relative;
            z-index: 1;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(99, 102, 241, 0.12),
                        0 4px 20px rgba(0, 0, 0, 0.06);
            padding: 56px 48px;
            text-align: center;
            max-width: 480px;
            width: 100%;
            animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Lock icon circle */
        .icon-circle {
            width: 96px; height: 96px;
            border-radius: 50%;
            background: linear-gradient(135deg, #eef2ff, #ede9fe);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
            animation: pulse 2.5s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.25); }
            50%       { box-shadow: 0 0 0 16px rgba(99, 102, 241, 0); }
        }
        .icon-circle i {
            font-size: 2.6rem;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* 403 badge */
        .badge-403 {
            display: inline-block;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 4px 14px;
            border-radius: 999px;
            margin-bottom: 16px;
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 12px;
        }

        p.desc {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.65;
            margin-bottom: 36px;
        }

        /* Buttons */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 12px 28px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        }
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.45);
            color: #fff;
        }
        .btn-back:active { transform: translateY(0); }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: #64748b;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 12px 24px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            cursor: pointer;
            text-decoration: none;
            transition: border-color 0.2s, color 0.2s, background 0.2s;
        }
        .btn-home:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: #eef2ff;
        }

        .divider {
            width: 48px; height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            border-radius: 999px;
            margin: 0 auto 24px;
        }
    </style>
</head>
<body>
    <!-- Background blobs -->
    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>

    <div class="error-card">
        <!-- Lock icon -->
        <div class="icon-circle">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <!-- 403 badge -->
        <span class="badge-403">Error 403</span>

        <h1>Akses Ditolak</h1>
        <div class="divider"></div>

        <p class="desc">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
            Hubungi administrator jika Anda merasa ini adalah kesalahan.
        </p>

        <div class="d-flex justify-content-center flex-wrap gap-2">
            <!-- Tombol Kembali -->
            <a href="javascript:history.back()" class="btn-back">
                <i class="bi bi-arrow-left-circle-fill"></i>
                Kembali
            </a>

            <!-- Tombol Dashboard -->
            <a href="{{ url('/dashboard') }}" class="btn-home">
                <i class="bi bi-house-door"></i>
                Dashboard
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
