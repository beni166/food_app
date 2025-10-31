@extends('Admin.layout.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg rounded-4">
        <div class="card-body">
            <h3 class="mb-4 text-center">Mon Profil</h3>

            {{-- Message succès --}}
            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            {{-- Photo de profil --}}
            <div class="d-flex justify-content-center mb-4">
                @if ($user->profile)
                    <img src="{{ asset($user->profile) }}" class="rounded-circle border border-3 border-primary shadow-sm" width="100" height="100" alt="Profile">
                @else
                    @php $initials = strtoupper(substr($user->name, 0, 2)); @endphp
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm"
                         style="width:100px;height:100px;font-size:28px;font-weight:bold;">
                        {{ $initials }}
                    </div>
                @endif
            </div>

            {{-- Infos utilisateur --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nom</label>
                    <input type="text" class="form-control bg-light" value="{{ $user->name }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control bg-light" value="{{ $user->email }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Téléphone</label>
                    <input type="text" class="form-control bg-light" value="{{ $user->phone }}" disabled>
                </div>
                <div class="col-12 text-center mt-3">
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary btn-lg px-5 shadow-sm">Modifier</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
