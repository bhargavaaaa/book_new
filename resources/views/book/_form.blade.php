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
                    <div class="card-header">
                        <h3 class="card-title">{{ $moduleName }} Edit</h3>
                        <div class="card-tools">
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <form action="{{ route('book.update', encrypt($book->id)) }}" method="POST" enctype="multipart/form-data" id="form">
                            @csrf()
                            <div class="row g-3">
                                <div class="col-md-6 mb-3 col-sm-12">
                                    <label class="form-label">Book Name<span class="requride_cls">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                        value="{{ old('name', $book->name) }}" />
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
                                    <select class="select2 select2bs4 form-control" id="standard" name="standard[]" multiple>
                                        <option value="">Select</option>
                                        @foreach ($standards as $standard)
                                            <option value="{{ $standard->id }}" {{ in_array($standard->id,$standard_id) ? 'selected' : '' }}>{{ $standard->name }}</option>
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
                                    <label class="form-label">Book Price<span class="requride_cls">*</span></label>
                                    <input type="number" class="form-control" name="price" id="price" placeholder="Book Price"
                                        value="{{ old('price', $book->price) }}" />
                                    @error('price')
                                        <span class="error">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3 col-sm-12">
                                    <label class="form-label">Book Quantity<span class="requride_cls">*</span></label>
                                    <input type="number" class="form-control" name="qty" id="qty" placeholder="Book Quantity"
                                        value="{{ old('qty', $book->qty) }}" />
                                    @error('qty')
                                        <span class="error">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6 mb-3 col-sm-12">
                                    <label class="form-label">Discount<span class="requride_cls">*</span></label>
                                    <input type="number" class="form-control" name="discount" id="discount" placeholder="Book Discount"
                                        value="{{ old('discount', $book->discount) }}" />
                                    @error('discount')
                                        <span class="error">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-5 mb-3 col-sm-12">
                                    <label for="discount_type">
                                        Discount Type <span class="requride_cls">*</span>
                                    </label>
                                    <div class="radio">
                                        <label for="amount"><input type="radio" name="discount_type" id="amount" value="0" {{ ($book->discount_type == 0) ? 'checked' : '' }}>Amount</label>
                                        <label for="percentage"><input type="radio" name="discount_type" id="percentage" value="1" {{ ($book->discount_type == 1) ? 'checked' : '' }}>Percentage</label>
                                    </div>
                                    @if ($errors->has('discount_type'))
                                        <span class="requride_cls"><strong>{{ $errors->first('discount_type') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <center>
                                    <button type="submit" class="btn btn-info">Submit</button>
                                    <a href=" {{ route('book.index') }}" class="btn btn-default">Cancel</a>
                                </center>
                            </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
</section>
@endsection
@section('footer_script')
<script>

</script>

@endsection
