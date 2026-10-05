<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'School Management System')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: linear-gradient(135deg, #6366f1, #8b5cf6);
            --accent: #6366f1;
            --accent2: #8b5cf6;
            --topbar-height: 64px;
            --text-muted-custom: #94a3b8;
            --bg-main: #f1f5f9;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            margin: 0;
            padding: 0;
            color: #1e293b;
        }

        /* ======= SIDEBAR ======= */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid #1e293b;
        }

        .sidebar-brand .brand-icon {
            width: 40px; height: 40px;
            background: var(--sidebar-active);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; color: white;
            margin-bottom: 0.75rem;
        }

        .sidebar-brand h6 {
            color: white;
            font-weight: 700;
            font-size: 0.95rem;
            margin: 0;
            letter-spacing: 0.3px;
        }

        .sidebar-brand small {
            color: var(--text-muted-custom);
            font-size: 0.72rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
            flex: 1;
        }

        .sidebar-label {
            padding: 0.5rem 1.5rem 0.25rem;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #475569;
            font-weight: 600;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.5rem;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0;
            transition: all 0.2s ease;
            margin: 2px 0.75rem;
            border-radius: 8px;
        }

        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: #e2e8f0;
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35);
        }

        .sidebar-link i {
            font-size: 1.05rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #1e293b;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .user-info .user-name {
            color: #e2e8f0;
            font-size: 0.83rem;
            font-weight: 600;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-info .user-role {
            color: #64748b;
            font-size: 0.7rem;
            margin: 0;
        }

        .btn-logout-sidebar {
            width: 100%;
            background: #1e293b;
            border: 1px solid #334155;
            color: #94a3b8;
            padding: 0.5rem;
            border-radius: 8px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-logout-sidebar:hover {
            background: #dc2626;
            border-color: #dc2626;
            color: white;
        }

        /* ======= MAIN CONTENT ======= */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ======= TOPBAR ======= */
        .topbar {
            height: var(--topbar-height);
            background: white;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .topbar .breadcrumb {
            margin: 0;
            background: none;
            padding: 0;
            font-size: 0.83rem;
        }

        .topbar .breadcrumb-item a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }

        .topbar .breadcrumb-item.active {
            color: #64748b;
        }

        .topbar .breadcrumb-item + .breadcrumb-item::before {
            color: #cbd5e1;
        }

        /* ======= PAGE CONTENT ======= */
        .page-content {
            padding: 2rem;
            flex: 1;
        }

        /* ======= CARDS ======= */
        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 12px rgba(0,0,0,0.04);
        }

        .card-header-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .card-header-custom h4, .card-header-custom h2 {
            margin: 0;
            font-weight: 700;
            color: #0f172a;
        }

        /* ======= STAT CARDS ======= */
        .stat-card {
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12) !important;
        }

        .stat-card .stat-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .stat-card .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-card .stat-label {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 600;
            opacity: 0.8;
        }

        .stat-card .stat-bg-icon {
            position: absolute;
            right: -10px; bottom: -10px;
            font-size: 5rem;
            opacity: 0.08;
        }

        /* ======= TABLE ======= */
        .table-card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 12px rgba(0,0,0,0.04);
            overflow: hidden;
        }

        .table-card .table {
            margin: 0;
        }

        .table thead th {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 700;
            color: #64748b;
            padding: 0.85rem 1rem;
        }

        .table tbody td {
            padding: 0.85rem 1rem;
            vertical-align: middle;
            border-color: #f1f5f9;
            font-size: 0.875rem;
            color: #374151;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        /* ======= BUTTONS ======= */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 8px;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #f97316);
            border: none;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
            border-radius: 7px;
            transition: all 0.2s;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #d97706, #ea580c);
            color: white;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
            font-weight: 600;
            font-size: 0.8rem;
            border-radius: 7px;
            transition: all 0.2s;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            color: #374151;
        }

        /* ======= FORM ======= */
        .form-label {
            font-weight: 600;
            font-size: 0.83rem;
            color: #374151;
            margin-bottom: 0.4rem;
        }

        .form-control, .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 9px;
            padding: 0.6rem 0.85rem;
            font-size: 0.875rem;
            color: #1e293b;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #f8fafc;
        }

        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
            background: white;
            outline: none;
        }

        /* ======= ALERTS ======= */
        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border: 1px solid #6ee7b7;
            color: #065f46;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* ======= BADGE ROLE ======= */
        .badge-role {
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-admin { background: #ede9fe; color: #5b21b6; }
        .badge-teacher { background: #d1fae5; color: #065f46; }
        .badge-student { background: #dbeafe; color: #1e40af; }

        /* ======= PAGE TITLE ======= */
        .page-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .page-subtitle {
            font-size: 0.83rem;
            color: #94a3b8;
            margin: 0;
        }

        /* ======= EMPTY STATE ======= */
        .empty-state td {
            padding: 3rem !important;
            color: #94a3b8 !important;
        }

        /* ======= FADE IN ======= */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .page-content > * {
            animation: fadeInUp 0.35s ease both;
        }

        /* ======= RESPONSIVE ======= */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .mobile-toggle { display: flex !important; }
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.4rem;
            color: #374151;
            margin-right: 1rem;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h6>School Management</h6>
            <small>System</small>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-label">Main</div>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>

            <div class="sidebar-label mt-2">Academic</div>
            <a href="{{ route('students.index') }}" class="sidebar-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Students
            </a>
            <a href="{{ route('classes.index') }}" class="sidebar-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Classes
            </a>
            <a href="{{ route('subjects.index') }}" class="sidebar-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                <i class="bi bi-book-fill"></i> Subjects
            </a>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('teachers.index') }}" class="sidebar-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                <i class="bi bi-person-workspace"></i> Teachers
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->username, 0, 2)) }}</div>
                <div style="overflow: hidden;">
                    <p class="user-name">{{ auth()->user()->username }}</p>
                    <p class="user-role">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout-sidebar">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-wrapper">
        <!-- TOPBAR -->
        <div class="topbar">
            <button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @yield('breadcrumbs')
                </ol>
            </nav>
        </div>

        <!-- PAGE CONTENT -->
        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>