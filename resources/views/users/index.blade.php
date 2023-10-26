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

<div class="">
    
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title text-primary">
                <i class="fa fa-users mr-2"></i> User Management 
                @if (Auth::user()->can('user-create'))
                <div class="d-flex" style="float:right">
                    <a class="btn btn-sm btn-primary text-white" href="{{ route('users.create') }}"> <i class="fa fa-plus me-1"></i> Create User</a>
                </div>
                @endif
            </h3>
        </div>
        <div class="block-content block-content-full pt-0">

            @component('components.message')
            <!-- show alert message  --> 
            @endcomponent

            <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
            <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="user-dtable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Code</th>
                        <th>Phone</th>
                        <th>Roles</th>
                        <th>Department</th>
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
        const dtColumns = [{
                                data: 'id',
                                name: 'users.id',
                            },
                            {
                                data: 'user_name',
                                name: 'user_name'
                            },
                            {
                                data: 'email',
                                name: 'email'
                            },
                            {
                                data: 'country_code',
                                name: 'country_code'
                            },
                            {
                                data: 'phone',
                                name: 'phone'
                            },
                            {
                                data: 'role_name',
                                name: 'role_name'
                            },
                            {
                                data: 'department_name',
                                name: 'department_name'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                width: '66px',
                                class: 'notexport',
                                orderable: false,
                                searchable: false
                            },
                        ];
        const filterColumns = {"inputs": ["ID", "Name", "Email", "Code", "Phone", "Roles", "Department"]};
        const ajax_url = "{{ route('users.index') }}";
        const table_id = "user-dtable";
        const deleteUrl = "/users/"
        setTimeout(() => {
            Custom.initDataTable(table_id, ajax_url, dtColumns, filterColumns, deleteUrl)
        }, 200);
        
    });
</script>
@endsection