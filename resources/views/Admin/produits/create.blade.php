@extends('admin.layout.app')
@section('title')
    Ajouter un Produit
@endsection

@section('content')
<div class="col-md-8 mx-auto my-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center fw-bold fs-5 rounded-top">
            Ajouter un nouveau produit
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.Produits.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Catégorie -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Catégorie</label>
                    <select name="category" class="form-select @error('categories') is-invalid @enderror">
                        <option value="" hidden selected>-- Sélectionner la catégorie --</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('categories')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nom du produit -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom du produit</label>
                    <input type="text" name="name" placeholder="Nom du produit"
                        class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" rows="5" placeholder="Description du produit"
                        class="form-control @error('description') is-invalid @enderror"></textarea>
                    @error('description')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Prix -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Prix</label>
                    <input type="number" step="0.01" name="prix" placeholder="Prix du produit"
                        class="form-control @error('prix') is-invalid @enderror">
                    @error('prix')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image upload amélioré -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Image du produit</label>
                    <div class="border border-2 rounded-3 p-4 text-center position-relative bg-light"
                         style="cursor: pointer;" onclick="document.getElementById('imageInput').click();">
                        <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                        <p class="mb-0 text-muted">Glissez-déposez une image ici ou cliquez pour sélectionner</p>
                        <input type="file" name="image" id="imageInput" accept="image/*"
                            class="d-none @error('image') is-invalid @enderror"
                            onchange="previewImage(event)">
                    </div>
                    @error('image')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                    <!-- Aperçu image -->
                    <div class="mt-3 text-center">
                        <img id="imagePreview" src="#" alt="Aperçu de l'image"
                             class="img-fluid rounded shadow-sm d-none"
                             style="max-height: 200px;">
                    </div>
                </div>

                <!-- Bouton -->
                <button class="btn btn-primary w-100 fw-bold" type="submit">
                    <i class="fas fa-plus-circle me-2"></i> Ajouter le produit
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-danger w-100 fw-bold mt-3 mb-3">
    <i class="fas fa-arrow-left me-2"></i> Retour
</a>
            </form>
        </div>
    </div>
</div>

<!-- Script pour aperçu image -->
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove("d-none");
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
