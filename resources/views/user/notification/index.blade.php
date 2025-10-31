@extends('user.layout.app')

@section('title')
    Notifications
@endsection

@section('content')
    <div class="col-md-10 mx-auto my-5">
        <div class="card shadow-lg border-0 rounded-4">

            {{-- Header --}}
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top-4">
                <h4 class="mb-0">
                    <i class="fas fa-bell me-2" aria-label="Notifications"></i> 📢 Mes Notifications
                </h4>
                @if (!$notifications->isEmpty())
                    <form action="" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-light btn-sm">
                            <i class="fas fa-check-double me-1"></i> Tout marquer comme lu
                        </button>
                    </form>
                @endif
            </div>

            {{-- Liste --}}
            <div class="p-3">
                @if ($notifications->isEmpty())
                    <div class="alert alert-info text-center mb-0">
                        <i class="fas fa-info-circle me-2"></i> Aucune notification disponible.
                    </div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($notifications as $notification)
                            <li class="list-group-item d-flex justify-content-between align-items-center 
                            {{ is_null($notification->read_at) ? 'notification-unread' : '' }}"
                                id="notification-{{ $notification->id }}">

                                <div>
                                    <i class="fas fa-envelope{{ is_null($notification->read_at) ? '' : '-open' }} text-success me-2"
                                        aria-label="Notification"></i>
                                    <a href="{{ route('user.notifications.show', $notification->id) }}"
                                        class="text-decoration-none text-dark">
                                        {{ $notification->data['message'] }}
                                    </a>

                                    <br>
                                    <small class="text-muted">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>

                                {{-- Bouton marquer comme lu --}}
                                @if (is_null($notification->read_at))
                                    <form method="POST" action="" class="ms-2">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-success"
                                            onclick="markAsRead(event, {{ $notification->id }})">
                                            Marquer comme lu
                                        </button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Pagination --}}
            @if (method_exists($notifications, 'links'))
                <div class="card-footer bg-light d-flex justify-content-center">
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    {{-- Styles personnalisés --}}
    @push('styles')
        <style>
            .notification-unread {
                font-weight: 600;
                background-color: #f8f9fa;
                transition: background-color 0.3s ease;
            }

            .notification-unread.marked-read {
                background-color: #ffffff;
                font-weight: 400;
            }
        </style>
    @endpush

    {{-- Script pour animation visuelle --}}
    @push('scripts')
        <script>
            function markAsRead(event, id) {
                event.preventDefault();
                const form = event.target.closest('form');
                const listItem = document.getElementById('notification-' + id);

                fetch(form.action, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            listItem.classList.add('marked-read');
                            setTimeout(() => listItem.classList.remove('notification-unread'), 300);
                            form.remove(); // retire le bouton après lecture
                        }
                    });
            }
        </script>
    @endpush
@endsection
