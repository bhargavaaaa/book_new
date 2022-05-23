@extends('layouts.master')
@section('page_title'){{ 'Student - '.config("app.name") }}@endsection
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
                        <div class="card-tools"  style="float:right;">
                            <a id="bulkDelete" class="btn btn-danger" ><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="datatable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>Sr. No.</th>
                                    <th>Invoice no</th>
                                    <th>Billing name</th>
                                    <th>Total Books</th>
                                    <th>Total Amount</th>
                                    <th>Date</th>
                                    <th>Paid or not</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
    $(document).ready(function () {
        var datatable = $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route('bills.getData') }}",
                "dataType": "json",
                "type": "POST",
            },
            order: [5, "desc"],
            columns: [{
                    data: 'checkBox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'invoice_no',
                },
                {
                    data: 'billing_name',
                },
                {
                    data: 'total_quantity',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'amount_total',
                },
                {
                    data: 'created_at',
                },
                {
                    data: 'payment_status',
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
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

        $(document).on('click', '.markpaid', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#50C878',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Mark as paid'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('bills.mark_paid') }}",
                        type: "POST",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            if(response.status == true) {
                                Swal.fire({
                                    title: 'Order has been marked as paid...',
                                    icon: 'success',
                                    confirmButtonColor: '#50C878',
                                    confirmButtonText: 'Okay'
                                });
                                datatable.ajax.reload();
                            }
                        },
                    });
                }
            });
        });

        $(document).on('click', '#bulkDelete', function(){
        let invoice = [];
        $('input.checkBox:checked').each(function(){
            invoice.push($(this).val());
        });

        Swal.fire({
            title: 'Are you sure want to Delete?',
            text: "As that can't be undone.",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
            }).then((result)=>{
            if(result.value){
                $.ajax({
                type: "POST",
                url: "{{ route('invoice.bulkDelete') }}",
                data: {
                    'invoice':invoice,
                    '_token':"{{ csrf_token() }}",
                },
                dataType: "json",
                success: function (response) {
                    if(response.status){
                    location.reload();
                    }
                }
                });
            }
            })
        });

        $(document).on('change', '#selectAll', function(){
            $('input.checkBox:checkbox').not(this).prop('checked', this.checked);
        })

    });
</script>

@endsection
