<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title') Food App</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ asset('assets/admin/css/styles.css') }}" rel="stylesheet" />

    <!-- FontAwesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

    {{-- navbar --}}
    @include('user.layout.inc.navbar')

    <div id="layoutSidenav">
        {{-- sidebar --}}
        @include('user.layout.inc.sideBar')

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    {{-- content --}}
                    @yield('content')
                </div>
            </main>

            {{-- footer --}}
            @include('user.layout.inc.footer')
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="{{ asset('assets/admin/js/datatables-simple-demo.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom scripts -->
    <script src="{{ asset('assets/admin/js/scripts.js') }}"></script>

    <script>
        setTimeout(() => {
            $('#alert-message').fadeOut('slow');
        }, 4000);
    </script>

</body>
</html>
