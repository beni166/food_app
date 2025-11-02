<!-- Sidebar Pro -->
<div id="layoutSidenav_nav">

        <div class="sb-sidenav-menu">
            <div class="nav">

                <!-- Section Core -->

                <a class="nav-link d-flex align-items-center" href="{{ route('welcome') }}">
                    <i class="fas fa-home me-2 fa-lg"></i>
                    <span>Accueil</span>
                </a>
                <!-- Section Interface -->
                <a class="nav-link d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-chart-line me-2 fa-lg"></i>
                    <span>Dashboard</span>
                </a>

                <a class="nav-link d-flex align-items-center" href="{{ route('admin.Produits.index') }}">
                    <i class="fas fa-box me-2 fa-lg"></i>
                    <span>Produits</span>
                </a>
                <a class="nav-link d-flex align-items-center" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-th-list me-2 fa-lg"></i>
                    <span>Catégories</span>
                </a>
                <a class="nav-link d-flex align-items-center" href="{{ route('admin.promotion.index') }}">
                    <i class="fas fa-tags me-2 fa-lg"></i>
                    <span>Promotions</span>
                </a>
                <a class="nav-link d-flex align-items-center" href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-shopping-cart me-2 fa-lg"></i>
                    <span>Commandes</span>
                </a>

                <a class="nav-link d-flex align-items-center" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users me-2 fa-lg"></i>
                    <span>Utilisateurs</span>
                </a>
                <a class="nav-link d-flex align-items-center" href="{{ route('admin.profile.user') }}">
                    <i class="fas fa-user-circle me-2 fa-lg"></i>
                    <span>Mon profil</span>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="sb-sidenav-footer text-center py-3" style="background: #11111b; border-top: 1px solid #2c2c3e;">
            <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> {{ __('Se déconnecter') }}
                    </a>
                </form>
        </div>
</div>

<!-- Style Pro -->
<style>
    .sb-sidenav .nav-link {
        color: #cfd2da;
        padding: 12px 20px;
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 4px 8px;
        font-weight: 500;
    }

    .sb-sidenav .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        transform: translateX(6px);
    }

    .sb-sidenav .nav-link i {
        color: #9fa2b4;
        transition: color 0.3s;
    }

    .sb-sidenav .nav-link:hover i {
        color: #ffffff;
    }

    .sb-sidenav .sb-sidenav-menu-heading {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 10px 15px;
        letter-spacing: 1px;
    }

    .sb-sidenav .badge {
        font-size: 0.7rem;
        padding: 4px 8px;
        border-radius: 12px;
    }
</style>
