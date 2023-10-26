@extends('service.run.index')

@section('run-application-content')
    <div class="block block-rounded">
        <div class="block-header ">
            <h3 class="block-title">
                <i class="fa fa-service mr-2"></i>
            </h3>
        </div>
        <div class="block-content block-content-full pt-0">

            <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
            <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter "
                   id="ocr-report-dtable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Job Id</th>
                    <th>Dataset ID</th>
                    <th>Raw Data ID</th>
                    <th>Result</th>
                    <th>Created At</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>


    <script type="text/javascript">
        var table;
        $(function () {
            getDataReport()
        })

        function getDataReport() {
            const dataReportColumns = [
                {
                    data: 'id',
                    name: 'id',
                    width: "10px",
                },
                {
                    data: 'job_id',
                    name: 'job_id',
                },
                {
                    data: 'data_set_id',
                    name: 'data_set_id',
                },
                {
                    data: 'raw_data_id',
                    name: 'raw_data_id',
                },
                {
                    data: 'result',
                    name: 'result',
                    width: "50%"
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },

            ];
            const dataReportFilterColumns = {"inputs": ["ID"]};
            const data_report_ajax_url = "{{ route('application.ocr_report',['serviceVersionId'=>$serviceVersionId]) }}";
            const data_report_table_id = "ocr-report-dtable";
            const dataReportDeleteUrl = ""
            setTimeout(() => {
                Custom.initDataTable(data_report_table_id, data_report_ajax_url, dataReportColumns, dataReportFilterColumns, dataReportDeleteUrl, 0, 'desc')
            }, 200);
        }
    </script>

@endsection