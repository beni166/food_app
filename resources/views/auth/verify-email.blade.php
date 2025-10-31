<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vérification Email | Auth Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/admin/js/bootstrap.v.5.3.2/bootstrap.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            background: rgba(255,255,255,0.95);
            border-radius: 1rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            padding: 2rem;
            max-width: 500px;
            width: 100%;
        }
        .status-message {
            background: #e6ffed;
            color: #2d7a46;
            border: 1px solid #b4f5c3;
            padding: .75rem 1rem;
            border-radius: .5rem;
            font-size: .9rem;
        }
    </style>
</head>
<body>

<div class="auth-card text-center">
    <div class="mb-4">
        <i class="fas fa-envelope-circle-check fa-2x text-primary mb-2"></i>
        <h3>Confirmez votre email</h3>
    </div>

    <p class="text-muted mb-4">
        Merci pour votre inscription ! Veuillez cliquer sur le lien que nous vous avons envoyé par email.  
        <br>Si vous n’avez pas reçu l’email, vous pouvez demander un nouvel envoi.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="status-message mb-4">
            Un nouveau lien de vérification a été envoyé à votre adresse email.
        </div>
    @endif

    <div class="d-flex justify-content-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Renvoyer</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Déconnexion</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
