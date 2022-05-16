@extends('layouts.master')
@section('page_title'){{ 'Standard - '.config("app.name") }}@endsection
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
                        <h3 class="card-title">{{ $moduleName }} Create</h3>
                        <div class="card-tools">
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <form action="{{ route('standard.store') }}" method="POST" enctype="multipart/form-data" id="form">
                            @csrf()
                            <div class="row g-3">
                                <div class="col-md-6 mb-3 col-sm-12">
                                    <label class="form-label">Standard <span class="requride_cls">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                        value="{{ old('name') }}" />
                                    @error('name')
                                        <span class="error">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-5 mb-3 col-sm-12">
                                    <label for="status">
                                        Status <span class="requride_cls">*</span>
                                    </label>
                                    <div class="radio">
                                        <label for="active"><input type="radio" name="is_active" id="active" value="1" checked>Active</label>
                                        <label for="inactive"><input type="radio" name="is_active" id="inactive" value="0">In Active</label>
                                    </div>
                                    @if ($errors->has('is_active'))
                                        <span class="requride_cls"><strong>{{ $errors->first('is_active') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <center>
                                    <button type="submit" class="btn btn-info">Submit</button>
                                    <a href=" {{ route('standard.index') }}" class="btn btn-default">Cancel</a>
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
