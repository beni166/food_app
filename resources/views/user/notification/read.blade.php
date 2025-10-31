@extends('user.layout.app')

@section('title')
    Lecture de la notification
@endsection

@section('content')
    <div class="col-md-8 mx-auto my-5">
        <div class="card shadow-lg border-0 rounded-4">

            {{-- Header --}}
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top-4">
                <h4 class="mb-0">
                    <i class="fas fa-bell me-2" aria-label="Notification"></i> 📢 Détails de la notification
                </h4>
            </div>

            {{-- Contenu --}}
            <div class="card-body">
                <div class="mb-3">
                    <span class="badge bg-success">Lu</span>
                    <small class="text-muted float-end">
                        {{ $notification->created_at->diffForHumans() }}
                    </small>
                </div>

                <h5 class="card-title mt-2">
                    {{ $notification->data['message'] ?? 'Aucun message disponible' }}
                </h5>

                @if (!empty($notification->data['url']))
                    <a href="{{ $notification->data['url'] }}" class="btn btn-success mt-3">
                        Voir la commande
                    </a>
                @endif
                <button type="button" class="btn btn-danger mt-3 ms-2" onclick="window.history.back();">
                    Retour
                </button>

            </div>
        </div>
    </div>
@endsection
