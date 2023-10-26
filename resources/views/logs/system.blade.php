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
                <i class="fa fa-book-tanakh mr-2"></i> System Logs
                @if (Auth::user()->id == 1)
                <div class="d-flex" style="float:right">
                    <a class="btn btn-sm btn-danger text-white" onclick="Custom.clearLogs('system')"> <i class="fa fa-trash me-1"></i> Clear All Logs</a>
                </div>
                @endif
            </h3>
        </div>
        <div class="block-content block-content-full pt-0">

            @component('components.message')
            <!-- show alert message  --> 
            @endcomponent

            <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="system-log-dtable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Logged At</th>
                        <th>Level</th>
                        <th>Type</th>
                        <th>Message</th>
                        <th class="wrapword">Context</th>
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
        const dtColumns = 
            [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                width: '15px'
            },
            {
                data: 'logged_at_readable',
                name: 'logged_at',
                width: '14%'
            },
            {
                data: 'level',
                name: 'level',
                width: '45px'
            },
            {
                data: 'type-badge',
                name: 'level_name',
                width: '10%'
            },
            {
                data: 'message',
                name: 'message',
                width: '10%'
            },
            {
                data: 'context',
                name: 'context',
                class: 'wrapword'
            },
        ];
        const log_types = JSON.parse('{!! json_encode( config("global.log_types")) !!}');
        const logTypeObj = {};
        for (const type of log_types) {
            logTypeObj[type] = type;
        }
        const filterColumns = {"inputs": ["Logged At", "Level", "Message", "Context", "Extra"], "selects": {"Type": logTypeObj}, "dates": []};//, 
        const ajax_url = "{{ route('system_logs.index') }}";
        const table_id = "system-log-dtable";
        const deleteUrl = "/system_logs/"
        Custom.initDataTable(table_id, ajax_url, dtColumns, filterColumns, deleteUrl, 1, 'desc')
        $(".buttons-excel").hide();
    });
</script>
@endsection