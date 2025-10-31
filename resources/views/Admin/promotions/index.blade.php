@extends('Admin.layout.app')
@section('title', 'Promotions')

@section('content')
<div class="col-md-10 mx-auto my-5">
    <div class="card shadow-lg border-0 rounded-4">

        {{-- Header --}}
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="mb-0"><i class="fas fa-tags me-2"></i> Promotions</h4>
            <a href="{{ route('admin.promotion.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-1"></i> Ajouter
            </a>
        </div>

        {{-- Message flash --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Formulaire de filtre --}}
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Filtrer par produit</label>
                    <select name="product_id" class="form-select">
                        <option value="">-- Tous --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Filtrer par catégorie</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Toutes --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    <a href="{{ route('admin.promotion.index') }}" class="btn btn-secondary">Réinitialiser</a>
                </div>
            </form>

            {{-- Tableau --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Titre</th>
                            <th>Cible</th>
                            <th>Réduction</th>
                            <th>Période</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($promotions as $promo)
                            @php
                                $now = now();
                                $isExpired = $promo->date_fin < $now;
                                $status = $isExpired ? 'Expirée' : ($promo->actif ? 'Active' : 'Inactive');
                                $statusColor = $isExpired ? 'secondary' : ($promo->actif ? 'success' : 'dark');
                            @endphp
                            <tr>
                                <td class="fw-semibold">{{ $promo->titre }}</td>
                                <td>
                                    @if ($promo->product)
                                        Produit : {{ $promo->product->name }}
                                    @elseif($promo->category)
                                        Catégorie : {{ $promo->category->name }}
                                    @else
                                        Globale
                                    @endif
                                </td>
                                <td>{{ $promo->reduction }}%</td>
                                <td>{{ $promo->date_debut }} → {{ $promo->date_fin }}</td>
                                <td><span class="badge bg-{{ $statusColor }}">{{ $status }}</span></td>
                                <td class="text-center d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.promotion.edit', $promo) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.promotion.toggle', $promo) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $promo->actif ? 'warning' : 'success' }}">
                                            {{ $promo->actif ? 'Désactiver' : 'Activer' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.promotion.destroy', $promo) }}" method="POST"
                                          onsubmit="return confirm('Supprimer cette promotion ?')" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Aucune promotion trouvée</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(method_exists($promotions, 'links'))
                <div class="mt-3 d-flex justify-content-center">
                    {{ $promotions->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
