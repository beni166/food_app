@extends('Admin.layout.app')

@section('title', 'Dashboard Dynamique')

@section('content')
<div class="container py-4">

    <!-- Stats Cards Dynamique -->
    <div class="row g-4 mb-5">
        <!-- Total commandes -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 p-3 position-relative overflow-hidden dynamic-card">
                <div class="card-body">
                    <p class="text-muted mb-1">Total des commandes</p>
                    <h3 class="fw-bold mb-2 counter" data-target="{{ $totalOrders }}">0</h3>
                    <canvas id="ordersSparkline" height="40"></canvas>
                    <div class="position-absolute top-0 end-0 p-3">
                        <i class="fas fa-shopping-cart fs-3 text-white icon-bg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenu total -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 p-3 position-relative overflow-hidden dynamic-card">
                <div class="card-body">
                    <p class="text-muted mb-1">Revenu total</p>
                    <h3 class="fw-bold mb-2 counter" data-target="{{ $totalRevenue }}">0</h3>
                    <canvas id="revenueSparkline" height="40"></canvas>
                    <div class="position-absolute top-0 end-0 p-3">
                        <i class="fas fa-coins fs-3 text-white icon-bg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panier moyen -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 p-3 position-relative overflow-hidden dynamic-card">
                <div class="card-body">
                    <p class="text-muted mb-1">Panier moyen</p>
                    <h3 class="fw-bold mb-2 counter" data-target="{{ $averageCart }}">0</h3>
                    <canvas id="cartSparkline" height="40"></canvas>
                    <div class="position-absolute top-0 end-0 p-3">
                        <i class="fas fa-shopping-basket fs-3 text-white icon-bg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meilleur produit -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 p-3 position-relative overflow-hidden dynamic-card">
                <div class="card-body">
                    <p class="text-muted mb-1">Meilleur produit</p>
                    <h3 class="fw-bold mb-2">{{ $topProducts->first()->name ?? 'N/A' }}</h3>
                    <canvas id="productSparkline" height="40"></canvas>
                    <div class="position-absolute top-0 end-0 p-3">
                        <i class="fas fa-star fs-3 text-white icon-bg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques principaux -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Revenus et commandes mensuels</h5>
                    <canvas id="mainRevenueChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Produits les plus vendus</h5>
                    <ul class="list-unstyled">
                        @php
                            $maxSold = max($topProducts->pluck('total_sold')->toArray());
                        @endphp
                        @foreach ($topProducts as $product)
                            @php
                                $intensity = $product->total_sold / $maxSold;
                                $r = (int) (255 * (1 - $intensity));
                                $g = (int) (167 + (255 - 167) * $intensity);
                                $b = (int) (77 * (1 - $intensity));
                                $backgroundColor = "rgb($r, $g, $b)";
                                $textColor = $intensity > 0.6 ? 'text-white' : 'text-dark';
                            @endphp
                            <li class="d-flex justify-content-between align-items-center rounded px-3 py-2 mb-2"
                                style="background-color: {{ $backgroundColor }};">
                                <span class="{{ $textColor }}">{{ $product->name }}</span>
                                <span class="fw-semibold {{ $textColor }}">{{ $product->total_sold }} vendus</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Counter animation
    document.querySelectorAll('.counter').forEach(el => {
        let target = +el.dataset.target;
        let current = 0;
        const increment = target / 100; // vitesse
        const interval = setInterval(() => {
            current += increment;
            if(current >= target) current = target;
            el.textContent = new Intl.NumberFormat().format(Math.floor(current));
            if(current >= target) clearInterval(interval);
        }, 15);
    });

    // Sparkline options
    const sparkOptions = {
        type: 'line',
        options: {
            responsive: true,
            elements: { line: { tension: 0.3 } },
            plugins: { legend: { display: false } },
            scales: { x: { display: false }, y: { display: false } }
        }
    };

    // Mini Graphiques
    const ordersSpark = document.getElementById('ordersSparkline').getContext('2d');
    new Chart(ordersSpark, { ...sparkOptions, data: { labels: @json(array_keys($ordersByMonth)), datasets: [{ data: @json(array_values($ordersByMonth)), borderColor: '#4F46E5', backgroundColor: 'rgba(79,70,229,0.15)', fill: true }] } });

    const revenueSpark = document.getElementById('revenueSparkline').getContext('2d');
    new Chart(revenueSpark, { ...sparkOptions, data: { labels: @json(array_keys($salesByMonth)), datasets: [{ data: @json(array_values($salesByMonth)), borderColor: '#10B981', backgroundColor: 'rgba(16,185,129,0.15)', fill: true }] } });

    const cartSpark = document.getElementById('cartSparkline').getContext('2d');
    new Chart(cartSpark, { ...sparkOptions, data: { labels: @json(array_keys($salesByMonth)), datasets: [{ data: @json(array_values($averageCartByMonth ?? [])), borderColor: '#F59E0B', backgroundColor: 'rgba(245,158,11,0.15)', fill: true }] } });

    const productSpark = document.getElementById('productSparkline').getContext('2d');
    new Chart(productSpark, { ...sparkOptions, data: { labels: @json($topProducts->pluck('name')), datasets: [{ data: @json($topProducts->pluck('total_sold')), borderColor: '#9333EA', backgroundColor: 'rgba(147,51,234,0.15)', fill: true }] } });

    // Graphique principal
    const mainCtx = document.getElementById('mainRevenueChart').getContext('2d');
    new Chart(mainCtx, {
        type: 'line',
        data: {
            labels: @json(array_keys($salesByMonth)),
            datasets: [
                { label: 'Revenu (FCFA)', data: @json(array_values($salesByMonth)), borderColor: '#4F46E5', backgroundColor: ctx => { return ctx.chart.ctx.createLinearGradient(0,0,0,250).addColorStop(0,'rgba(79,70,229,0.25)'); }, fill: true, tension: 0.4 },
                { label: 'Commandes', data: @json(array_values($ordersByMonth)), borderColor: '#10B981', backgroundColor: 'rgba(16,185,129,0.15)', fill: true, tension: 0.4 }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } },
            scales: { y: { beginAtZero: true }, x: { grid: { display: false } } }
        }
    });

});
</script>
<style>
.dynamic-card {
    transition: transform 0.3s ease, background-color 0.5s ease;
    border-radius: 12px;
}
.dynamic-card:hover {
    transform: translateY(-8px);
    background-color: rgba(79,70,229,0.05);
}
.icon-bg {
    opacity: 0.15;
    font-size: 2.5rem;
}
</style>
@endsection
