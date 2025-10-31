@extends('Admin.layout.app')
@section('title', 'Créer catégorie')

@section('content')
<div class="col-md-8 mx-auto my-5">
    <div class="card shadow p-4">
        <h4 class="mb-4">Ajouter une catégorie</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <input type="text" name="name" placeholder="Nom de la catégorie" 
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Bouton Retour --}}
            <a href="{{ url()->previous() }}" class="btn btn-danger me-2">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>

            {{-- Bouton Ajouter --}}
            <button class="btn btn-primary" type="submit">Ajouter</button>
        </form>
    </div>
</div>
@endsection
