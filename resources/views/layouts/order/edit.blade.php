@extends('layouts.layout')
@section('content')
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Order</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item "><a href="#">Order</a> </li>
                            <li class="breadcrumb-item active">Edit Order </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('order.update', $order->id) }}" method="POST">
                @csrf
                @method("put")
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
                                        <label class="col-sm-2 col-form-label">Date:</label>
                                        <div class="col-sm-10">
                                            <div class="input-group ">
                                                <input name="transaction_date" type="date" class="form-control"
                                                    value="{{ $order->transaction_date }}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">No. Resi</label>
                                        <div class="col-sm-10">
                                            <input name="receipt_no" type="text" id="inputName" class="form-control"
                                                value="{{ $order->receipt_no }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                                        <div class="col-sm-10">
                                            <textarea name="description" id="inputDescription" class="form-control "
                                                rows="4">{{ $order->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputStatus" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-10">
                                            <select name="status" id="inputStatus" class="form-control custom-select">
                                                <option value="-1">-</option>
                                                @foreach ($statusEnum as $key => $statusE)
                                                    <option {{ $statusE == $order->status ? 'selected' : '' }}
                                                        value="{{ $statusE }}">
                                                        {{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="inputProjectLeader" class="col-sm-2 col-form-label">Harga</label>
                                        <div class="col-sm-10">
                                            <input name="price" type="number" id="harga" class="form-control"
                                                value="{{ $order->price }}">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <div class="form-check">
                                                <input type="checkbox" {{ $order->cash_out == 1 ? 'checked' : '' }}
                                                    name="cash_out" class="form-check-input" id="cashOut">
                                                <label class="form-check-label" for="cashOut">Cash Out</label>
                                            </div>
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
                            <a href="{{ url('/order') }}" class="btn btn-secondary">Cancel</a>
                            <input type="submit" value="Save" class="btn btn-success float-right ml-1">
                        </div>
                    </div>
                </div>
            </form>

        </section>
        {{-- <div wire:ignore.self class="modal fade show" id="modal-default" aria-modal="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Product</h4>
                        <button type="button" class="close" wire:click="resetAndClear">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="save" class="form-horizontal">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="productName" class="col-sm-2 col-form-label">Product Name</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                        class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}"
                                        id="productName" placeholder="Enter Product Name" wire:model="product_name">

                                    @error('product_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="productDescription" class="col-sm-2 col-form-label">Product Description</label>
                                <div class="col-sm-10">
                                    <textarea id="productDescription" class="form-control {{ $errors->has('product_description') ? 'is-invalid' : '' }}"
                                        rows="3" placeholder="Enter ..." wire:model="product_description"></textarea>
                                    @error('product_description')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="productSku" class="col-sm-2 col-form-label">Product SKU</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                        class="form-control {{ $errors->has('product_sku') ? 'is-invalid' : '' }}"
                                        id="productSku" placeholder="Enter Product SKU" wire:model="product_sku">
                                    @error('product_sku')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="productStatus" class="col-sm-2 col-form-label">Product Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" wire:model="product_status" id="productStatus">
                                        <option>option 1</option>
                                        <option>option 2</option>
                                        <option>option 3</option>
                                        <option>option 4</option>
                                        <option>option 5</option>
                                    </select>
                                    @error('product_status')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>




                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" wire:click="resetAndClear">Close</button>
                            <div>
                                <button type="button" class="btn btn-default" wire:click="resetInput">Clear</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div> --}}

    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

        })
    </script>
@endpush
