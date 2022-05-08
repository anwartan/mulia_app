@extends('layouts.layout')
@section('content')
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Product </li>
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
                    {{-- <form id="orderFilter">
                        <div class="row">

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
                    </form> --}}

                </div>

                <div class="row">
                    <div class="col-12">


                        <div class="card">

                            <div class="card-body">

                                <div class="row">
                                    <div class="col">
                                        <table id="productTable"
                                            class="table table-bordered table-hover dataTable dtr-inline collapsed">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <a href="{{ route('product.create') }}"
                                                            class="btn btn-primary buttons-copy buttons-html5"><span>Add
                                                                Product</span></a>
                                                    </th>
                                                    <th>
                                                        Product Name
                                                    </th>
                                                    <th>
                                                        Product SKU
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
                                                        Product Name
                                                    </th>
                                                    <th class="filter">
                                                        Product SKU
                                                    </th class="filter">

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
            // datagrid = $('#productTable').DataTable({
            //     ajax: {
            //         url: "{{ url('product/datagrid') }}",
            //         data: function(d) {

            //             d.status = $('#status option:selected').val();
            //         }
            //     },

            //     processing: true,
            //     serverSide: true,
            //     responsive: true,
            //     autoWidth: false,
            //     columnDefs: [{
            //         orderable: false,
            //         className: 'select-checkbox',
            //         targets: 0
            //     }],
            //     select: {
            //         style: 'os',
            //         selector: 'td:first-child'
            //     },
            //     order: [
            //         [1, 'asc']
            //     ],
            //     columns: [{
            //             data: null,
            //             defaultContent: '',
            //         }, {
            //             data: 'product_name',
            //             name: 'product_name',

            //         },
            //         {
            //             data: 'product_sku',
            //             name: 'product_sku'
            //         },

            //         {
            //             data: 'status_name',
            //             name: 'status_name',
            //             render: function(data, type) {

            //                 if (type === 'display' && data != undefined) {
            //                     let style = 'primary';
            //                     if (data === "ACTIVE") {
            //                         style = 'success';
            //                     } else if (data === "DISACTIVE") {
            //                         style = "danger";
            //                     }

            //                     return '<span class="badge badge-pill badge-' + style + '">' +
            //                         data +
            //                         '</span>';

            //                 } else {
            //                     return "";
            //                 }

            //             }
            //         },
            //         {
            //             data: 'product_description',
            //             name: 'product_description'
            //         },
            //         {
            //             data: null,


            //             orderable: false,
            //             render: function(data, type, row) {
            //                 let editbtn = `<a class="btn btn-info btn-sm mr-1" href="{{ url('product/') }}/${row.id}/edit">
        //                   <i class="fas fa-pencil-alt">
        //                   </i>
        //                   </a>`
            //                 let delBtn = `<form action="{{ url('product') }}/ ${row . id}" method="POST" style="display: inline-block">
        //                         {!! method_field('delete') . csrf_field() !!}
        //                         <button type="submit" class="btn btn-danger btn-sm">
        //                             <i class="fas fa-trash">
        //                             </i>
        //                         </button>
        //                     </form>
        //                   `
            //                 return editbtn + delBtn;

            //             }
            //         },


            //     ],

            // })
            $('#productTable tfoot th.filter').each(function() {
                var title = $(this).text().trim();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });



            datagrid = $('#productTable').DataTable({
                ajax: {
                    url: "{{ url('product/datagrid') }}",
                    data: function(d) {

                        // d.status = $('#status option:selected').val();
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
                    [1, "asc"]
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
                            let editbtn = `<a class="btn btn-info btn-sm mr-1" href="{{ url('product/') }}/${row.id}/edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                          </a>`
                            let delBtn = `<form action="{{ url('product') }}/ ${row . id}" method="POST" style="display: inline-block">
                                {!! method_field('delete') . csrf_field() !!}
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash">
                                    </i>
                                </button>
                            </form>
                          `
                            return editbtn + delBtn;

                        }
                    }, {
                        data: 'product_name',
                        name: 'product_name',
                    },
                    {
                        data: 'product_sku',
                        name: 'product_sku'
                    },

                    {
                        data: 'status_name',
                        name: 'status_name',
                        render: function(data, type) {

                            if (type === 'display' && data != undefined) {
                                let style = 'primary';
                                if (data === "ACTIVE") {
                                    style = 'success';
                                } else if (data === "DISACTIVE") {
                                    style = "danger";
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
                        data: 'product_description',
                        name: 'product_description'
                    },



                ],
            })

            // $('#orderFilter').on('submit', function(e) {
            //     datagrid.draw();
            //     e.preventDefault();
            // });

        })
    </script>
@endpush
