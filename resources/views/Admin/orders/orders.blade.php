@extends('admin.layout.app')
@section('title')
    Orders
@endsection

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Liste des commandes</h2>

        <div class="accordion" id="ordersAccordion">
            @foreach ($orders as $order)
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading-{{ $order->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $order->id }}" aria-expanded="false"
                            aria-controls="collapse-{{ $order->id }}">
                            Commande #{{ $order->id }} -
                            <span id="order-status-{{ $order->id }}" class=" ms-2">{{ $order->statut }}</span>
                        </button>
                    </h2>
                    <div id="collapse-{{ $order->id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading-{{ $order->id }}" data-bs-parent="#ordersAccordion">
                        <div class="accordion-body">
                            <h4>Utilisateur : {{ $order->user->name }}</h4>
                            <h5>Produits :</h5>
                            <ul class="list-group mb-3">
                                @foreach ($order->products as $product)
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            {{ $product->name }}
                                            @if ($product->effective_promotion)
                                                <span class="badge bg-success ms-2">
                                                    Promo : -{{ $product->effective_promotion->reduction }}%
                                                </span>
                                            @endif
                                        </div>

                                        <div>
                                            @if ($product->effective_promotion)
                                                <del class="text-muted me-2">{{ number_format($product->price, 2) }}
                                                    Cfa</del>
                                                <strong>{{ number_format($product->price_with_promo, 2) }} Cfa</strong>
                                            @else
                                                <strong>{{ number_format($product->price, 2) }} Cfa</strong>
                                            @endif
                                        </div>

                                        <img src="{{ asset('/' . $product->image) }}"
                                            style="height:100px;width:100px;object-fit:cover" alt="">

                                        <span class="badge bg-secondary">{{ $product->pivot->quantity }} pièces</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary btn-sm change-status" data-order-id="{{ $order->id }}"
                                    data-status="commandé">Commandé</button>
                                <button class="btn btn-warning btn-sm text-white change-status"
                                    data-order-id="{{ $order->id }}" data-status="en_livraison">En livraison</button>
                                <button class="btn btn-success btn-sm change-status" data-order-id="{{ $order->id }}"
                                    data-status="livré">Livré</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.change-status').click(function() {
                var orderId = $(this).data('order-id');
                var newStatus = $(this).data('status');

                $.ajax({
                    url: '/orders/' + orderId + '/status/' + newStatus,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        const badge = $('#order-status-' + orderId);
                        badge.text(newStatus);
                        badge.removeClass().addClass('badge ms-2 ' + getBadgeClass(newStatus));
                        alert('Statut mis à jour : ' + newStatus);
                    },
                    error: function(xhr) {
                        alert('Erreur lors de la mise à jour du statut.');
                    }
                });
            });

            function getBadgeClass(status) {
                switch (status.toLowerCase()) {
                    case 'commandé':
                        return 'bg-primary';
                    case 'en_livraison':
                        return 'bg-warning text-dark';
                    case 'livré':
                        return 'bg-success';
                    case 'annulé':
                        return 'bg-danger';
                    default:
                        return 'bg-secondary';
                }
            }
        });
    </script>
@endsection
