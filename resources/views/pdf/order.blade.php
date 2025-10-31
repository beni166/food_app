<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture de commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 14px;
        }

        .invoice-box {
            max-width: 900px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            border-radius: 10px;
            background: #fff;
        }

        .invoice-header {
            background: #0d6efd;
            color: #fff;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }

        .invoice-header h1 {
            margin: 0;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .no-print {
            display: none;
        }

        .border-top-dashed {
            border-top: 2px dashed #ddd;
        }
    </style>
</head>

<body>

    <div class="invoice-box">
        <!-- Header -->
        <div class="invoice-header d-flex justify-content-between align-items-center mb-4">
            <h1>FACTURE</h1>
        </div>

        <!-- Company & Client Info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>De :</h5>
                <p>
                    <strong>BEN SHOP</strong><br>
                    Lome <br>
                    Tel: +228 98 98 98 22<br>
                    Email: Benois@gmail.com
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>Facturé à :</h5>
                <p>
                    <strong>{{ $user->name }}</strong><br>
                    {{ $user->email }}<br>
                    {{ $user->phone ?? '' }}<br>
                </p>
                <p><strong>Date :</strong> {{ $order->order_date }}</p>
                <p><strong>N° Facture :</strong> FAC-{{ $order->id }}</p>
                <p><strong>Échéance :</strong>
                    {{ \Carbon\Carbon::parse($order->order_date)->addDays(30)->format('Y-m-d') }}</p>
            </div>
        </div>


        <!-- Order Items Table -->
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Description</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-end">Prix Unitaire</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($order->products as $item)
                        @php
                            $qty = $item->pivot->quantity;
                            $price =
                                $item->promotion && $item->promotion->isActive()
                                    ? intval($item->prix) * (1 - $item->promotion->reduction / 100)
                                    : intval($item->prix);
                            $subtotal = $price * $qty;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $item->name }}</strong><br>
                                @if ($item->description)
                                    <small>{{ $item->description }}</small>
                                @endif
                            </td>
                            <td class="text-center">{{ $qty }}</td>
                            <td class="text-end">{{ number_format($price, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Sous-total :</th>
                        <th class="text-end">{{ number_format($total, 0, ',', ' ') }} FCFA</th>
                    </tr>
                    {{-- TVA désactivée
            <tr>
                <th colspan="3" class="text-end">TVA :</th>
                <th class="text-end">0 FCFA</th>
            </tr>
            --}}
                    <tr>
                        <th colspan="3" class="text-end">Total à payer :</th>
                        <th class="text-end"><strong>{{ number_format($total, 0, ',', ' ') }} FCFA</strong></th>
                    </tr>
                </tfoot>
            </table>

        </div>

        <!-- Invoice Summary -->
        <div class="row justify-content-end mb-4">
            <div class="col-md-4">
                <table class="table table-borderless">
                    <tr>
                        <th class="text-end">Total :</th>
                        <td class="text-end"><strong>{{ number_format($total, 0, ',', ' ') }} FCFA</strong></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Footer / Payment Terms -->
        <div class="mb-4">
            <p class="small text-muted">
                Merci pour votre confiance. Paiement attendu sous 30 jours.<br>
                En cas de retard de paiement, des pénalités de 3 fois le taux d'intérêt légal seront appliquées.
            </p>
        </div>

        <!-- Signatures -->
        <div class="row mt-5">
            <div class="col-md-6 text-center">
                <p>Signature du client</p>
                <div class="border-top-dashed py-4"></div>
                <p>Date :</p>
            </div>
            <div class="col-md-6 text-center">
                <p>Signature du fournisseur</p>
                <div class="border-top-dashed py-4"></div>
                <p>Date :</p>
            </div>
        </div>
    </div>

</body>

</html>
