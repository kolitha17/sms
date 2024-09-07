<!DOCTYPE html>
<html lang="en">
<head>
  <title>SMS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--for security configaration--}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- @include('libraries.script') --}}
    
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    
    <link href="{{ asset("vendor/fontawesome-free/css/all.min.css") }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    
    @stack('css')

</head>

<body id="page-top">
<div id="wrapper">
    {{-- @include('components.navbar') --}}

    @yield('content')

</div>

    <!-- The Modal -->
<div class="modal fade" id="messageModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p id="messageContent"></p>
                </div>

            </div>
        </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset("vendor/jquery/jquery.min.js") }}"></script>
<script src="{{ asset("vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset("vendor/jquery-easing/jquery.easing.min.js") }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset("js/sb-admin-2.min.js") }}"></script>

@stack('scripts')

</body>
</html>