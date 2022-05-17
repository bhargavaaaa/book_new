<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Grocery management simple web app">
    <meta name="author" content="Bhargav Chaniyara">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('public/admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('public/admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/admin/css/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="{{asset('public/admin/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/select2/select2.min.css') }}"/>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('common.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('common.header')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('common.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary logout_press_a" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('public/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{ asset('public/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{asset('public/admin/js/sb-admin-2.min.js')}}"></script>
    <script src="{{ asset('public/admin/js/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click', '.logout_press_a', function() {
                $(this).html('<i class="fa fa-refresh fa-spin fa-fw"></i>');
            });
        });
    </script>
    @yield('footer_script')
</body>

</html>
