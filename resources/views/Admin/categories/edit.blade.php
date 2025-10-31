@extends('Admin.layout.app')
@section('title')
    Créer catégories
@endsection

@section('content')
    <div class="col-md-8 mx-auto my-5">
        <div class="card shadow p-4">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="name" placeholder="nom" id=""
                        class="form-control @error('name')
                    is-invalid
                @enderror">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                 <a href="{{ url()->previous() }}" class="btn btn-danger me-2">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
                <button class="btn btn-primary float-end" type="submit">Ajouter</button>
            </form>
        </div>
    </div>
@endsection
