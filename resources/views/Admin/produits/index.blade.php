@extends('Admin.layout.app')
@section('title')
    Produits
@endsection

@section('content')
    <div class="col-md-10 mx-auto my-5">
        <div class="card shadow-lg border-0 rounded-4">

            {{-- Message de succès --}}
            @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show m-3" id="alert-message" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Header --}}
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
                <h4 class="mb-0">
                    <i class="fas fa-boxes me-2"></i> Listes des Produits
                </h4>
                <a href="{{ route('admin.Produits.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i> Ajouter
                </a>
            </div>

            {{-- Tableau --}}
            <div class="table-responsive p-3">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Image</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produits as $item)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $item->id }}</span></td>
                                <td class="fw-semibold">{{ $item->name }}</td>
                                <td class="text-muted"
                                    style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $item->description }}
                                </td>
                                <td class="fw-bold text-success">{{ number_format($item->prix, 0, ',', ' ') }} F</td>
                                <td>
                                    <a href="{{ asset('/' . $item->image) }}" target="_blank">
                                        <img src="{{ asset('/' . $item->image) }}" class="rounded shadow-sm border"
                                            style="height:80px; width:80px; object-fit:cover" alt="Produit">
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.Produits.edit', $item->slug) }}"
                                        class="btn btn-sm btn-outline-primary me-1" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.Produits.destroy', $item->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="card-footer bg-light d-flex justify-content-center">
                {{ $produits->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
