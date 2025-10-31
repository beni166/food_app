 @php
     function getBadgeClass($statut)
     {
         switch (strtolower($statut)) {
             case 'nouveau':
                 return 'bg-primary';
             case 'livrer':
                 return 'bg-success';
             case 'annuler':
                 return 'bg-danger';
             default:
                 return 'bg-secondary';
         }
     }
 @endphp
 @extends('user.layout.app')

 @section('title')
     Orders
 @endsection

 @section('content')
     <div class="col-md-10 mx-auto my-5">
         <div class="card shadow-lg border-0 rounded-4">

             {{-- Header --}}
             <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center rounded-top-4">
                 <h4 class="mb-0"><i class="fas fa-shopping-cart me-2"></i> Mes Commandes</h4>
             </div>

             <div class="card-body">

                 @if ($orders->isEmpty())
                     <div class="alert alert-info text-center mt-4">
                         Vous n'avez pas encore de commande.
                     </div>
                 @else
                     <div class="accordion" id="ordersAccordion">
                         @foreach ($orders as $order)
                             @php $totalCommande = 0; @endphp
                             <div class="accordion-item mb-3 shadow-sm border rounded-3">
                                 <h2 class="accordion-header" id="heading-{{ $order->id }}">
                                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                         data-bs-target="#collapse-{{ $order->id }}" aria-expanded="false"
                                         aria-controls="collapse-{{ $order->id }}">
                                         Commande #{{ $order->id }}
                                         <span class="badge ms-2 {{ getBadgeClass($order->statut) }}"
                                             id="order-status-{{ $order->id }}">
                                             {{ ucfirst($order->statut) }}
                                         </span>
                                         <span class="ms-auto fw-semibold text-secondary">
                                             {{ number_format($order->products->sum(fn($p) => $p->pivot->prix_order * $p->pivot->quantity), 0, ',', ' ') }}
                                             CFA
                                         </span>
                                     </button>
                                 </h2>

                                 <div id="collapse-{{ $order->id }}" class="accordion-collapse collapse"
                                     aria-labelledby="heading-{{ $order->id }}" data-bs-parent="#ordersAccordion">
                                     <div class="accordion-body">

                                         <h5>Utilisateur : <span class="fw-semibold">{{ $order->user->name }}</span></h5>

                                         {{-- Boutons statut --}}
                                         {{-- Boutons statut --}}
                                         <div class="mb-3 d-flex gap-2 flex-wrap">
                                             @php
                                                 $isDelivered = in_array(strtolower($order->statut), [
                                                     'livrer',
                                                     'en_livraison',
                                                 ]);
                                             @endphp

                                             @if (!$isDelivered)
                                                 <button class="btn btn-sm btn-danger change-order-status"
                                                     data-order-id="{{ $order->id }}" data-status="annuler">
                                                     Annuler
                                                 </button>
                                             @endif
                                         </div>


                                         {{-- Produits --}}
                                         <h5>Produits :</h5>
                                         <ul class="list-group mb-3">
                                             @foreach ($order->products as $product)
                                                 @php
                                                     $prixOrder = $product->pivot->prix_order;
                                                     $quantite = $product->pivot->quantity;
                                                     $totalCommande += $prixOrder * $quantite;
                                                 @endphp
                                                 <li
                                                     class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                     <div class="d-flex align-items-center gap-2">
                                                         <img src="{{ asset($product->image) }}"
                                                             alt="{{ $product->name }}"
                                                             style="width:50px;height:50px;object-fit:cover;"
                                                             class="rounded">
                                                         <div>
                                                             <strong>{{ $product->name }}</strong><br>
                                                             Prix : {{ number_format($prixOrder, 0, ',', ' ') }} CFA | Qte
                                                             :
                                                             {{ $quantite }}
                                                         </div>
                                                     </div>
                                                     <span class="badge {{ getBadgeClass($product->pivot->statut) }}">
                                                         {{ ucfirst($product->pivot->statut) }}
                                                     </span>
                                                 </li>
                                             @endforeach
                                         </ul>

                                         {{-- Total --}}
                                         <h5>Total Commande :
                                             <span class="text-primary fw-bold">
                                                 {{ number_format($totalCommande, 0, ',', ' ') }} CFA
                                             </span>
                                         </h5>

                                     </div>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 @endif

             </div>
         </div>
     </div>


     <script>
         const ctx = document.getElementById("myBarChart");
         if (ctx) {
             new Chart(ctx, {
                 // configuration du graphique
             });
             if (ctx) {
                 new Chart(ctx, {
                     // ⚠️ Mets ici ta configuration réelle du graphique
                     type: 'bar',
                     data: {
                         labels: ['Jan', 'Feb', 'Mar'],
                         datasets: [{
                             label: 'Exemple',
                             data: [10, 20, 30],
                             backgroundColor: '#4e73df'
                         }]
                     },
                     options: {
                         responsive: true,
                         plugins: {
                             legend: {
                                 display: true
                             }
                         }
                     }
                 });
             }
         }

         function getBadgeClassJS(status) {
             switch (status.toLowerCase()) {
                 case 'en_attente':
                     return 'bg-warning';
                 case 'en_livraison':
                     return 'bg-primary';
                 case 'livrer':
                     return 'bg-success';
                 case 'annuler':
                     return 'bg-danger';
                 default:
                     return 'bg-secondary';
             }
         }


         document.addEventListener('DOMContentLoaded', function() {
             // Changer le statut de la commande
             document.querySelectorAll('.change-order-status').forEach(function(button) {
                 button.addEventListener('click', function() {
                     const orderId = this.dataset.orderId;
                     const newStatus = this.dataset.status;
                     const badge = document.getElementById(`order-status-${orderId}`);

                     // Vérification si le badge est trouvé
                     console.log('Badge trouvé:', badge);
                     if (badge.textContent.trim().toLowerCase() === 'livrer') {
                         Swal.fire('Commande déjà livrée', 'Impossible de changer son statut.',
                             'info');
                         return;
                     }

                     console.log(`Order ID: ${orderId}`);
                     console.log(`New Status: ${newStatus}`);
                     console.log(`Current Badge: ${badge.textContent.trim()}`);

                     // Envoi de la requête fetch
                     fetch(`/admin/orders/${orderId}`, {
                             method: 'PUT',
                             headers: {
                                 'Content-Type': 'application/json',
                                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                             },
                             body: JSON.stringify({
                                 statut: newStatus
                             })
                         })
                         .then(response => {
                             console.log('Réponse brute:', response);
                             if (response.ok) {
                                 return response.json();
                             } else {
                                 return Promise.reject(
                                     `Erreur dans la requête, code HTTP: ${response.status}`);
                             }
                         })
                         .then(data => {
                             console.log('Réponse du serveur:', data);
                             if (data.success) {
                                 // Mise à jour du badge après la réponse réussie
                                 if (badge) {
                                     badge.textContent = newStatus;
                                     badge.className =
                                         `badge ms-2 ${getBadgeClassJS(newStatus)}`;
                                     console.log(badge.className);
                                     console.log(`${getBadgeClassJS(newStatus)}`);


                                 } else {
                                     console.error('Le badge n\'a pas été trouvé');
                                 }

                                 // Affichage du message SweetAlert après la mise à jour
                                 Swal.fire('Succès', 'Statut de la commande mis à jour.',
                                     'success');
                             }
                         })
                         .catch(error => {
                             console.error('Erreur:', error);
                             Swal.fire('Erreur', error, 'error');
                         });
                 });
             });


         });
     </script>
 @endsection
