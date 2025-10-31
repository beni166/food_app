<nav class="sb-topnav navbar navbar-expand navbar-dark"
    style="background: rgba(30, 30, 60, 0.85); backdrop-filter: blur(10px); box-shadow: 0 2px 6px rgba(0,0,0,0.3);">

    <!-- Navbar Brand -->
    <a class="navbar-brand ps-3 fw-bold text-uppercase" style="letter-spacing:1px; color:#e0e0ff;">
        BEN SHOP
    </a>

    <!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-white" id="sidebarToggle">
        <i class="fas fa-bars fa-lg"></i>
    </button>

    <!-- Notifications Dropdown -->
    <ul class="navbar-nav ms-auto me-3">
        <li class="nav-item position-relative">
            <a class="nav-link" href="{{ route('user.notifications.index') }}" title="Notifications">
                <i class="fas fa-bell fa-lg text-white"></i>
                @if (auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </a>
        </li>
    </ul>
</nav>

{{-- Styles CSS existants --}}
<style>
    .navbar {
        transition: all 0.3s ease;
        color: #e0e0ff;
    }

    .navbar .form-control {
        border-radius: 20px 0 0 20px;
        padding: 10px 15px;
        background: rgba(20, 20, 35, 0.85);
        color: #e0e0ff;
        border: none;
    }

    .navbar .form-control::placeholder {
        color: #b0b0ff;
    }

    .navbar .btn-primary {
        border-radius: 0 20px 20px 0;
        background: rgba(120, 90, 255, 0.7);
        border: none;
        color: #fff;
        transition: background 0.3s ease, transform 0.2s;
    }

    .navbar .btn-primary:hover {
        background: rgba(120, 90, 255, 0.9);
        transform: translateY(-2px);
    }

    .navbar .dropdown-menu {
        border: none;
        min-width: 220px;
        font-size: 0.9rem;
        backdrop-filter: blur(10px);
        background: rgba(30, 30, 60, 0.85);
        color: #e0e0ff;
    }

    .navbar .dropdown-item {
        padding: 10px 15px;
        transition: background 0.2s ease;
        color: #e0e0ff;
    }

    .navbar .dropdown-item:hover {
        background: rgba(120, 90, 255, 0.3);
    }
</style>
