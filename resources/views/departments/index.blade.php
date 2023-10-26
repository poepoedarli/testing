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
                <h3 class="block-title text-primary"><i class="fa fa-fw fa-id-card me-1"></i>Department Management
                    <div class="d-flex" style="float:right">
                        @if (Auth::user()->can('department-create'))
                        <a class="btn btn-sm btn-primary text-white" href="{{ route('departments.create') }}"> <i
                                    class="fa fa-plus me-1"></i> Create Department</a>
                        @endif
                    </div>
                </h3>
            </div>
            <div class="block-content block-content-full pt-0">

                @component('components.message')
                    <!-- show alert message  -->
                @endcomponent

                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="department-dtable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Desc</th>
                        <th>Created At</th>
                        <th style="width:140px">Action</th>
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
                    width: "50px",
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'desc',
                    name: 'desc',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    width: '140px',
                },
                {
                    data: 'actions',
                    name: 'actions',
                    width: '66px',
                    class: 'notexport',
                    orderable: false,
                    searchable: false
                },
            ];

            const filterColumns = {"inputs": ["ID", "Name", "Desc"], "selects": {}};
            const ajax_url = "{{ route('departments.index') }}";
            const table_id = "department-dtable";
            const deleteUrl = "/departments/"
            setTimeout(() => {
                Custom.initDataTable(table_id, ajax_url, dtColumns, filterColumns, deleteUrl)
            }, 200);
        });
    </script>
@endsection
