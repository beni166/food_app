@extends('Admin.layout.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg rounded-4">
        <div class="card-body">
            <a href="{{ route('admin.profile.user') }}" class="btn btn-danger btn-sm mb-3">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
            <h3 class="mb-4 text-center">Mon Profil</h3>

            {{-- Message succès --}}
            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Photo de profil --}}
                <div class="d-flex align-items-center mb-4">
                    @if ($user->profile)
                        <img src="{{ asset($user->profile) }}" class="rounded-circle border border-3 border-primary shadow-sm me-3" width="100" height="100" alt="Profile">
                    @else
                        @php $initials = strtoupper(substr($user->name, 0, 2)); @endphp
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm me-3" style="width:100px;height:100px;font-size:28px;font-weight:bold;">
                            {{ $initials }}
                        </div>
                    @endif

                    <div class="flex-grow-1">
                        <input type="file" name="profile" class="form-control mb-2 @error('profile') is-invalid @enderror" accept="image/*">
                        @error('profile')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        <button class="btn btn-dark btn-sm mt-1">Changer l'image</button>
                    </div>
                </div>

                {{-- Infos utilisateur --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nom</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Téléphone</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="mb-3">Changer le mot de passe</h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                        @error('current_password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
