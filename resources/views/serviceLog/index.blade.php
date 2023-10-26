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
                    <i class="fa fa-book-journal-whills mr-2"></i> Operation Logs
                </h3>
            </div>
            <div class="block-content block-content-full pt-0">

                @component('components.message')
                    <!-- show alert message  -->
                @endcomponent

                <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="service-log-dtable">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Logged At</th>
                        <th>Operator</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Content</th>

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
                        data: 'created_at',
                        name: 'created_at',
                        width: '140px'
                    },
                    {
                        data: 'operator',
                        name: 'operator',
                       
                    },
                    {
                        data: 'title',
                        name: 'title',
                        width: '10%'
                    },
                    {
                        data: 'type-badge',
                        name: 'category',
                        width: '10%'
                    },
                    {
                        data: 'content',
                        name: 'content',
                        width: '50%'
                    }
                ];
            const log_types = JSON.parse('{!! json_encode( config("global.log_types")) !!}');
            const logTypeObj = {};
            for (const type of log_types) {
                logTypeObj[type] = type;
            }
            const filterColumns = {
                "inputs": ["Title", "Content", "Logged At"],
                "selects": {"Type": logTypeObj},
                "dates": []
            };//, 
            const ajax_url = "{{ route('service_log.index') }}";
            const table_id = "service-log-dtable";
            const deleteUrl = "/service_log/"
            Custom.initDataTable(table_id, ajax_url, dtColumns, filterColumns, deleteUrl, 1, 'desc')
            $(".buttons-excel").hide();
        });
    </script>
@endsection