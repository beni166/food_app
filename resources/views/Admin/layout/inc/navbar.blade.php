<!-- Navbar Pro -->
<nav class="sb-topnav navbar navbar-expand navbar-dark" 
     style="background: linear-gradient(90deg, #1f1f2e 0%, #181824 100%); box-shadow: 0 2px 6px rgba(0,0,0,0.3);">

    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3 fw-bold text-uppercase" style="letter-spacing:1px;">BEN SHOP</a>

    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-white" id="sidebarToggle">
        <i class="fas fa-bars fa-lg"></i>
    </button>

   <!-- Notifications Dropdown -->
<ul class="navbar-nav ms-auto me-3">
    <li class="nav-item position-relative">
        <a class="nav-link" href="{{ route('admin.notifications.index') }}" title="Notifications">
            <i class="fas fa-bell fa-lg text-white"></i>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </a>
    </li>
</ul>


</nav>

<!-- Style Pro -->
<style>
    .navbar .form-control {
        border-radius: 20px 0 0 20px;
        padding: 10px 15px;
    }
    .navbar .btn-primary {
        border-radius: 0 20px 20px 0;
        background: #4e73df;
        border: none;
        transition: background 0.3s ease;
    }
    .navbar .btn-primary:hover {
        background: #3751d7;
    }
    .navbar .dropdown-menu {
        border: none;
        min-width: 200px;
        font-size: 0.9rem;
    }
    .navbar .dropdown-item {
        padding: 10px 15px;
        transition: background 0.2s ease;
    }
    .navbar .dropdown-item:hover {
        background: rgba(0, 0, 0, 0.05);
    }
</style>
