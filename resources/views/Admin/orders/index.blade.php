@extends('Admin.layout.app')

@section('title', 'Commandes')

@section('content')
@php
    function getBadgeClass($statut)
    {
        switch (strtolower($statut)) {
            case 'nouveau': return 'bg-primary';
            case 'en_livraison': return 'bg-warning text-dark';
            case 'livrer': return 'bg-success';
            case 'annuler': return 'bg-danger';
            default: return 'bg-secondary';
        }
    }
@endphp

<div class="col-md-10 mx-auto my-5">
    <div class="card shadow-lg border-0 rounded-4">

        {{-- Header --}}
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="mb-0"><i class="fas fa-shopping-cart me-2"></i> Liste des Commandes</h4>
        </div>

        <div class="card-body">

            {{-- Accordéon des commandes --}}
            <div class="accordion" id="ordersAccordion">
                @foreach ($orders as $order)
                    @php $totalCommande = 0; @endphp
                    <div class="accordion-item mb-3 shadow-sm border rounded-3">
                        <h2 class="accordion-header" id="heading-{{ $order->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $order->id }}" aria-expanded="false"
                                    aria-controls="collapse-{{ $order->id }}">
                                Commande #{{ $order->id }} - 
                                <span class="badge ms-2 {{ getBadgeClass($order->statut) }}" id="order-status-{{ $order->id }}">
                                    {{ ucfirst($order->statut) }}
                                </span>
                                <span class="ms-auto fw-semibold text-secondary">
                                    {{ number_format($order->products->sum(fn($p) => $p->pivot->prix_order * $p->pivot->quantity), 0, ',', ' ') }} CFA
                                </span>
                            </button>
                        </h2>

                        <div id="collapse-{{ $order->id }}" class="accordion-collapse collapse"
                             aria-labelledby="heading-{{ $order->id }}" data-bs-parent="#ordersAccordion">
                            <div class="accordion-body">

                                <h5>Utilisateur : <span class="fw-semibold">{{ $order->user->name }}</span></h5>

                                {{-- Boutons statut commande --}}
                                <div class="mb-3 d-flex gap-2 flex-wrap">
                                    @php $isDelivered = strtolower($order->statut) === 'livrer'; @endphp
                                    <button class="btn btn-sm btn-warning text-white change-order-status"
                                            data-order-id="{{ $order->id }}" data-status="en_livraison"
                                            {{ $isDelivered ? 'disabled' : '' }}>En Livraison</button>
                                    <button class="btn btn-sm btn-success change-order-status"
                                            data-order-id="{{ $order->id }}" data-status="livrer"
                                            {{ $isDelivered ? 'disabled' : '' }}>Livré</button>
                                </div>

                                {{-- Liste produits --}}
                                <h5>Produits :</h5>
                                <ul class="list-group mb-3">
                                    @foreach ($order->products as $product)
                                        @php
                                            $prixOrder = $product->pivot->prix_order;
                                            $quantite = $product->pivot->quantity;
                                            $totalCommande += $prixOrder * $quantite;
                                            $isProductDelivered = strtolower($product->pivot->statut) === 'livrer';
                                        @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                     style="width:50px;height:50px;object-fit:cover;" class="rounded">
                                                <div>
                                                    <strong>{{ $product->name }}</strong><br>
                                                    Prix : {{ number_format($prixOrder,0,',',' ') }} CFA | Qte : {{ $quantite }}
                                                </div>
                                            </div>

                                            <div class="text-end">
                                                <span class="badge {{ getBadgeClass($product->pivot->statut) }}"
                                                      id="product-status-{{ $order->id }}-{{ $product->id }}">
                                                    {{ ucfirst($product->pivot->statut) }}
                                                </span>

                                                <div class="mt-2 d-flex gap-1 flex-wrap">
                                                    @foreach(['en_livraison'=>'btn-warning text-white','livrer'=>'btn-success'] as $status=>$btnClass)
                                                        <button class="btn btn-sm {{ $btnClass }} change-product-status"
                                                                data-order-id="{{ $order->id }}"
                                                                data-product-id="{{ $product->id }}"
                                                                data-status="{{ $status }}"
                                                                {{ $isProductDelivered ? 'disabled' : '' }}>
                                                            {{ ucfirst(str_replace('_',' ',$status)) }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- Total --}}
                                <h5>Total Commande : 
                                    <span class="text-primary fw-bold">
                                        {{ number_format($totalCommande,0,',',' ') }} CFA
                                    </span>
                                </h5>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

<style>
/* Animation pour badge lors du changement */
@keyframes badgePulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

.badge-animated {
    animation: badgePulse 0.6s ease;
}
</style>

{{-- ... ton HTML des commandes reste le même ... --}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    const getBadgeClassJS = status => {
        switch(status.toLowerCase()){
            case 'nouveau': return 'bg-primary';
            case 'en_livraison': return 'bg-warning text-dark';
            case 'livrer': return 'bg-success';
            case 'annuler': return 'bg-danger';
            default: return 'bg-secondary';
        }
    };

    const animateBadge = (badge) => {
        badge.classList.add('badge-animated');
        setTimeout(() => badge.classList.remove('badge-animated'), 600);
    }

    // Changer statut commande
    document.querySelectorAll('.change-order-status').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            const newStatus = this.dataset.status;
            const badge = document.getElementById(`order-status-${orderId}`);
            if(!badge) return;

            fetch(`/admin/orders/${orderId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ statut: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    badge.textContent = newStatus;
                    badge.className = `badge ${getBadgeClassJS(newStatus)}`;
                    animateBadge(badge); // animation
                    Swal.fire('Succès','Statut de la commande mis à jour','success');
                }
            })
            .catch(err => Swal.fire('Erreur',err.message,'error'));
        });
    });

    // Changer statut produit
    document.querySelectorAll('.change-product-status').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            const productId = this.dataset.productId;
            const newStatus = this.dataset.status;
            const badge = document.getElementById(`product-status-${orderId}-${productId}`);
            if(!badge) return;

            fetch(`/admin/orders/${orderId}/products/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                },
                body: JSON.stringify({ statut: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    badge.textContent = newStatus;
                    badge.className = `badge ${getBadgeClassJS(newStatus)}`;
                    animateBadge(badge); // animation
                    Swal.fire('Succès','Statut du produit mis à jour','success');
                }
            })
            .catch(err => Swal.fire('Erreur',err.message,'error'));
        });
    });
});
</script>
@endsection
