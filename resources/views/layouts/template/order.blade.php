<!DOCTYPE html>
<html>

<head>
    <title>Hi</title>
    <style>
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            /* background-color: #03a9f4;
            color: white; */
            text-align: center;
            line-height: 35px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            background-color: #03a9f4;
            color: white;
            text-align: center;
            line-height: 35px;
        }

        table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }


        tr {
            border-bottom: 0.5px solid black;

        }

        th,
        td {
            padding: 15px;
            text-align: center
        }

    </style>
</head>

<body>
    <header>
        <b>
            LAPORAN PENJUALAN
            <br>
            {{ $start_date }} s/d {{ $end_date }}
        </b>

    </header>
    <hr>
    {{-- <footer>
        Copyright &copy; <?php echo date('Y'); ?>
    </footer> --}}
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
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
            </tr>
        </thead>
        <tbody>
            @if (count($orders) <= 0)
                <tr>
                    <td colspan="6">Data Kosong</td>
                </tr>
            @endif
            @foreach ($orders as $key => $order)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $order->transaction_date }}</td>
                    <td>{{ $order->receipt_no }}</td>
                    <td>
                        {{ $order->status_name }}
                    </td>
                    <td>{{ $order->description }}</td>
                    <td>{{ $order->price }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>#</th>
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
            </tr>
        </tfoot>
        <tfoot>
            <tr>

                <th colspan="4"></th>
                <th>Total : </th>
                <th>Rp. {{ $total }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
