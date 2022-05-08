@extends('layouts.layout')
@section('content')
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product Stock</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Stock</li>
                            <li class="breadcrumb-item active">Product</li>
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
                        {{-- <div class="row">

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

                            </div>

                        </div> --}}
                    </form>

                </div>

                <div class="row">
                    <div class="col-12">


                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="row">
                                    <div class="col">
                                        <table id="productTable"
                                            class="table table-bordered table-hover dataTable dtr-inline collapsed">
                                            <thead>
                                                <tr>

                                                    <th>
                                                        Product Name
                                                    </th>
                                                    <th>
                                                        Price
                                                    </th>

                                                    <th>
                                                        Quantity
                                                    </th>
                                                    <th>
                                                        Create Time
                                                    </th>

                                                    <th>
                                                        Update TIme
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>

                                            <tfoot>
                                                <tr>
                                                    <th>
                                                        Product Name
                                                    </th>
                                                    <th>
                                                        Price
                                                    </th>

                                                    <th>
                                                        Quantity
                                                    </th>
                                                    <th>
                                                        Create Time
                                                    </th>

                                                    <th>
                                                        Update TIme
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


        </section>


    </div>
@endsection
@push('scripts')
    <script>
        let datagrid;
        $(function() {
            datagrid = $('#productTable').DataTable({
                ajax: {
                    url: "{{ url('productStock/datagrid') }}",
                    data: function(d) {


                    }
                },

                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                columnDefs: [],

                order: [
                    [1, 'asc']
                ],
                columns: [{
                        data: 'product.product_name',
                        name: 'product_name',

                    },
                    {
                        data: 'price',
                        name: 'price'
                    },

                    {
                        data: 'quantity',
                        name: 'quantity',


                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type) {
                            return moment(parseInt(data)).format("DD-MM-yy hh:mm")
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        render: function(data, type) {
                            return moment(parseInt(data)).format("DD-MM-yy hh:mm")
                        }
                    }



                ],

            })

            $('#orderFilter').on('submit', function(e) {
                datagrid.draw();
                e.preventDefault();
            });

        })
    </script>
@endpush
