@extends('layouts.master')
@section('page_title')
    {{ 'Medium - ' . config('app.name') }}
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
                        <form action="{{ route('medium.update', encrypt($medium->id)) }}" method="POST"
                            enctype="multipart/form-data" id="form">
                            @csrf
                            <div class="card-body table-responsive">
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3 col-sm-12">
                                        <label class="form-label">Medium <span class="requride_cls">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                            value="{{ old('name', $medium->name) }}" />
                                        @error('name')
                                            <span class="error">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <center>
                                    <button type="submit" class="btn btn-info">Submit</button>
                                    <a href=" {{ route('medium.index') }}" class="btn btn-default">Cancel</a>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@endsection
@section('footer_script')
    <script></script>
@endsection
