<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mot de passe oublié | Auth Portal</title>
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
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            max-width: 450px;
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
            <i class="fas fa-unlock-alt fa-2x text-primary mb-2"></i>
            <h3 class="mb-1">Mot de passe oublié</h3>
        </div>

        <!-- Message d’information -->
        <p class="text-muted mb-4">
            Vous avez oublié votre mot de passe ? Pas de problème.<br>
            Entrez simplement votre adresse email et nous vous enverrons un lien pour en définir un nouveau.
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="status-message mb-4">
                {{ session('status') }}
            </div>
        @endif

        <!-- Formulaire -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="form-control @error('email') is-invalid @enderror" placeholder="Adresse email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Envoyer le lien de réinitialisation
            </button>
        </form>
    </div>
    <script src="{{ asset('assets/admin/js/bootstrap.v.5.3.2/bootstrap.bundle.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
