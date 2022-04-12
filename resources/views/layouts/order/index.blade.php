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
                            <li class="breadcrumb-item active">Order </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="filter">
                    <form id="orderFilter">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Start Date </label>
                                    <div class="input-group ">
                                        <input name="start_date" type="date" class="form-control"
                                            value="{{ gmdate('Y-m-d', $startDate) }}">
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">End Date</label>
                                    <div class="input-group ">
                                        <input name="end_date" type="date" class="form-control"
                                            value="{{ gmdate('Y-m-d', $endDate) }}">
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        @foreach ($statusEnum as $status)
                                            <option {{ $status['selected'] ? 'selected' : '' }}
                                                value="{{ $status['value'] }}">
                                                {{ $status['id'] }}</option>
                                        @endforeach


                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button type="reset" class="btn btn-danger">Clear</button>
                                <button onclick="print()" type="button"
                                    class="btn btn-primary float-right ml-1">Print</button>
                            </div>

                        </div>
                    </form>

                </div>

                <div class="row">
                    <div class="col-12">


                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('order.create') }}"
                                    class="btn btn-primary buttons-copy buttons-html5"><span>Add
                                        Order</span></a>



                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="row">
                                    <div class="col">
                                        <table id="orderTable"
                                            class="table table-bordered table-hover dataTable dtr-inline collapsed">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>
                                                        Tanggal Pemesanan
                                                    </th>
                                                    <th>
                                                        Receipt No
                                                    </th>

                                                    <th>
                                                        Status
                                                    </th>
                                                    <th>
                                                        Description
                                                    </th>
                                                    <th>
                                                        Price
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                            {{-- <tbody>
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ $order->transaction_date }}</td>
                                                        <td>{{ $order->receipt_no }}</td>
                                                        <td>
                                                            <span
                                                                class="badge badge-pill badge-primary">{{ $order->status_name }}</span>
                                                        </td>
                                                        <td>{{ $order->price }}</td>

                                                        <td>{{ $order->created_at_string }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody> --}}
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>
                                                        Tanggal Pemesanan
                                                    </th>
                                                    <th>
                                                        Receipt No
                                                    </th>

                                                    <th>
                                                        Status
                                                    </th>
                                                    <th>
                                                        Description
                                                    </th>
                                                    <th>
                                                        Price
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>

                                                </tr>
                                            </tfoot>

                                        </table>


                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>

                <!-- /.row -->
            </div>
            {{-- <form action="{{ route('order.destroy') }}" method="POST" style="display: inline-block">
                {!! method_field('delete') . csrf_field() !!}
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash">
                    </i>
                </button>
            </form> --}}

            <!-- /.container-fluid -->

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
        let datagrid;
        $(function() {
            datagrid = $('#orderTable').DataTable({
                ajax: {
                    url: "{{ url('order/datagrid') }}",
                    data: function(d) {
                        d.start_date = $('input[name=start_date]').val();
                        d.end_date = $('input[name=end_date]').val();
                        d.status = $('#status option:selected').val();
                    }
                },

                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                order: [
                    [1, 'asc']
                ],
                columns: [{
                        data: null,
                        defaultContent: '',
                    }, {
                        data: 'transaction_date',
                        name: 'transaction_date'
                    },
                    {
                        data: 'receipt_no',
                        name: 'receipt_no'
                    },

                    {
                        data: 'status_name',
                        name: 'status_name',
                        render: function(data, type) {

                            if (type === 'display' && data != undefined) {
                                let style = 'primary';
                                if (data === "ON PROGRESS") {
                                    style = 'warning';
                                } else if (data === "CANCELED") {
                                    style = "danger";
                                } else if (data === "COMPLETED") {
                                    style = "success";
                                }

                                return '<span class="badge badge-pill badge-' + style + '">' +
                                    data +
                                    '</span>';

                            } else {
                                return "";
                            }

                        }
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: null,


                        orderable: false,
                        render: function(data, type, row) {
                            let editbtn = `<a class="btn btn-info btn-sm mr-1" href="{{ url('order/') }}/${row.id}/edit">
                              <i class="fas fa-pencil-alt">
                              </i>
                              </a>`
                            let delBtn = `<form action="{{ url('order') }}/ ${row . id}" method="POST" style="display: inline-block">
                                    {!! method_field('delete') . csrf_field() !!}
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash">
                                        </i>
                                    </button>
                                </form>
                              `
                            return editbtn + delBtn;

                        }
                    },


                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };
                    // Total over all pages

                    total = api
                        .column(5)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    pageTotal = api
                        .column(5, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    $(api.column(5).footer()).html(
                        'Rp ' + pageTotal
                        // + ' ( ' +total + ' total)'
                    );
                }
            })

            $('#orderFilter').on('submit', function(e) {
                datagrid.draw();
                e.preventDefault();
            });

        })

        function print() {
            let data = $('#orderFilter').serialize();

            window.open("{{ url('order/print') }}?" + data.toString(), '_blank');
        }
    </script>
@endpush
