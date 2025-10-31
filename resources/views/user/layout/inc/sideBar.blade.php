<!-- Sidebar Pro -->
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav sb-sidenav-dark" id="sidenavAccordion"
        style="background: rgba(30, 30, 60, 0.85); backdrop-filter: blur(10px);">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <!-- Section Core -->
                <a class="nav-link d-flex align-items-center" href="{{ route('welcome') }}">
                    <i class="fas fa-home me-2 fa-lg"></i>
                    <span>Accueil</span>
                </a>

                <a class="nav-link d-flex align-items-center" href="{{ route('user.dashboard') }}">
                    <i class="fas fa-chart-line me-2 fa-lg"></i>
                    <span>Dashboard</span>
                </a>
                <a class="nav-link d-flex align-items-center" href="{{ route('user.orders.index') }}">
                    <i class="fas fa-shopping-cart me-2 fa-lg"></i>
                    <span>Mes Commandes</span>
                </a>

                <!-- Section Addons -->
            </div>
        </div>

        <!-- Footer -->
        <div class="sb-sidenav-footer text-center py-3"
            style="background: rgba(20,20,35,0.85); border-top: 1px solid #444;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> {{ __('Se déconnecter') }}
                </a>
            </form>
        </div>
    </nav>
</div>

<!-- Style Pro Vif -->
<style>
    /* Sidebar background + blur */
    .sb-sidenav {
        transition: all 0.3s ease;
        color: #fff;
    }

    /* Links */
    .sb-sidenav .nav-link {
        color: #e0e0ff;
        padding: 12px 20px;
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 4px 8px;
        font-weight: 500;
    }

    .sb-sidenav .nav-link:hover {
        background: rgba(120, 90, 255, 0.4);
        /* violet vif */
        color: #ffffff;
        transform: translateX(6px);
    }

    /* Icon */
    .sb-sidenav .nav-link i {
        color: #b0b0ff;
        transition: color 0.3s;
    }

    .sb-sidenav .nav-link:hover i {
        color: #ffffff;
    }

    /* Headings */
    .sb-sidenav .sb-sidenav-menu-heading {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 10px 15px;
        letter-spacing: 1px;
        color: #a0a0ff;
    }

    /* Badges */
    .sb-sidenav .badge {
        font-size: 0.7rem;
        padding: 4px 8px;
        border-radius: 12px;
        background-color: #ff6f61;
        /* rouge vif */
        color: #fff;
        transition: transform 0.2s;
    }

    .sb-sidenav .badge:hover {
        transform: scale(1.1);
    }

    /* Footer */
    .sb-sidenav-footer {
        color: #d0d0ff;
        font-weight: 500;
    }
</style>
