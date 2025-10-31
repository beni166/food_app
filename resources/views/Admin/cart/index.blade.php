<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Toast notification -->
    <div id="toast" class="fixed top-5 right-5 hidden text-white px-4 py-3 rounded shadow-lg z-50"></div>

    <section class="flex-grow container mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold mb-6">Mon Panier</h2>

        @if (session('success'))
            <div id="toast-success" class="fixed top-5 right-5 bg-green-500 text-white px-4 py-3 rounded shadow-lg">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => document.getElementById('toast-success').remove(), 5000);
            </script>
        @endif

        @php $total = 0; @endphp

        @if (empty($panier))
            <p class="text-gray-500">Votre panier est vide.</p>
            <a href="{{ route('welcome') }}" class="inline-block mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Retour</a>
        @else
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 text-left">Produit</th>
                            <th class="py-2 px-4 text-center">Quantité</th>
                            <th class="py-2 px-4 text-center">Prix Unitaire</th>
                            <th class="py-2 px-4 text-center">Total</th>
                            <th class="py-2 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="panier-body">
                        @foreach ($panier as $id => $item)
                            @php
                                $promoReduction = $item['promotion']['reduction'] ?? 0;
                                $prixPromo = $item['prix'] * (1 - $promoReduction / 100);
                                $total += $prixPromo * $item['quantite'];
                            @endphp
                            <tr class="border-b" data-id="{{ $id }}" data-prix="{{ $prixPromo }}">
                                <td class="py-2 px-4 flex items-center gap-3">
                                    <img src="{{ asset($item['image']) }}" class="w-12 h-12 object-cover rounded" alt="{{ $item['nom'] }}">
                                    <span>{{ $item['nom'] }}</span>
                                </td>
                                <td class="py-2 px-4 text-center">
                                    <input type="number" value="{{ $item['quantite'] }}" min="1" 
                                        class="w-16 text-center border rounded qty-input">
                                </td>
                                <td class="py-2 px-4 text-center">
                                    @if ($promoReduction > 0)
                                        <span class="line-through text-gray-400">{{ number_format($item['prix'],0,',',' ') }} CFA</span><br>
                                        <span class="text-red-500 font-semibold">{{ number_format($prixPromo,0,',',' ') }} CFA</span>
                                    @else
                                        {{ number_format($item['prix'],0,',',' ') }} CFA
                                    @endif
                                </td>
                                <td class="py-2 px-4 text-center subtotal">{{ number_format($prixPromo * $item['quantite'],0,',',' ') }} CFA</td>
                                <td class="py-2 px-4 text-center flex gap-2 justify-center">
                                    <button class="update-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 disabled:opacity-50" disabled>Modifier</button>
                                    <form action="{{ route('cart.supprimer') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produit_id" value="{{ $id }}">
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center mt-6 gap-4">
                <h3 class="text-xl font-bold">Total : <span id="total">{{ number_format($total,0,',',' ') }}</span> CFA</h3>
                <form action="{{ route('commande.create') }}" method="POST" id="commande-form" class="flex gap-2">
                    @csrf
                    @foreach ($panier as $produit_id => $item)
                        <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $produit_id }}">
                        <input type="hidden" name="items[{{ $loop->index }}][quantity]" value="{{ $item['quantite'] }}">
                    @endforeach
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Commander maintenant</button>
                </form>
            </div>

            <a href="{{ route('welcome') }}" class="inline-block mt-6 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Retour</a>
        @endif
    </section>

<style>
    @keyframes highlightRow {
        0% { background-color: #d1fae5; }
        100% { background-color: white; }
    }

    .highlight {
        animation: highlightRow 1s ease forwards;
    }
</style>

<script>
    const totalEl = document.getElementById('total');
    const rows = document.querySelectorAll('#panier-body tr');
    const form = document.getElementById('commande-form');
    const toast = document.getElementById('toast');

    function showToast(message, color='green') {
        toast.innerText = message;
        toast.className = `fixed top-5 right-5 text-white px-4 py-3 rounded shadow-lg bg-${color}-500 z-50`;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3000);
    }

    function updateTotal() {
        let total = 0;
        rows.forEach((row, index) => {
            const qtyInput = row.querySelector('.qty-input');
            const qty = parseInt(qtyInput.value);
            const prix = parseFloat(row.dataset.prix);
            row.querySelector('.subtotal').innerText = (prix * qty).toLocaleString('fr-FR') + ' CFA';
            total += prix * qty;

            // Synchroniser le formulaire
            form.querySelector(`input[name="items[${index}][quantity]"]`).value = qty;
        });
        totalEl.innerText = total.toLocaleString('fr-FR');
    }

    rows.forEach(row => {
        const input = row.querySelector('.qty-input');
        const btn = row.querySelector('.update-btn');

        input.addEventListener('input', () => {
            btn.disabled = input.value <= 0;
            btn.classList.toggle('opacity-50', input.value <= 0);
            updateTotal();
        });

        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const id = row.dataset.id;
            const qty = input.value;

            fetch("{{ route('cart.modifier') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ produit_id: id, quantite: qty })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    btn.disabled = true;
                    showToast("Quantité mise à jour !");

                    // 🔹 Animation ligne mise à jour
                    row.classList.add('highlight');
                    setTimeout(() => row.classList.remove('highlight'), 1000);
                } else {
                    showToast(data.message || "Erreur lors de la mise à jour", 'red');
                }
            })
            .catch(err => {
                console.error(err);
                showToast("Une erreur est survenue ❌", 'red');
            });
        });
    });
</script>


</body>
</html>
