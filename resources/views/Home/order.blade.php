<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/styles.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/admin/js/bootstrap.v.5.3.2/bootstrap.min.css') }}">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    @auth
        <section style="background-color: #f8f9fa;">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card shadow rounded-4 border-0">
                            <img src="{{ asset('/' . $produit->image) }}" class="card-img-top rounded-top"
                                style="object-fit:cover;height: 300px;" alt="Image {{ $produit->name }}">
                            <div class="card-body p-4">
                                <h3 class="card-title text-center mb-3">{{ $produit->name }}</h3>
                                <h5 class="text-center text-muted mb-2">{{ $produit->prix }} CFA</h5>

                                {{-- Nouvelle section Description --}}
                                <p class="text-muted text-center mb-4">
                                    {{ $produit->description ?? 'Aucune description disponible.' }}
                                </p>

                                @auth
                                    {{-- Formulaire de commande directe --}}
                                    <form action="{{ route('commande.create') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">

                                        <div class="mb-3">
                                            <label for="quantite" class="form-label fw-semibold">Quantité</label>
                                            <input type="number" name="quantite" id="quantite" class="form-control"
                                                min="1" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100 rounded-pill mt-3 fw-bold">
                                            <i class="bi bi-bag-check-fill me-2"></i> Commander maintenant
                                        </button>
                                    </form>
                                @else
                                    {{-- Message pour les invités --}}
                                    <div class="text-center mt-4">
                                        <h5 class="text-danger">
                                            Vous devez être connecté pour commander ou ajouter au panier.
                                        </h5>
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary mt-3">
                                            <i class="bi bi-box-arrow-in-right me-1"></i> Se connecter
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion Requise - MonShop</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, rgba(251, 142, 74, 0.881), #e0e7ef);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            /* Card principale */
            .card-invite {
                border-radius: 1.2rem;
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
                transition: transform 0.3s, box-shadow 0.3s;
            }

            .card-invite:hover {
                transform: translateY(-10px);
                box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
            }

            /* Bouton avec effet hover */
            .btn-hover {
                position: relative;
                overflow: hidden;
                transition: all 0.3s;
            }

            .btn-hover::after {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.2);
                transition: all 0.3s;
            }

            .btn-hover:hover::after {
                left: 0;
            }

            /* Illustration SVG */
            .illustration {
                max-width: 150px;
                margin-bottom: 1rem;
            }
        </style>
    </head>

    <body>



        <!-- Section principale -->
        <div class="container my-5 flex-grow-1 d-flex justify-content-center align-items-center">
            <div class="card card-invite text-center p-4" style="max-width: 450px;">
                <div class="card-body">
                    {{-- Illustration SVG --}}
                    <img src="https://www.svgrepo.com/show/331491/shopping-cart-empty.svg" alt="Panier vide"
                        class="illustration">

                    {{-- Titre --}}
                    <h4 class="card-title fw-bold mb-2">Oups ! Vous n'êtes pas connecté.</h4>

                    {{-- Message --}}
                    <p class="card-text text-muted mb-4">
                        Pour commander vos produits préférés ou ajouter des articles au panier, vous devez vous
                        connecter.
                    </p>

                    {{-- Bouton de connexion --}}
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg btn-hover shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white text-center py-3 shadow-sm mt-auto">
            &copy; {{ date('Y') }} MonShop. Tous droits réservés.
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>

@endauth

</body>

</html>
