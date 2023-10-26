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
                <h3 class="block-title text-primary">
                    <i class="fa fa-order mr-2"></i> User Application Management
                </h3>
            </div>
            <div class="block-content block-content-full pt-0">

                @component('components.message')
                    <!-- show alert message  -->
                @endcomponent

                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="user_service-dtable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>service</th>
                        <th>User</th>
                        <th>host_port</th>
                        <th>container_port</th>
                        <th>timeout</th>
                        <th>cpu_limit</th>
                        <th>memory_limit</th>
                        <th>gpu_limit</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Confirmation On Modal -->
        <div class="modal fade" id="userServiceModal" tabindex="-1" aria-hidden="false" data-user-service-id="">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-user-service" style="display: none">
                        <div class="user-service-id"></div>
                        <div class="confirm-type"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="confirmService()">Confirm</button>
                    </div>
                </div>
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
                    data: 'service',
                    name: 'service',
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'host_port',
                    name: 'host_port'
                },
                {
                    data: 'container_port',
                    name: 'container_port',
                },
                {
                    data: 'timeout',
                    name: 'timeout',
                },
                {
                    data: 'cpu_limit',
                    name: 'cpu_limit',
                },
                {
                    data: 'gpu_limit',
                    name: 'gpu_limit',

                },
                {
                    data: 'memory_limit',
                    name: 'memory_limit',

                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    width: '140px',
                    class: 'notexport',
                    orderable: false,
                    searchable: false
                },
            ];
            const filterColumns = {"inputs": ["ID"]};
            const ajax_url = "{{ route('user_service.index') }}";
            const table_id = "user_service-dtable";
            const deleteUrl = "/user_service/"
            setTimeout(() => {
                Custom.initDataTable(table_id, ajax_url, dtColumns, filterColumns, deleteUrl)
            }, 200);

        });

        function startService(id) {
            var userOrderServiceDiv = document.getElementById("user_order_service_" + id)
            var serviceName = userOrderServiceDiv.getAttribute('data-service-name');

            var modal = $('#userServiceModal');
            modal.find('.modal-title').text('start service ' + serviceName);
            modal.find('.modal-body').text('Are you sure to start ' + serviceName + ' ?');
            modal.find('.modal-user-service .user-service-id').text(id);
            modal.find('.modal-user-service .confirm-type').text(2);
            modal.modal('show');
        }

        function stopService(id) {
            var userOrderServiceDiv = document.getElementById("user_order_service_" + id)
            var serviceName = userOrderServiceDiv.getAttribute('data-service-name');

            var modal = $('#userServiceModal');
            modal.find('.modal-title').text('stop service ' + serviceName);
            modal.find('.modal-body').text('Are you sure to stop ' + serviceName + ' ?');
            modal.find('.modal-user-service .user-service-id').text(id);
            modal.find('.modal-user-service .confirm-type').text(1);
            modal.modal('show');
        }

        function confirmService() {
            var modal = $('#userServiceModal');
            var id = modal.find('.modal-user-service .user-service-id').text();
            var confirmType = modal.find('.modal-user-service .confirm-type').text();
            modal.modal('hide');
            let token = $("meta[name='csrf-token']").attr("content");
            $.post({
                url: '/user_service/confirm_service',
                type: 'POST',
                DataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': "application/json"
                },
                data: {
                    "_token": token,
                    "id": id,
                    "confirmType": confirmType,
                },
                success: function (response) {
                    location.reload()
                }
            });

        }
    </script>
@endsection