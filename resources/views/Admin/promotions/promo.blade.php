@extends('Admin.layout.app')

@section('title', 'Créer une promotion')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg rounded-4 p-4">
        <h3 class="mb-4 text-center">Créer une nouvelle promotion</h3>

        {{-- Message d'erreurs --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.promotion.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="titre" class="form-label fw-bold">Titre de la promotion :</label>
                <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre') }}" required>
                @error('titre')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Produit (optionnel) :</label>
                <select name="products_id" class="form-select @error('products_id') is-invalid @enderror">
                    <option value="">-- Aucune --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('products_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('products_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Catégorie (optionnel) :</label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">-- Aucune --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Réduction (%) :</label>
                <input type="number" name="reduction" class="form-control @error('reduction') is-invalid @enderror" value="{{ old('reduction') }}" min="1" max="100" required>
                @error('reduction')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Date début :</label>
                    <input type="date" name="date_debut" class="form-control @error('date_debut') is-invalid @enderror" value="{{ old('date_debut') }}" required min="{{ date('Y-m-d') }}">
                    @error('date_debut')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Date fin :</label>
                    <input type="date" name="date_fin" class="form-control @error('date_fin') is-invalid @enderror" value="{{ old('date_fin') }}" required min="{{ date('Y-m-d') }}">
                    @error('date_fin')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
