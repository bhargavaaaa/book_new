@extends('layouts.master')
@section('page_title')
    {{ 'Bill & Invoice - ' . config('app.name') }}
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
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $moduleName ?? '' }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg order-1 order-lg-0">
                    @if (session()->has("error"))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {!! session()->get('error') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card mb-5">
                        <form action="{{ route('invoice.mainBookSubmit') }}" method="POST" enctype="multipart/form-data"
                            id="form">
                            @csrf
                            <div class="card-body table-responsive">
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3 col-sm-12">
                                        <label class="form-label">Medium</label>
                                        <select class="form-control standard_change select2" name="medium" id="medium_select">    
                                            @foreach ($medium as $mkey => $md)
                                                <option value="{{ $md->id }}" @if($mkey == 0) selected @endif >{{ $md->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('medium')
                                            <span class="error">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3 col-sm-12">
                                        <label class="form-label">Standard</label>
                                        <select class="form-control standard_change select2" name="standard" id="standard_select">    
                                            <option value="">-- Select standard --</option>
                                            @foreach ($standards as $standard)
                                                <option value="{{ $standard->id }}">{{ $standard->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('standard')
                                            <span class="error">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div id="ajaxDataLoad">
                                </div>
                            </div>
                            <div class="card-footer">
                                <center>
                                    <button type="submit" class="btn btn-info">Submit</button>
                                    <a href=" {{ route('invoice.index') }}" class="btn btn-default">Cancel</a>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@endsection
@section('footer_script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $(document).on('change', '.standard_change', (e) => {
                e.preventDefault();
                $th = $('#standard_select');
                if($th.val()) {
                    $.ajax({
                        url: "{{ route('invoice.getBooksList') }}",
                        type: "POST",
                        data: {
                            id: $th.val(),
                            medium: $('#medium_select').val(),
                        },
                        success: function(response) {
                            if (response) {
                                $('#ajaxDataLoad').html(response);
                                $('.studentselect2').select2();
                            }
                        },
                    });
                } else {
                    $('#ajaxDataLoad').html('');
                }
            });

            $(document).on('blur', '.qunatities', function() {
                quantity = parseInt($(this).val());
                if(isNaN(quantity) || quantity <= 0) {
                    $(this).val(1);
                }
                $('.book_ids_cheker').trigger('change');
            });

            $(document).on('change', '.book_ids_cheker', function() {
                $final_total = 0;
                $final_disc_rate = 0;
                $final_rate = 0;
                $qunat_price_mult = 0;
                $('.current_row').each(function() {
                    line_price = parseFloat($(this).find('.book_price').data('value'));
                    line_quantity = parseInt($(this).find('.qunatities').val());
                    discount = 0;
                    if($.trim($(this).find('.discount_percent').data('yes')) == "yes") {
                        discount = ((line_price * line_quantity) * parseFloat($(this).find('.discount_percent').data('value')) / 100);
                    } else {
                        discount = parseFloat($(this).find('.discount_amount').data('value')) * line_quantity;
                        $(this).find('.discount_amount').text(discount.toFixed(2));
                    }
                    line_total = (line_price * line_quantity) - discount;
                    $(this).find('.total_final_amount').text(line_total.toFixed(2));
                    $(this).find('.qunat_price_mult').text((line_price * line_quantity).toFixed(2));

                    if($(this).find('.book_ids_cheker').prop('checked')) {
                        $(this).find('.qunatities').removeAttr('disabled');
                        $qunat_price_mult = $qunat_price_mult + (line_price * line_quantity);
                        $final_total = $final_total + line_total;
                        if($.trim($(this).find('.discount_percent').data('yes')) == "yes") {
                            //
                        } else {
                            $final_disc_rate = $final_disc_rate + discount;
                        }
                        $final_rate = $final_rate + line_price;
                    } else {
                        $(this).find('.qunatities').attr('disabled', true);
                    }

                }).promise().done(function(){
                    $('.set_final_rate').text($final_rate.toFixed(2));
                    $('.set_final_disc_rate').text($final_disc_rate.toFixed(2));
                    $('.set_final_total').text($final_total.toFixed(2));
                    $('.set_final_multiplied').text($qunat_price_mult.toFixed(2));
                });
            });
        });
    </script>
@endsection
