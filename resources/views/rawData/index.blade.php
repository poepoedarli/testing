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
                <h3 class="block-title">Raw Data Management

                </h3>
            </div>
            <div class="block-content block-content-full pt-0">

                @component('components.message')
                    <!-- show alert message  -->
                @endcomponent
                <div class="row" style="margin-left: 80px;margin-top: 28px;position: absolute;">
                    <h6>Dataset Info &nbsp;&nbsp; ID: {{$datasetInfo->id}}&nbsp;&nbsp; Lot ID: {{$datasetInfo->lot_id}}
                        &nbsp;&nbsp; Ref.
                        No.: {{$datasetInfo->ref_no}}
                        &nbsp;&nbsp; Created
                        At: {{$datasetInfo->created_at}}</h6>
                </div>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="raw-data-dtable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ref. No.</th>
                        <th>Image</th>
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
                    data: 'ref_no',
                    name: 'ref_no',
                },
                {
                    data: 'img_path',
                    name: 'img_path',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    width: '140px',
                },
                {
                    data: 'actions',
                    name: 'actions',
                    width: '180px',
                    class: 'notexport',
                    orderable: false,
                    searchable: false
                },
            ];

            const filterColumns = {"inputs": ["ID", "Ref. No."], "selects": {}};
            const ajax_url = "{!!  route('raw_data.index',["datasetId"=>$datasetId]) !!}  ";
            const table_id = "raw-data-dtable";
            const deleteUrl = "/raw_data/"
            setTimeout(() => {
                Custom.initDataTable(table_id, ajax_url, dtColumns, filterColumns, deleteUrl)
            }, 200);
        });
    </script>
@endsection
