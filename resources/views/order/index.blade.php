@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection

@section('js')
    <!-- jQuery (required for DataTables plugin) -->
    <!--<script src="{{ asset('js/lib/jquery.min.js') }}"></script> -->

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

    <!-- Page JS Code -->
    @vite(['resources/js/pages/datatables.js'])

@endsection

@section('content')

    <div class="content">

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <i class="fa fa-order mr-2"></i> Order Management
                </h3>
            </div>
            <div class="block-content block-content-full pt-0">

                @component('components.message')
                    <!-- show alert message  -->
                @endcomponent

                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="order-dtable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Order Status</th>
                        <th>Amount</th>
                        <th>Services</th>
                        <th>Created At</th>
                        <th>Pay Time</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var table;
        $(function () {
            const dtColumns = [
                {
                    data: 'id',
                    name: 'id',
                    width: '20px',
                },
                {
                    data: 'user',
                    name: 'user',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'order_status',
                    name: 'order_status'
                },
                {
                    data: 'price',
                    name: 'price',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'services',
                    name: 'services',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'pay_time',
                    name: 'pay_time'
                },
                {
                    data: 'action',
                    name: 'action',
                    width: '20px',
                    orderable: false,
                    searchable: false
                },
            ];
            const filterColumns = {"inputs": ["ID"]};
            const ajax_url = "{{ route('order.index') }}";
            const table_id = "order-dtable";
            const deleteUrl = "/order/"
            setTimeout(() => {
                Custom.initDataTable(table_id, ajax_url, dtColumns, filterColumns, deleteUrl)
            }, 200);

        });

        function payment(id) {

            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: '/order/payment',
                type: 'POST',
                DataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': "application/json"
                },
                data: {
                    "_token": token,
                    "id": id
                },
                success: function (response) {
                    alert(response['data']['msg'])
                    location.reload()
                }
            });
        }
    </script>
@endsection