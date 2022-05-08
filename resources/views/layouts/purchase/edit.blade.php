@extends('layouts.layout')
@section('content')
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Order Purchase</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item "><a href="#">Purchase</a> </li>
                            <li class="breadcrumb-item active">Edit Order Purchase</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form>


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
                                    <div class="toolbar d-flex flex-start mb-2">
                                        @if ($purchase->status_name == 'PENDING')
                                            <button type="button" onclick="onAddItem()" class="btn btn-primary mr-1">Add
                                                Item</button>
                                            <button type="button" onclick="onUpdateItem()"
                                                class="btn btn-primary mr-1">Update
                                                Item</button>
                                            <button type="button" onclick="onDeleteItem()" class="btn btn-primary">Delete
                                                Item</button>
                                        @endif

                                    </div>
                                    <table id="purchaseItem"
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
                                    </table>


                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ url('/purchase') }}" class="btn btn-secondary">Cancel</a>
                            @if ($purchase->status_name == 'PENDING')
                                <input type="button" value="Complete" onclick="complete()"
                                    class="btn btn-success float-right ml-1">
                                <input type="button" value="Cancel" onclick="cancel()"
                                    class="btn btn-success float-right ml-1">
                                <input type="button" value="Save" onclick="saveOrder()"
                                    class="btn btn-success float-right ml-1">
                            @endif

                        </div>
                    </div>
                </div>
            </form>

        </section>
        <div class="modal fade" id="addProductModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Item Purchase</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="purchase_item">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Product</label>
                                <div class="col-sm-10">
                                    {{-- <select id="productSelect" class="form-control select2" style="width: 100%;"
                                        name="product">

                                    </select> --}}
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
        </div>


    </div>
@endsection

@push('scripts')
    <script>
        let table;

        $(function() {
            table = $('#purchaseItem').DataTable({
                responsive: true,
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }, {
                    targets: 1,
                    visible: false
                }],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                columns: [{
                        data: null,
                        defaultContent: '',
                    }, {
                        data: 'product_id',
                        name: 'product_id',

                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                ]
            })

            // $('#productSelect').select2({
            //     ajax: {
            //         url: "{{ url('product/data') }}",
            //         dataType: 'json',
            //         delay: 250,
            //         tags: true,
            //         data: function(params) {

            //             return {
            //                 product_name: params.term, // search term
            //                 page: params.page,
            //                 per_page: 5,
            //             };
            //         },
            //         processResults: function(data, params) {
            //             // parse the results into the format expected by Select2
            //             // since we are using custom formatting functions we do not need to
            //             // alter the remote JSON data, except to indicate that infinite
            //             // scrolling can be used
            //             params.page = params.page || 1;
            //             console.log(data)
            //             return {
            //                 results: data.data,
            //                 pagination: {
            //                     more: (params.page * data.per_page) < data.total
            //                 }
            //             };
            //         },
            //         cache: true
            //     },
            //     placeholder: 'Search for a product',
            //     minimumInputLength: 1,
            //     templateResult: formatRepo,
            //     templateSelection: formatRepoSelection
            // })



            // function formatRepoSelection(repo) {
            //     return repo.product_name;
            // }

            // function formatRepo(repo) {
            //     return repo.product_name
            //     // if (repo.loading) {
            //     //     return repo.text;
            //     // }

            //     // var $container = $(
            //     //     "<div class='select2-result-repository clearfix'>" +
            //     //     "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url +
            //     //     "' /></div>" +
            //     //     "<div class='select2-result-repository__meta'>" +
            //     //     "<div class='select2-result-repository__title'></div>" +
            //     //     "<div class='select2-result-repository__description'></div>" +
            //     //     "<div class='select2-result-repository__statistics'>" +
            //     //     "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" +
            //     //     "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" +
            //     //     "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" +
            //     //     "</div>" +
            //     //     "</div>" +
            //     //     "</div>"
            //     // );

            //     // $container.find(".select2-result-repository__title").text(repo.full_name);
            //     // $container.find(".select2-result-repository__description").text(repo.description);
            //     // $container.find(".select2-result-repository__forks").append(repo.forks_count + " Forks");
            //     // $container.find(".select2-result-repository__stargazers").append(repo.stargazers_count + " Stars");
            //     // $container.find(".select2-result-repository__watchers").append(repo.watchers_count + " Watchers");

            //     // return $container;
            // }
            $('#purchase_date').val(moment().format('yyyy-MM-DD'));

        })

        document.addEventListener('productDatatable', (e) => {
            if (e.detail) {
                $("#product_name").val(e.detail.product_name)
                $("#product_id").val(e.detail.id)
            }
        });

        function getSelectedSelect2() {
            let index = $('#productSelect').select2("val");
            let data = $('#productSelect').select2("data");
            let selected = data.find((x) => x.id == index);
            return selected;

        }

        function onAddItem() {
            onResetItem()
            console.log($("#index").val())
            $('#addProductModal').modal('show')
        }

        function onSave() {
            let index = $("#index").val()
            let product_name = $("#product_name").val()
            let product_id = $("#product_id").val()
            let quantity = $('#quantity').val()
            let price = $('#price').val()
            console.log(index)
            if (index) {
                table.row(index).data({
                    product_id: product_id,
                    product_name: product_name,
                    quantity: quantity,
                    price: price
                }).invalidate();
            } else {
                table.row.add({
                    product_id: product_id,
                    product_name: product_name,
                    quantity: quantity,
                    price: price
                }).draw(false);
            }

            $('#addProductModal').modal('hide')

        }
        $('#addProductModal').on('hidden.bs.modal', function(event) {
            console.log("onclose")
            onResetItem()
        })


        function onClose() {
            $('#addProductModal').modal('hide')
        }

        function onResetItem() {
            $('#purchase_item').trigger("reset");
            // $("#productSelect").empty().trigger('change')
        }

        function onDeleteItem() {
            table.rows('.selected')
                .remove()
                .draw()
        }

        function onUpdateItem() {
            let selected = table.row('.selected').data()
            let index = table.row('.selected').index()
            console.log(index)

            $('#quantity').val(selected.quantity)
            $('#price').val(selected.price)
            $("#product_name").val(selected.product_name)
            $("#product_id").val(selected.product_id)
            $('#index').val(index)
            $('#addProductModal').modal('show')

        }

        function saveOrder() {
            $.ajax({
                type: "POST",
                url: "{{ url('purchase/saveOrder') }}",
                data: {
                    mode: 'EDIT',
                    po_no: $('#po_no').val(),
                    purchase_date: $('#purchase_date').val(),
                    description: $('#description').val(),
                    status: "",
                    items: table.rows().data().toArray()
                },
                success: function(data) {
                    toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
                    window.location = "{{ url('purchase') }}"; //
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.info(XMLHttpRequest.responseJSON.message)
                }
            })
        }

        function complete() {
            $.ajax({
                type: "POST",
                url: "{{ url('purchase/completeOrder') }}",
                data: {

                    po_no: $('#po_no').val(),

                },
                success: function(data) {
                    toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
                    window.location = "{{ url('purchase') }}"; //
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.info(XMLHttpRequest.responseJSON.message)
                }
            })
        }

        function cancel() {
            $.ajax({
                type: "POST",
                url: "{{ url('purchase/cancelOrder') }}",
                data: {

                    po_no: $('#po_no').val(),

                },
                success: function(data) {
                    toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
                    window.location = "{{ url('purchase') }}"; //
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.info(XMLHttpRequest.responseJSON.message)
                }
            })
        }
    </script>
@endpush
