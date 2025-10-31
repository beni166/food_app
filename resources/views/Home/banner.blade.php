<style>
    /* Styles personnalisés */
    .active-filter-btn {
        background-color: #28a745;
        color: #fff !important;
        border-color: #28a745;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: scale(1.03);
        transition: all 0.2s ease-in-out;
    }

    .card:hover {
        transform: scale(1.02);
        transition: transform 0.2s ease-in-out;
    }

    .fade-slide-in {
        animation: fadeSlideIn 0.5s ease forwards;
    }

    @keyframes fadeSlideIn {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hide {
        display: none !important;
    }

    .toast-container {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 1100;
    }

    .bg-grey-custom {
        background-color: rgba(128, 128, 128, 0.7);
    }
</style>


<!-- TOAST -->
<div class="toast-container">
    <div id="toast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Fermer"></button>
        </div>
    </div>
</div>

<!-- BANNIÈRE -->
<section class="banner position-relative w-100" style="height: 700px;">
    <div id="bannerCarousel" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner h-100">

            <!-- Slide 1 -->
            <div class="carousel-item active h-100"
                style="background: url('{{ asset('assets/admin/assets/img/delicieux-burger-avec-des-ingredients-frais.jpg') }}') center center / cover no-repeat;">
                <div
                    class="carousel-caption d-flex flex-column justify-content-center align-items-start text-start h-100 px-3 px-md-5">
                    <h1 class="text-capitalize py-3 redressed banner-desc fw-bold"
                        style="font-size: 3rem; text-shadow: 2px 2px 9px rgba(0,0,0,0.5); 
                               background: linear-gradient(45deg, #f12711, #f5af19); 
                               -webkit-background-clip: text; -webkit-text-fill-color:#fff7cc;">
                        Plongez dans un monde de saveurs <br>
                        où chaque bouchée raconte une histoire
                    </h1>

                    <!-- 🔍 Barre de recherche + bouton côte à côte -->
                    <div class="d-flex flex-wrap align-items-center gap-3 mt-4" style="max-width: 700px;">
                        <form action="{{ route('welcome') }}" method="GET" class="d-flex flex-grow-1"
                            style="min-width: 300px;">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Rechercher un produit, une catégorie..."
                                class="form-control rounded-pill px-4 py-2 border-0 shadow-sm flex-grow-1">
                        </form>

                        <a href="#produits" class="btn btn-success btn-lg rounded-pill px-4 py-2 shadow">
                            Passer une commande
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item h-100"
                style="background: url('{{ asset('assets/admin/assets/img/delicieuse-pizza-a-l-interieur.jpg') }}') center center / cover no-repeat;">
                <div
                    class="carousel-caption d-flex flex-column justify-content-center align-items-start text-start h-100 px-3 px-md-5">
                    <h1 class="text-capitalize py-3 redressed banner-desc fw-bold"
                        style="font-size: 3rem; text-shadow: 2px 2px 9px rgba(0,0,0,0.5); 
                               background: linear-gradient(45deg, #12c2e9, #c471ed); 
                               -webkit-background-clip: text; -webkit-text-fill-color:#fff7cc;">
                        Découvrez nos recettes exclusives <br>
                        préparées avec amour
                    </h1>
                   <div class="d-flex flex-wrap align-items-center gap-3 mt-4" style="max-width: 700px;">
                        <form action="{{ route('welcome') }}" method="GET" class="d-flex flex-grow-1"
                            style="min-width: 300px;">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Rechercher un produit, une catégorie..."
                                class="form-control rounded-pill px-4 py-2 border-0 shadow-sm flex-grow-1">
                        </form>

                        <a href="#produits" class="btn btn-success btn-lg rounded-pill px-4 py-2 shadow">
                            Passer une commande
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item h-100"
                style="background: url('{{ asset('assets/admin/assets/img/une-delicieuse-pizza-en-studio.jpg') }}') center center / cover no-repeat;">
                <div
                    class="carousel-caption d-flex flex-column justify-content-center align-items-start text-start h-100 px-3 px-md-5">
                    <h1 class="text-capitalize py-3 redressed banner-desc fw-bold"
                        style="font-size: 3rem; text-shadow: 2px 2px 9px rgba(0,0,0,0.5); 
                               background: linear-gradient(45deg, #f7971e, #ffd200); 
                               -webkit-background-clip: text; -webkit-text-fill-color:#fff7cc;">
                        Savourez l'instant <br>
                        avec nos créations gourmandes
                    </h1>
                   <div class="d-flex flex-wrap align-items-center gap-3 mt-4" style="max-width: 700px;">
                        <form action="{{ route('welcome') }}" method="GET" class="d-flex flex-grow-1"
                            style="min-width: 300px;">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Rechercher un produit, une catégorie..."
                                class="form-control rounded-pill px-4 py-2 border-0 shadow-sm flex-grow-1">
                        </form>

                        <a href="#produits" class="btn btn-success btn-lg rounded-pill px-4 py-2 shadow">
                            Passer une commande
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contrôles & indicateurs -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>







<!-- CATÉGORIES ET PRODUITS -->
<section class="py-5" style="background: linear-gradient(to bottom, rgba(255,255,255,0.95), #f8f9fa);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="text-uppercase fw-bold" data-aos="fade-up">Catégories</h2>
        </div>

        <!-- Boutons de filtre -->
        <div class="d-flex flex-wrap justify-content-center mb-4" id="categories">
            <button type="button"
                class="btn m-2 btn-outline-primary active-filter-btn px-4 py-2 rounded-pill shadow-sm"
                data-category-id="all">Tous</button>
            @foreach ($categories as $item)
                <button type="button" class="btn btn-outline-primary m-2 px-4 py-2 rounded-pill shadow-sm"
                    data-category-id="{{ $item->id }}">{{ $item->name }}</button>
            @endforeach
        </div>

        <!-- Affichage des produits -->
        <div class="row" id="produits">
            @foreach ($products as $product)
                @php
                    $now = now();
                    $activePromo = null;

                    if (
                        $product->promotion &&
                        $product->promotion->date_debut <= $now &&
                        $product->promotion->date_fin >= $now
                    ) {
                        $activePromo = $product->promotion;
                    }

                    if (!$activePromo && $product->category && $product->category->promotion) {
                        $promoCat = $product->category->promotion;
                        if ($promoCat->date_debut <= $now && $promoCat->date_fin >= $now) {
                            $activePromo = $promoCat;
                        }
                    }

                    if (
                        !$activePromo &&
                        isset($globalPromo) &&
                        $globalPromo->date_debut <= $now &&
                        $globalPromo->date_fin >= $now
                    ) {
                        $activePromo = $globalPromo;
                    }

                    $original = floatval($product->prix);
                    $finalPrice = $original;
                    $reduction = null;

                    if ($activePromo) {
                        $reduction = $activePromo->reduction;
                        $finalPrice = $original - ($original * $reduction) / 100;
                    }
                @endphp

                <div class="col-md-4 mb-4 produit" data-category-id="{{ $product->category_id }}" data-aos="fade-up">
                    <div class="card shadow-sm h-100 position-relative">
                        <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}"
                            style="object-fit: cover; height: 300px; width: 100%;" loading="lazy">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $product->name }}</h5>

                            @if ($activePromo)
                                <span
                                    class="badge bg-danger position-absolute top-0 end-0 m-2">-{{ $reduction }}%</span>
                                <p class="text-muted mb-0"><del>{{ number_format($original, 0, ',', ' ') }} FCFA</del>
                                </p>
                                <p class="fw-bold text-success">{{ number_format($finalPrice, 0, ',', ' ') }} FCFA</p>
                            @else
                                <p class="text-muted fw-bold">{{ number_format($original, 0, ',', ' ') }} FCFA</p>
                            @endif

                            <div class="d-flex justify-content-center mt-2">
                                <a href="{{ route('commande.produit', ['id' => $product->id]) }}"
                                    class="btn btn-sm btn-primary rounded-pill px-3">Passer Commande</a>
                            </div>

                            <form action="{{ route('cart.ajouter') }}" method="POST"
                                class="form-add-to-cart mt-3 d-flex justify-content-center gap-2">
                                @csrf
                                <input type="hidden" name="produit_id" value="{{ $product->id }}">
                                <input type="number" name="quantite" value="1" min="1"
                                    class="form-control form-control-sm text-center" style="width: 60px;">
                                <button type="submit"
                                    class="btn btn-sm btn-outline-secondary rounded-pill d-flex align-items-center">
                                    <i class="bi bi-cart4 fs-5"></i>
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- POURQUOI NOUS CHOISIR -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold text-uppercase mb-3" data-aos="fade-up">Pourquoi nous choisir ?</h2>
        <p class="text-muted mb-5" data-aos="fade-up" data-aos-delay="200">Nous mettons tout notre savoir-faire au
            service de votre satisfaction.</p>
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-award-fill fs-1 text-warning mb-3"></i>
                <h5 class="fw-bold">Produits de qualité</h5>
                <p>Des ingrédients frais et locaux pour un goût exceptionnel.</p>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="600">
                <i class="bi bi-truck fs-1 text-primary mb-3"></i>
                <h5 class="fw-bold">Livraison rapide</h5>
                <p>Recevez vos commandes en un temps record, avec soin.</p>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="800">
                <i class="bi bi-heart-fill fs-1 text-danger mb-3"></i>
                <h5 class="fw-bold">Service client</h5>
                <p>Nous sommes toujours à l'écoute pour mieux vous servir.</p>
            </div>
        </div>
    </div>
</section>

<!-- Notre Histoire -->
<section class="py-5" style="background: #e9ecef;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-up">
                <img src="{{ asset('assets/admin/assets/img/restaurant-interieur.jpg') }}"
                    class="img-fluid rounded shadow" alt="Notre histoire">
            </div>
            <div class="col-md-6">
                <h2 class="fw-bold text-uppercase mb-3">Notre Histoire</h2>
                <p class="text-muted mb-3">Depuis nos débuts, nous nous engageons à offrir des plats savoureux préparés
                    avec passion. Chaque recette raconte une histoire de tradition, de qualité et d’amour pour la
                    gastronomie.</p>
                <p class="text-muted mb-3">Notre objectif est de partager avec vous des moments de plaisir et de
                    convivialité, en vous proposant des produits frais, locaux et de saison. Nous croyons que chaque
                    bouchée peut créer un souvenir mémorable.</p>
                <a href="#produits" class="btn btn-primary rounded-pill px-4 py-2 mt-2">Découvrir nos produits</a>
            </div>
        </div>
    </div>
</section>

<!-- Témoignages -->
<section class="py-5 position-relative text-white"
    style="background: url('{{ asset('assets/admin/assets/img/vue-de-dessus-fast-food-mix-batonnets-de-mozzarella-club-sandwich-hamburger-pizza-aux-champignons-pizza-cesar-salade-de-crevettes-frites-ketchup-mayo-et-sauces-au-fromage-sur-la-table.jpg') }}') center/cover no-repeat;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0,0,0,0.5);"></div>
    <div class="container position-relative">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-uppercase" data-aos="fade-up">Ce que disent nos clients</h2>
            <p class="text-light" data-aos="fade-up" data-aos-delay="200">La satisfaction de nos clients est notre
                priorité.</p>
        </div>

        <div id="carouselTemoignages" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner text-center">
                <!-- Items -->
                <div class="carousel-item active">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('assets/admin/assets/img/istockphoto-1988099071-1024x1024.jpg') }}"
                            alt="Fatou D." class="rounded-circle mb-3"
                            style="width:80px;height:80px;object-fit:cover;">
                    </div>
                    <blockquote class="blockquote text-white">
                        <p class="mb-4">"Un service au top, des plats délicieux. Je recommande vivement !"</p>
                        <footer class="blockquote-footer text-light">Fatou D.</footer>
                    </blockquote>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('assets/admin/assets/img/istockphoto-1812019451-1024x1024.jpg') }}"
                            alt="Mamadou B." class="rounded-circle mb-3"
                            style="width:80px;height:80px;object-fit:cover;">
                    </div>
                    <blockquote class="blockquote text-white">
                        <p class="mb-4">"Livraison rapide et repas encore chauds. Très pro."</p>
                        <footer class="blockquote-footer text-light">Mamadou B.</footer>
                    </blockquote>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('assets/admin/assets/img/istockphoto-1708130463-1024x1024.jpg') }}"
                            alt="Aïssatou S." class="rounded-circle mb-3"
                            style="width:80px;height:80px;object-fit:cover;">
                    </div>
                    <blockquote class="blockquote text-white">
                        <p class="mb-4">"Des produits de qualité et un goût authentique."</p>
                        <footer class="blockquote-footer text-light">Aïssatou S.</footer>
                    </blockquote>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselTemoignages"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-grey-custom rounded-circle" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselTemoignages"
                data-bs-slide="next">
                <span class="carousel-control-next-icon bg-grey-custom rounded-circle" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<script>
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true
    });

    // Filtre catégories
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('#categories button');
        const produits = document.querySelectorAll('.produit');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const categoryId = button.dataset.categoryId;
                buttons.forEach(btn => btn.classList.remove('active-filter-btn'));
                button.classList.add('active-filter-btn');

                produits.forEach(produit => {
                    produit.classList.toggle('hide', categoryId !== 'all' && produit
                        .dataset.categoryId !== categoryId);
                    if (!produit.classList.contains('hide')) produit.classList.add(
                        'fade-slide-in');
                });
            });
        });

        // AJAX ajout au panier
        document.querySelectorAll(".form-add-to-cart").forEach(form => {
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                fetch(this.action, {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": formData.get("_token")
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        const toastEl = document.getElementById('toast');
                        toastEl.querySelector('.toast-body').textContent = data.message;
                        const toast = new bootstrap.Toast(toastEl, {
                            autohide: true,
                            delay: 3000
                        });
                        toast.show();
                        if (document.getElementById("cart-count")) document.getElementById(
                            "cart-count").textContent = data.panier_count;
                    })
                    .catch(err => console.error(err));
            });
        });
    });
</script>
