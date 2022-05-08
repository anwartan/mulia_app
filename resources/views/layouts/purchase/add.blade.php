@extends('layouts.layout')
@section('content')
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> Order Purchase</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item "><a href="#">Purchase</a> </li>
                            <li class="breadcrumb-item active"> Order Purchase</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">


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
                    <div class="col-12 col-md-6">
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
                                    <label class="col-sm-2 col-form-label">PO Number </label>
                                    <div class="col-sm-10">
                                        <div class="input-group ">
                                            <input id="po_no" name="po_no" type="text" class="form-control"
                                                value="{{ $purchase->po_no }}" disabled>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Purchase Date</label>
                                    <div class="col-sm-10">
                                        <input id="purchase_date" name="purchase_date" type="date"
                                            value="{{ $purchase->purchase_date }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea name="description" id="description" class="form-control " rows="4">{{ $purchase->description }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select name="status" id="status" disabled class="form-control custom-select">
                                            <option value="-1">-</option>
                                            @foreach ($statusEnum as $key => $statusE)
                                                <option {{ $statusE == $purchase->status ? 'selected' : '' }}
                                                    value="{{ $statusE }}">{{ $key }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div>
                                    <a href="{{ url('/purchase') }}" class="btn btn-secondary">Cancel</a>
                                    @if ($purchase->status_name == 'PENDING')
                                        <input type="button" value="Complete" onclick="submit('COMPLETE')"
                                            class="btn btn-success float-right ml-1">
                                        <input type="button" value="Cancel" onclick="submit('CANCEL')"
                                            class="btn btn-danger float-right ml-1">
                                    @endif
                                    <input type="button" value="Save" onclick="saveOrder()"
                                        class="btn btn-primary float-right ml-1">

                                </div>
                                {{-- <div class="toolbar d-flex flex-start mb-2">
                                        <button type="button" onclick="onAddItem()" class="btn btn-primary mr-1">Add
                                            Item</button>
                                        <button type="button" onclick="onUpdateItem()" class="btn btn-primary mr-1">Update
                                            Item</button>
                                        <button type="button" onclick="onDeleteItem()" class="btn btn-primary">Delete
                                            Item</button>
                                    </div> --}}
                                {{-- <table id="purchaseItem"
                                        class="table table-bordered table-hover dataTable dtr-inline collapsed">
                                        <thead>
                                            <tr>
                                                <th></th>

                                                <th>Product Id</th>

                                                <th>
                                                    Product Name
                                                </th>
                                                <th>
                                                    Quantity
                                                </th>

                                                <th>
                                                    Price
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>

                                                <th></th>
                                                <th>Product Id</th>

                                                <th>
                                                    Product Name
                                                </th>
                                                <th>
                                                    Quantity
                                                </th>

                                                <th>
                                                    Price
                                                </th>

                                            </tr>
                                        </tfoot>
                                    </table> --}}


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">Item Product
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table id="purchaseItem" class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">
                                                <button type="button" onclick="addPurchaseItem()"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-plus">
                                                    </i>
                                                </button>
                                            </th>
                                            <th>Product Id</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($purchase->items as $item)
                                            <tr>
                                                <td></td>
                                                <td>{{ $item->product_id }}</td>
                                                <td>{{ $item->product->product_name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div>
                </div>

            </div>

        </section>
        {{-- <div class="modal fade" id="addProductModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Item Purchase</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="purchase_item">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Product</label>
                                <div class="col-sm-10">
                                    
                                    <input style="display: none" id="index" class="form-control" name="index">

                                    <input style="display: none" id="product_id" class="form-control" name="id">

                                    <input type="text" readonly id="product_name" class="form-control"
                                        placeholder="Click here to choose Product" onclick="showProduct()"
                                        name="product_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Quantity</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="quantity" name="quantity"
                                        placeholder="Quantity">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="price" name="price" placeholder="Price">

                                </div>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" onclick="onClose()">Close</button>
                            <button type="button" class="btn btn-primary" onclick="onSave()">Save changes</button>
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
        let table;
        let itemPurchaseSelected;
        let mode = "{{ $mode }}"
        $(function() {
            table = $('#purchaseItem').DataTable({
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
                        targets: 1,
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
                    }, {
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
                        data: 'quantity',
                        name: 'quantity',
                        render: function(data, type) {
                            return `<input type="number" class="form-control" value="${data}">`
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



            $('#purchase_date').val(moment().format('yyyy-MM-DD'));
            $('#purchaseItem').on('change', 'input', function() {
                //Get the cell of the input
                var cell = $(this).closest('td');

                //invalidate the DT cache
                table.cell($(cell)).data($(this).val()).invalidate().draw();

            });
        })

        document.addEventListener('productDatatable', (e) => {
            if (e.detail) {

                table.cell(itemPurchaseSelected, 1).data(e.detail.id).invalidate();
                table.cell(itemPurchaseSelected, 2).data(e.detail.product_name).invalidate();

            }
        });




        function saveOrder() {
            console.log(mode)
            $.ajax({
                type: "POST",
                url: "{{ url('purchase/saveOrder') }}",
                data: {
                    mode: mode,
                    po_no: $('#po_no').val(),
                    purchase_date: $('#purchase_date').val(),
                    description: $('#description').val(),
                    status: "",
                    items: table.rows().data().toArray()
                },
                success: function(data) {
                    if (data.status) {
                        window.location = "{{ url('purchase') }}"; //
                        toastr.success(data.message)

                    } else {
                        toastr.warning(data.message)
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.warning(XMLHttpRequest.responseJSON.message)
                }
            })
        }

        function submit(type) {
            console.log(type)
            let url = "";
            if (type === "COMPLETE") {
                url = "{{ url('purchase/completeOrder') }}"
            } else if (type === "CANCEL") {
                url = "{{ url('purchase/cancelOrder') }}"
            }
            $.ajax({
                type: "POST",
                url: url,
                data: {

                    po_no: $('#po_no').val(),

                },
                success: function(data) {
                    if (data.status) {
                        window.location = "{{ url('purchase') }}"; //
                        toastr.success(data.message)

                    } else {
                        toastr.warning(data.message)
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.warning(XMLHttpRequest.responseJSON.message)
                }
            })
        }


        function deleteItem(index) {
            table.rows(index)
                .remove()
                .draw()
        }

        function addPurchaseItem() {
            table.row.add({
                product_id: '',
                product_name: '',
                quantity: 0,
                price: 0
            }).draw(false);
        }

        function applyProduct(index) {
            itemPurchaseSelected = index;
            showProduct()
        }
    </script>
@endpush
