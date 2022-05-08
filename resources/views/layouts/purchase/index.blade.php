@extends('layouts.layout')
@section('content')
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Purchase</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Purchase </li>
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

                            </div>

                        </div>
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
                                                        <a href="{{ route('purchase.create') }}"
                                                            class="btn btn-primary buttons-copy buttons-html5"><span>Create
                                                                Order
                                                                Purchase</span></a>
                                                    </th>
                                                    <th>
                                                        PO Number
                                                    </th>
                                                    <th>
                                                        Purchase Date
                                                    </th>

                                                    <th>
                                                        Status
                                                    </th>
                                                    <th>
                                                        Description
                                                    </th>


                                                </tr>
                                            </thead>
                                            <tbody></tbody>

                                            <tfoot>
                                                <tr>
                                                    <th>
                                                        Please enter to search
                                                    </th>
                                                    <th class="filter">
                                                        PO Number
                                                    </th>
                                                    <th class="filter">
                                                        Purchase Date
                                                    </th>

                                                    <th class="filter">
                                                        Status
                                                    </th>
                                                    <th class="filter">
                                                        Description
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

            $('#productTable tfoot th.filter').each(function() {
                var title = $(this).text().trim();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });
            datagrid = $('#productTable').DataTable({
                ajax: {
                    url: "{{ url('purchase/datagrid') }}",
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

                    targets: 0
                }],

                order: [
                    [1, 'asc']
                ],
                initComplete: function() {
                    // Apply the search
                    this.api().columns().every(function() {
                        var that = this;

                        $('input', this.footer()).on('keyup change clear', function() {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                },
                columns: [{
                        data: null,


                        orderable: false,
                        render: function(data, type, row) {
                            let editbtn = `<a class="btn btn-info btn-sm mr-1" href="{{ url('purchase/') }}/${row.id}/edit">
                              <i class="fas fa-pencil-alt">
                              </i>
                              </a>`

                            return editbtn;

                        }
                    }, {
                        data: 'po_no',
                        name: 'po_no',

                    },
                    {
                        data: 'purchase_date',
                        name: 'purchase_date'
                    },

                    {
                        data: 'status_name',
                        name: 'status_name',
                        render: function(data, type) {

                            if (type === 'display' && data != undefined) {
                                let style = 'primary';
                                if (data === "COMPLETE") {
                                    style = 'success';
                                } else if (data === "CANCEL") {
                                    style = "danger";
                                } else if (data === "PENDING") {
                                    style = "warning";
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



                ],
                // footerCallback: function(row, data, start, end, display) {
                //     var api = this.api();

                //     // Remove the formatting to get integer data for summation
                //     var intVal = function(i) {
                //         return typeof i === 'string' ?
                //             i.replace(/[\$,]/g, '') * 1 :
                //             typeof i === 'number' ?
                //             i : 0;
                //     };
                //     // Total over all pages

                //     total = api
                //         .column(5)
                //         .data()
                //         .reduce(function(a, b) {
                //             return intVal(a) + intVal(b);
                //         }, 0);
                //     pageTotal = api
                //         .column(5, {
                //             page: 'current'
                //         })
                //         .data()
                //         .reduce(function(a, b) {
                //             return intVal(a) + intVal(b);
                //         }, 0);
                //     $(api.column(5).footer()).html(
                //         'Rp ' + pageTotal
                //         // + ' ( ' +total + ' total)'
                //     );
                // }
            })

            $('#orderFilter').on('submit', function(e) {
                datagrid.draw();
                e.preventDefault();
            });

        })
    </script>
@endpush
