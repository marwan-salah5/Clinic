<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'عيادات القافلة الطبية')</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css?v=2">
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 20px;
            margin: 5px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(-5px);
        }

        .sidebar .nav-link i {
            margin-left: 10px;
            font-size: 1.2rem;
        }

        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .stats-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .stats-card.patients .icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stats-card.appointments .icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .stats-card.medical .icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .stats-card.followups .icon {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .stats-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin: 10px 0;
            color: #2d3748;
        }

        .stats-card p {
            color: #718096;
            margin: 0;
        }

        .table {
            background: white;
            border-radius: 10px;
        }

        .table thead {
            background: #f7fafc;
        }

        .badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 500;
        }

        .logo {
            padding: 30px 20px;
            text-align: center;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .logo h4 {
            margin: 10px 0 0 0;
            font-weight: 700;
        }

        .logo i {
            font-size: 3rem;
        }

        .user-info {
            padding: 15px 20px;
            margin: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: white;
            text-align: center;
        }

        .user-info .user-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-info .user-role {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .logout-btn {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: white;
            width: calc(100% - 30px);
            margin: 10px 15px;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(220, 53, 69, 0.4);
            transform: translateX(-5px);
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="logo">
                    <i class="bi bi-hospital"></i>
                    <h4>عيادات القافلة الطبية</h4>
                </div>

                <!-- User Info -->
                <div class="user-info">
                    <div class="user-name">
                        <i class="bi bi-person-circle me-2"></i>
                        {{ auth()->user()->name }}
                    </div>
                    <div class="user-role">
                        @if(auth()->user()->isAdmin())
                            <span class="badge bg-danger">مدير</span>
                        @elseif(auth()->user()->department_id)
                            <span class="badge bg-success">طبيب</span>
                        @else
                            <span class="badge bg-info">موظف</span>
                        @endif
                    </div>
                </div>

                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        لوحة التحكم
                    </a>

                    @if(auth()->user()->isAdmin() || !auth()->user()->department_id)
                        <a class="nav-link {{ request()->is('patients*') ? 'active' : '' }}"
                            href="{{ route('patients.index') }}">
                            <i class="bi bi-people"></i>
                            المرضى
                        </a>
                    @endif

                    <a class="nav-link {{ request()->is('appointments*') ? 'active' : '' }}"
                        href="{{ route('appointments.index') }}">
                        <i class="bi bi-calendar-check"></i>
                        المواعيد
                    </a>

                    <a class="nav-link {{ request()->is('medical-history*') ? 'active' : '' }}"
                        href="{{ route('medical-history.index') }}">
                        <i class="bi bi-file-medical"></i>
                        التاريخ المرضي
                    </a>

                    @if(auth()->user()->isAdmin() || !auth()->user()->department_id)
                        <a class="nav-link {{ request()->is('follow-ups*') ? 'active' : '' }}"
                            href="{{ route('follow-ups.index') }}">
                            <i class="bi bi-arrow-repeat"></i>
                            المتابعة
                        </a>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <a class="nav-link {{ request()->is('reports*') ? 'active' : '' }}"
                            href="{{ route('reports.index') }}">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                            التقارير
                        </a>

                        <a class="nav-link {{ request()->is('doctors*') ? 'active' : '' }}"
                            href="{{ route('doctors.index') }}">
                            <i class="bi bi-stethoscope"></i>
                            الأطباء
                        </a>

                        <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="bi bi-people-fill"></i>
                            إدارة المستخدمين
                        </a>
                    @endif
                </nav>

                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        تسجيل الخروج
                    </button>
                </form>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('scripts')
</body>

</html>