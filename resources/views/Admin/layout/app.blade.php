<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')Food App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/styles.css') }}" rel="stylesheet" />
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/js/bootstrap.v.5.3.2/bootstrap.min.css') }}">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

    {{-- navbar --}}
    @include('admin.layout.inc.navbar')
    <div id="layoutSidenav">
        {{-- sidebar --}}
        @include('admin.layout.inc.sideBar')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    {{-- content --}}
                    @yield('content')
                </div>
            </main>
            <!-- Conteneur global pour les toasts -->

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/admin/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 (inclut Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-..."
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.v.5.3.2/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('assets/admin/js/datatables-simple-demo.js') }}"></script>


    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://js.pusher.com/8.4/pusher.min.js"></script>
    <script>
        // Initialisation Pusher
        var pusher = new Pusher('206ab0f95707bdd8d1b4', {
            cluster: 'eu',
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });

        // Fonction toast Bootstrap
        function showToast(title, message) {
            const toastId = 'toast-' + Date.now();
            const toastHtml = `
        <div id="${toastId}" class="toast align-items-center text-bg-primary border-0 mb-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>${title}</strong><br>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
            </div>
        </div>`;
            const container = document.querySelector('.toast-container');
            if (container) {
                container.insertAdjacentHTML('beforeend', toastHtml);
                const toastElement = document.getElementById(toastId);
                const toast = new bootstrap.Toast(toastElement, {
                    delay: 5000
                });
                toast.show();
            }
        }

        // --- Admin ---
        @if (auth()->check() && auth()->user()->is_admin)
            var adminChannel = pusher.subscribe('private-admin.notifications');
            adminChannel.bind('notification', function(data) {
                showToast('Notification Admin', data.message);
            });
        @endif

      
    </script>






    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        setTimeout(() => {
            $('#alert-message').fadeOut('slow');
        }, 4000);


        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Empêche la soumission directe

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action est irréversible !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Soumet le formulaire si confirmé
                    }
                });
            });
        });

        document.querySelectorAll('.delete-category-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Empêche la soumission directe

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action supprimera définitivement cette catégorie !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Soumet le formulaire si confirmé
                    }
                });
            });
        });
    </script>
    @yield('scripts');

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>
