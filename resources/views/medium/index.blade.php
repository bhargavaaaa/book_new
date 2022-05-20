@extends('layouts.master')
@section('page_title'){{ 'Medium - '.config("app.name") }}@endsection
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
                @if (session()->has("details_success"))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! session()->get('details_success') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        {{-- <h3 class="card-title">{{ $moduleName ?? '' }} Details</h3> --}}
                        <div class="card-tools">
                            <a href="{{ route('medium.create') }}"><button class="btn btn-primary" style="float:right;"><i class="fa fa-plus"></i> New</button></a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="datatable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Medium</th>
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
    $(document).ready(function() {
        // $.fn.dataTable.ext.errMode = 'throw';
        $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route('medium.getData') }}",
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
    });
</script>

@endsection
