@extends('Admin.layout.app')

@section('title', 'Modifier une promotion')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Modifier la promotion</h3>
            <a href="{{ route('admin.promotion.index') }}" class="btn btn-secondary">← Retour</a>
        </div>

        {{-- Erreurs --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.promotion.update', $promotion) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Titre --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Titre :</label>
                <input type="text" name="titre" value="{{ old('titre', $promotion->titre) }}"
                    class="form-control @error('titre') is-invalid @enderror" required>
                @error('titre')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Produit --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Produit (optionnel) :</label>
                <select name="products_id" class="form-select @error('products_id') is-invalid @enderror">
                    <option value="">-- Aucun --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old('products_id', $promotion->products_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('products_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Catégorie --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Catégorie (optionnel) :</label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">-- Aucune --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $promotion->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Réduction --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Réduction (%) :</label>
                <div class="d-flex align-items-center gap-3">
                    <input type="range" min="1" max="100" value="{{ old('reduction', $promotion->reduction) }}" 
                        class="form-range" id="reductionSlider" name="reduction">
                    <span id="reductionValue" class="fw-bold">{{ old('reduction', $promotion->reduction) }}%</span>
                </div>
                @error('reduction')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Dates --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Date début :</label>
                    <input type="date" name="date_debut" class="form-control @error('date_debut') is-invalid @enderror" 
                        value="{{ old('date_debut', $promotion->date_debut) }}" required>
                    @error('date_debut')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Date fin :</label>
                    <input type="date" name="date_fin" class="form-control @error('date_fin') is-invalid @enderror" 
                        value="{{ old('date_fin', $promotion->date_fin) }}" required>
                    @error('date_fin')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

<script>
    const slider = document.getElementById('reductionSlider');
    const output = document.getElementById('reductionValue');
    slider.addEventListener('input', function() {
        output.textContent = slider.value + '%';
    });
</script>
@endsection
