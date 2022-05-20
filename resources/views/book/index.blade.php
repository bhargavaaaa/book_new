@extends('layouts.master')
@section('page_title')
    {{ 'Student - ' . config('app.name') }}
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $moduleName ?? '' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $moduleName ?? '' }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Error!</h4>
                            @foreach ($errors->all() as $error)
                                {{ $error }} <br>
                            @endforeach
                        </div>
                    @endif
                    @if (session()->has('details_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! session()->get('details_success') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <form action="{{ route('book.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Import Books Data</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="file" name="file" class="e">
                                                <br>
                                                @error('file')
                                                    <div>{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            {{-- <h3 class="card-title">{{ $moduleName ?? '' }} Details</h3> --}}
                            <div class="card-tools" style="float:right;">
                                <a href="{{ route('book.create') }}"><button class="btn btn-primary"><i
                                            class="fa fa-plus"></i> New</button></a>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#exampleModal">Import Books Data</button>
                                <a class="btn btn-warning" href="{{ route('book.export') }}">Export Books Data</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="datatable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Book Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Available</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/. container-fluid -->
            </div>
        </div>
    </section>
@endsection
@section('footer_script')
    <script>
        @error('file')
            $('#exampleModal').modal('show');
        @enderror
        // $.fn.dataTable.ext.errMode = 'throw';
        $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route('book.getData') }}",
                "dataType": "json",
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                },
                {
                    data: 'price',
                },
                {
                    data: 'qty',
                },
                {
                    data: 'book_status',
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var linkURL = $(this).attr("href");
            console.log(linkURL);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    window.location.href = linkURL;
                }
            });
        });

        //  $(document).on('click', '#activate', function(e) {
        //     e.preventDefault();
        //     var linkURL = $(this).attr("href");
        //     console.log(linkURL);
        //     Swal.fire({
        //         title: 'Are you sure want to Activate?',
        //         text: "As that can be undone by doing reverse.",
        //         icon: 'success',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes'
        //     }).then((result) => {
        //         if (result.value) {
        //             window.location.href = linkURL;
        //         }
        //     });
        // });
    </script>
@endsection
