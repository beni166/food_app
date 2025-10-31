@extends('Admin.layout.app')

@section('title', 'Dashboard Utilisateurs')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Tableau de bord des utilisateurs</h2>

    <!-- Statistiques -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-3 rounded-4 text-center">
                <h6 class="text-muted">Total utilisateurs</h6>
                <h3 id="user-count" class="fw-bold">{{ $totalUsers }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 rounded-4 text-center">
                <h6 class="text-muted">Administrateurs</h6>
                <h3>{{ $totalAdmins }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 rounded-4 text-center">
                <h6 class="text-muted">Clients</h6>
                <h3>{{ $totalClients }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 rounded-4 text-center">
                <h6 class="text-muted">Inscrits ce mois</h6>
                <h3>{{ $newUsersThisMonth }}</h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Graphique -->
        <div class="col-md-8">
            <div class="card shadow-sm p-4 rounded-4">
                <h5 class="mb-3">Inscriptions par mois</h5>
                <canvas id="usersChart" height="200"></canvas>
            </div>
        </div>

        <!-- Utilisateurs récents -->
        <div class="col-md-4">
            <div class="card shadow-sm p-4 rounded-4 h-100">
                <h5 class="mb-3">Utilisateurs récents</h5>
                <ul class="list-group list-group-flush">
                    @foreach ($recentUsers as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">{{ $user->name }}</div>
                                <small>{{ $user->email }}</small><br>
                                <small>Inscrit le {{ $user->created_at->format('d/m/Y') }}</small>
                            </div>
                            <span class="badge rounded-pill bg-primary text-white">
                                {{ ucfirst($user->role ?? 'user') }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const userData = @json(array_values($usersByMonth));
const userLabels = @json(array_keys($usersByMonth));
const monthNames = ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"];

const formattedLabels = userLabels.map(label => {
    const parts = label.split('-');
    return monthNames[parseInt(parts[1]) - 1] + " " + parts[0].slice(2);
});

const ctx = document.getElementById('usersChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: formattedLabels,
        datasets: [{
            label: 'Utilisateurs inscrits',
            data: userData,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>
@endsection
