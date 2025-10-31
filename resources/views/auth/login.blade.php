<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portail Auth | Accès Sécurisé</title>
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
            margin: 0;
        }
        .auth-container {
            background: rgba(255,255,255,0.95);
            border-radius: 1rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            max-width: 1000px;
            width: 100%;
        }
        .auth-illustration {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2rem;
        }
        .auth-illustration img {
            max-width: 80%;
        }
        .auth-card {
            padding: 2rem;
        }
        .toggle-password { cursor: pointer; }
    </style>
</head>
<body>

    <div class="auth-container row">
        <!-- Illustration -->
        <div class="col-md-6 auth-illustration d-none d-md-flex flex-column align-items-center justify-content-center text-center">
            <h2 class="mb-3">Bienvenue !</h2>
            <p class="mb-4">Accédez à toutes vos fonctionnalités en toute sécurité</p>
            <img src="https://illustrations.popsy.co/amber/secure-login.svg" alt="Connexion Sécurisée">
            <small class="mt-4 opacity-75">
                En continuant, vous acceptez nos
                <a href="#" class="text-white text-decoration-underline">Conditions</a>
                et notre
                <a href="#" class="text-white text-decoration-underline">Politique de confidentialité</a>.
            </small>
        </div>

        <!-- Auth Card -->
        <div class="col-md-6 d-flex align-items-center">
            <div class="auth-card w-100">

                <!-- Toggle Login/Register -->
                <div class="text-center mb-4">
                    <i class="fas fa-lock fa-2x text-primary mb-2"></i>
                    <h3 class="mb-1" id="form-title">Connectez-vous à votre compte</h3>
                    <p><a href="#" id="toggle-form" class="text-primary">Créer un nouveau compte</a></p>
                </div>

                <!-- Messages globaux -->
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Form Login -->
                <form id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Adresse e-mail</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required placeholder="vous@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="••••••••">
                            <span class="input-group-text toggle-password"><i class="fas fa-eye-slash"></i></span>
                        </div>
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        <div class="text-end mt-1">
                            <a href="{{ route('password.request') }}" class="text-decoration-none">Mot de passe oublié ?</a>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember-me">
                        <label class="form-check-label" for="remember-me">Se souvenir de moi</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>

                <!-- Form Register -->
                <form id="register-form" method="POST" action="{{ route('register') }}" class="d-none mt-3">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nom complet" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Adresse e-mail" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="number" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="Téléphone" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mot de passe" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmer le mot de passe" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Toggle Connexion / Inscription
        const toggleFormBtn = document.getElementById('toggle-form');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const formTitle = document.getElementById('form-title');

        toggleFormBtn.addEventListener('click', (e) => {
            e.preventDefault();
            loginForm.classList.toggle('d-none');
            registerForm.classList.toggle('d-none');

            if (loginForm.classList.contains('d-none')) {
                formTitle.textContent = 'Créer un nouveau compte';
                toggleFormBtn.textContent = 'Se connecter';
            } else {
                formTitle.textContent = 'Connectez-vous à votre compte';
                toggleFormBtn.textContent = 'Créer un nouveau compte';
            }
        });

        // Toggle visibilité mot de passe
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', () => {
                const input = icon.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.innerHTML = '<i class="fas fa-eye"></i>';
                } else {
                    input.type = 'password';
                    icon.innerHTML = '<i class="fas fa-eye-slash"></i>';
                }
            });
        });
    </script>
    <script src="{{ asset('assets/admin/js/bootstrap.v.5.3.2/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
