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
                    <div class="card mb-5">
                        <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data" id="form">
                            @csrf
                            <div class="card-body table-responsive">
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3 col-sm-12">
                                        <label class="form-label">Book Name<span class="requride_cls">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                            value="{{ old('name') }}" />
                                        @error('name')
                                            <span class="error">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-5 mb-3 col-sm-12">
                                        <label for="standard">
                                            Standard <span class="requride_cls">*</span>
                                        </label>
                                        <select class="select2 select2bs4 form-control" style="width: 100%" id="standard" name="standard[]"
                                            multiple>
                                            @foreach ($standard as $standard)
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
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3 col-sm-12">
                                        <label for="medium">
                                            Medium <span class="requride_cls">*</span>
                                        </label>
                                        <select class="select2 select2bs4 form-control" style="width: 100%" id="medium" name="medium[]" placeholder="ok" multiple>
                                            @foreach ($medium as $medium)
                                                <option value="{{ $medium->id }}">{{ $medium->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('medium')
                                            <span class="error">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3 col-sm-12">
                                        <label class="form-label">Book Price<span
                                                class="requride_cls">*</span></label>
                                        <input type="number" class="form-control" name="price" id="price"
                                            placeholder="Book Price" value="{{ old('price') }}" />
                                        @error('price')
                                            <span class="error">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3 col-sm-12">
                                        <label class="form-label">Book Quantity<span
                                                class="requride_cls">*</span></label>
                                        <input type="number" class="form-control" name="qty" id="qty"
                                            placeholder="Book Quantity" value="{{ old('qty') }}" />
                                        @error('qty')
                                            <span class="error">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3 col-sm-12">
                                        <label class="form-label">Discount<span class="requride_cls">*</span></label>
                                        <input type="number" class="form-control" name="discount" id="discount"
                                            placeholder="Book Discount" value="{{ old('discount') }}" />
                                        @error('discount')
                                            <span class="error">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3">

                                    <div class="col-md-6 mb-3 col-sm-12">
                                        <label for="discount_type">
                                            Discount Type <span class="requride_cls">*</span>
                                        </label>
                                        <div class="radio">
                                            <label for="amount"><input type="radio" name="discount_type" id="amount"
                                                    value="0" checked>Amount</label>
                                            <label for="percentage" class="ml-2"><input type="radio" name="discount_type" id="percentage"
                                                    value="1">Percentage</label>
                                        </div>
                                        @if ($errors->has('discount_type'))
                                            <span
                                                class="requride_cls"><strong>{{ $errors->first('discount_type') }}</strong></span>
                                        @endif
                                    </div>

                                    <div class="col-md-5 mb-3 col-sm-12">
                                        <label for="discount_type">
                                            Book status <span class="requride_cls">*</span>
                                        </label>
                                        <div class="radio">
                                            <label for="in_store"><input type="radio" name="book_status" id="in_store"
                                                    value="1" checked>Available in store</label>
                                            <label for="pending" class="ml-2"><input type="radio" name="book_status" id="pending"
                                                    value="0">Yet to come</label>
                                        </div>
                                        @if ($errors->has('book_status'))
                                            <span
                                                class="requride_cls"><strong>{{ $errors->first('book_status') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <center>
                                    <button type="submit" class="btn btn-info">Submit</button>
                                    <a href=" {{ route('book.index') }}" class="btn btn-default">Cancel</a>
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
        $(document).ready(() => {
            $('#standard').select2({
                placeholder: "Select a standard",
                allowClear: true
            });
            $('#medium').select2({
                placeholder: "Select a medium",
                allowClear: true
            });
        });
    </script>
@endsection
