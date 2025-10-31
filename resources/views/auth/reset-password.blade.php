<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réinitialiser mot de passe | Auth Portal</title>
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
            max-width: 450px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="auth-card text-center">
    <div class="mb-4">
        <i class="fas fa-key fa-2x text-primary mb-2"></i>
        <h3>Réinitialiser le mot de passe</h3>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   placeholder="Adresse email" value="{{ old('email', $request->email) }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Nouveau mot de passe" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control"
                   placeholder="Confirmer le mot de passe" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Réinitialiser</button>
    </form>
</div>
    <script src="{{ asset('assets/admin/js/bootstrap.v.5.3.2/bootstrap.bundle.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
