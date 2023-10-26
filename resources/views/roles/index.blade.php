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
                <i class="fa fa-universal-access mr-2"></i> Role Management 
                @if (Auth::user()->can('role-create'))
                <div class="d-flex" style="float:right">
                    <a class="btn btn-sm btn-primary text-white" href="{{ route('roles.create') }}"> <i class="fa fa-plus me-1"></i> Create Role</a>
                </div>
                @endif
            </h3>
        </div>
        <div class="block-content block-content-full pt-0">

            @component('components.message')
            <!-- show alert message  --> 
            @endcomponent

            <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
            <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="role-dtable">
                <thead>
                    <tr>
                        <th style="width:150px">ID</th>
                        <th>Name</th>
                        <th style="width:200px">Action</th>
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
                                name: 'id'
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                class: 'notexport',
                                width: '66px',
                                orderable: false,
                                searchable: false
                            }];
        const filterColumns = {};
        const ajax_url = "{{ route('roles.index') }}";
        const table_id = "role-dtable";
        const deleteUrl = "/roles/"
        Custom.initDataTable(table_id, ajax_url, dtColumns, filterColumns, deleteUrl)
    });
</script>
@endsection