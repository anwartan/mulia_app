@extends('layouts.layout')
@section('content')
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item "><a href="#">Product</a> </li>
                            <li class="breadcrumb-item active">Add Product</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('product.store') }}" method="POST">
                @csrf

                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            @foreach ($errors->all() as $key => $error)
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    {{ $error }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                            @if (\Session::has('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! \Session::get('status') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">General</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Product Name :</label>
                                        <div class="col-sm-10">
                                            <div class="input-group ">
                                                <input id="product_name" name="product_name" type="text"
                                                    class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Product SKU</label>
                                        <div class="col-sm-10">
                                            <input name="product_sku" type="text" id="product_sku" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputDescription" class="col-sm-2 col-form-label">Product
                                            Description</label>
                                        <div class="col-sm-10">
                                            <textarea name="product_description" id="product_description" class="form-control " rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputStatus" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-10">
                                            <select name="product_status" id="inputStatus"
                                                class="form-control custom-select">
                                                <option value="-1">-</option>
                                                @foreach ($statusEnum as $key => $statusE)
                                                    <option value="{{ $statusE }}">{{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>


                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ url('/product') }}" class="btn btn-secondary">Cancel</a>
                            <input type="submit" value="Save" class="btn btn-success float-right ml-1">
                        </div>
                    </div>
                </div>
            </form>

        </section>

    </div>
@endsection

@push('scripts')
    <script>
        $(function() {


        })
    </script>
@endpush
