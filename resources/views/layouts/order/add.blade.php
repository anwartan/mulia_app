@extends('layouts.layout')
@section('content')
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Order</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item "><a href="#">Order</a> </li>
                            <li class="breadcrumb-item active">Order</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('order.store') }}" method="POST">
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
                        <div class="col-12">
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
                                        <label class="col-sm-2 col-form-label">Order No</label>
                                        <div class="col-sm-10">
                                            <div class="input-group ">
                                                <input id="order_no" name="order_no" type="text" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Date</label>
                                        <div class="col-sm-10">
                                            <div class="input-group ">
                                                <input id="transaction_date" name="transaction_date" type="date"
                                                    class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">No. Resi</label>
                                        <div class="col-sm-10">
                                            <input name="receipt_no" type="text" id="inputName" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                                        <div class="col-sm-10">
                                            <textarea name="description" id="inputDescription" class="form-control " rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputStatus" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-10">
                                            <select name="status" id="inputStatus" class="form-control custom-select">
                                                <option value="-1">-</option>
                                                @foreach ($statusEnum as $key => $statusE)
                                                    <option value="{{ $statusE }}">{{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="inputProjectLeader" class="col-sm-2 col-form-label">Harga</label>
                                        <div class="col-sm-10">
                                            <input name="price" type="number" id="harga" class="form-control">
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{ url('/order') }}" class="btn btn-secondary">Cancel</a>
                                            <input type="submit" value="Save" class="btn btn-success float-right ml-1">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Item</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table id="orderItem" class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">
                                                    <button type="button" onclick="addPurchaseItem()"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-plus">
                                                        </i>
                                                    </button>
                                                </th>
                                                <th>Product Stock Id</th>
                                                <th>Product Id</th>
                                                <th>Product Name</th>
                                                <th>Remaining Quantity</th>
                                                <th>Quantity</th>
                                                <th>Product Price</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            {{-- @foreach ($purchase->items as $item)
                                                <tr>
                                                    <td></td>
                                                    <td>{{ $item->product_id }}</td>
                                                    <td>{{ $item->product->product_name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ $item->price }}</td>
                                                </tr>
                                            @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </section>


    </div>
@endsection

@push('scripts')
    <script>
        let table;
        let itemPurchaseSelected;
        $(function() {
            // $('#reservationdate').datetimepicker({
            //     format: 'L'
            // });
            $('#transaction_date').val(moment().format('yyyy-MM-DD'));
            table = $('#orderItem').DataTable({
                paging: false,
                info: false,
                searching: false,
                ordering: false,
                responsive: true,
                autoWidth: false,
                columnDefs: [
                    //     {
                    //     orderable: false,
                    //     className: 'select-checkbox',
                    //     targets: 0
                    // },
                    {
                        targets: [1, 2],
                        visible: false
                    }
                ],
                // select: {
                //     style: 'os',
                //     selector: 'td:first-child'
                // },
                columns: [{
                        data: null,
                        defaultContent: '',
                        render: function(data, type, full, meta) {

                            return ` <button type="button" onclick="deleteItem(${meta.row})" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-minus">
                                                        </i>
                                                    </button>`
                        }
                    },
                    {
                        data: 'product_stock_id',
                        name: 'product_stock_id',

                    },
                    {
                        data: 'product_id',
                        name: 'product_id',

                    },
                    {
                        data: 'product_name',
                        name: 'product_name',
                        render: function(data, type, full, meta) {
                            return `<input type="button" onclick="applyProduct(${meta.row})" class="form-control" value="${data}">`
                        }
                    },
                    {
                        data: 'remaining_quantity',
                        name: 'remaining_quantity',
                        render: function(data, type) {
                            return `<input type="number" readonly class="form-control" value="${data}">`
                        }
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        render: function(data, type) {
                            return `<input type="number" class="form-control" value="${data}">`
                        }
                    },
                    {
                        data: 'product_price',
                        name: 'product_price',
                        render: function(data, type) {
                            return `<input type="number" readonly class="form-control" value="${data}">`
                        }
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: function(data, type) {
                            return `<input type="number" class="form-control" value="${data}">`
                        }
                    },

                ]
            })

        })

        document.addEventListener('stockDatatable', (e) => {
            if (e.detail) {
                console.log(e.detail)
                table.cell(itemPurchaseSelected, 1).data(e.detail.id).invalidate();
                table.cell(itemPurchaseSelected, 2).data(e.detail.product.id).invalidate();
                table.cell(itemPurchaseSelected, 3).data(e.detail.product.product_name).invalidate();
                table.cell(itemPurchaseSelected, 4).data(e.detail.quantity).invalidate();
                table.cell(itemPurchaseSelected, 6).data(e.detail.price).invalidate();

            }
        });
        document.addEventListener('productDatatable', (e) => {
            if (e.detail) {

                table.cell(itemPurchaseSelected, 1).data(e.detail.id).invalidate();
                table.cell(itemPurchaseSelected, 2).data(e.detail.product_name).invalidate();

            }
        });

        function addPurchaseItem() {
            table.row.add({
                product_stock_id: '',
                product_id: '',
                product_name: '',
                remaining_quantity: 0,
                quantity: 0,
                product_price: 0,
                price: 0,

            }).draw(false);
        }

        function deleteItem(index) {
            table.rows(index)
                .remove()
                .draw()
        }

        function applyProduct(index) {
            itemPurchaseSelected = index;
            showProductStock()
        }
    </script>
@endpush
