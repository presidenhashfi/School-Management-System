<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — School Management System</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f172a;
            overflow: hidden;
        }

        /* ====== LEFT PANEL ====== */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4c1d95 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: rgba(99, 102, 241, 0.15);
            border-radius: 50%;
            top: -100px; left: -100px;
            animation: pulse 6s ease-in-out infinite;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: rgba(139, 92, 246, 0.12);
            border-radius: 50%;
            bottom: -80px; right: -80px;
            animation: pulse 8s ease-in-out infinite reverse;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50% { transform: scale(1.15); opacity: 1; }
        }

        .brand-logo {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; color: white;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.4);
            position: relative; z-index: 1;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .left-panel h1 {
            color: white;
            font-size: 2rem;
            font-weight: 800;
            text-align: center;
            position: relative; z-index: 1;
            letter-spacing: -0.5px;
            margin-bottom: 0.75rem;
        }

        .left-panel p {
            color: rgba(255,255,255,0.6);
            text-align: center;
            font-size: 0.9rem;
            position: relative; z-index: 1;
            max-width: 280px;
            line-height: 1.6;
        }

        .feature-list {
            list-style: none;
            margin-top: 2.5rem;
            position: relative; z-index: 1;
        }

        .feature-list li {
            color: rgba(255,255,255,0.75);
            font-size: 0.83rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 0.75rem;
            font-weight: 500;
        }

        .feature-list li .check {
            width: 22px; height: 22px;
            background: rgba(99, 102, 241, 0.3);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem;
            color: #a5b4fc;
            flex-shrink: 0;
        }

        /* ====== RIGHT PANEL (LOGIN FORM) ====== */
        .right-panel {
            width: 460px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
        }

        .login-box .welcome {
            margin-bottom: 2rem;
        }

        .login-box .welcome h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.4rem;
        }

        .login-box .welcome p {
            font-size: 0.875rem;
            color: #64748b;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
            letter-spacing: 0.2px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .input-icon {
            position: absolute;
            left: 0.85rem; top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.95rem;
            pointer-events: none;
        }

        .input-wrap input {
            width: 100%;
            padding: 0.7rem 0.85rem 0.7rem 2.5rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            color: #1e293b;
            background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .input-wrap input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        .error-msg {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            border-radius: 10px;
            color: white;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.45);
        }

        .login-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.75rem;
            color: #94a3b8;
        }

        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; }
        }
    </style>
</head>
<body>

    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="brand-logo">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <h1>School Management System</h1>
        <p>Platform manajemen sekolah terpadu yang modern dan efisien</p>

        <ul class="feature-list">
            <li>
                <span class="check"><i class="bi bi-check"></i></span>
                Manajemen Data Siswa & Guru
            </li>
            <li>
                <span class="check"><i class="bi bi-check"></i></span>
                Manajemen Kelas & Mata Pelajaran
            </li>
            <li>
                <span class="check"><i class="bi bi-check"></i></span>
                Sistem Role-Based Access Control
            </li>
            <li>
                <span class="check"><i class="bi bi-check"></i></span>
                Dashboard Ringkasan Statistik
            </li>
        </ul>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <div class="login-box">
            <div class="welcome">
                <h2>Selamat datang 👋</h2>
                <p>Masukkan kredensial Anda untuk mengakses sistem</p>
            </div>

            <form action="/login" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Alamat Email <span style="color:#ef4444;">*</span></label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" id="email"
                               placeholder="contoh@school.com"
                               value="{{ old('email') }}" autofocus required>
                    </div>
                    @error('email')
                        <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password <span style="color:#ef4444;">*</span></label>
                    <div class="input-wrap">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password" id="password"
                               placeholder="Masukkan password Anda..." required>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
                </button>
            </form>

            <div class="login-footer">
                &copy; {{ date('Y') }} School Management System. All rights reserved.
            </div>
        </div>
    </div>

</body>
</html>