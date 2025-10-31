<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') food</title>
<<<<<<< HEAD

=======
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous">
    </script>
>>>>>>> 5e5516e (food app)
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <title>@yield('title') - MyEcom</title>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
    <link href="{{ asset('assets/admin/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/admin/js/bootstrap.v.5.3.2/bootstrap.min.css') }}">
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
<<<<<<< HEAD
    
=======

>>>>>>> 5e5516e (food app)
</head>

<body>

    @if (Route::has('login'))
        <nav class="cc-navbar navbar navbar-expand-lg position-fixed navbar-dark w-100">
            <div class="container-fluid mx-4 py-3">
                <a class="navbar-brand text-uppercase fw-bolder" href="#">BEN FOOD</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link pe-4 active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pe-4" href="#categories">Catégories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pe-4" href="#produits">Nos Produits</a>
                        </li>

                        @auth
                            @if (auth()->user()->role === 'admin')
                                <li class="nav-item">
                                    <a class="nav-link pe-4 position-relative" href="{{ route('cart.index') }}">
                                        <i class="bi bi-cart-fill"></i>
                                        Mon panier
                                        @if (isset($cartCount) && $cartCount > 0)
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                                style="background: blue">
                                                {{ $cartCount }}
                                            </span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pe-4" href="{{ route('admin.orders.index') }}">Admin Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="nav-link btn btn-link pe-4"
                                            style="text-decoration: none;">
                                            Déconnexion
                                        </button>
                                    </form>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link pe-4 position-relative" href="{{ route('cart.index') }}">
                                        <i class="bi bi-cart-fill"></i>
                                        Mon panier
                                        @if (isset($cartCount) && $cartCount > 0)
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                                style="background: blue">
                                                {{ $cartCount }}
                                            </span>
                                        @endif
                                    </a>

                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pe-4" href="{{ route('user.dashboard') }}">user Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="nav-link btn btn-link pe-4"
                                            style="text-decoration: none;">
                                            Déconnexion
                                        </button>
                                    </form>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link pe-4" href="{{ route('login') }}">Se Connecter</a>
                            </li>

                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    @endif


    @yield('content')

    @if (session('success'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
            <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Fermer"></button>
                </div>
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toastEl = document.getElementById('successToast');
                const toast = new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 5000 // disparaît automatiquement après 5s
                });
                toast.show();
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init();
        });
    </script>



    <script src="{{ asset('assets/admin/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.v.5.3.2/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
