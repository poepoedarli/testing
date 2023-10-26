@extends('service.run.index')

@section('run-application-content')
    <div class="block block-rounded">
        <div class="block-content block-content-full pt-0">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
            <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter "
                   id="mlops-data-manual-judgment-dtable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Job ID</th>
                    <th>Dataset ID</th>
                    <th>Raw Data ID</th>
                    <th>Part Ref. No.</th>
                    <th>Image</th>
                    <th>AI Result</th>
                    <th>AI Code</th>
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
            getDataManualJudgment()
        })

        function getDataManualJudgment() {

            const dataReportColumns = [
                {
                    data: 'id',
                    name: 'id',
                    width: "20px"
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
                    data: 'part_ref_no',
                    name: 'part_ref_no',
                },
                {
                    data: 'img_path',
                    name: 'img_path',
                },
                {
                    data: 'ai_result',
                    name: 'ai_result',
                },
                {
                    data: 'ai_code',
                    name: 'ai_code',
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }
            ];
            const dataReportFilterColumns = {"inputs": ["ID"]};
            const data_report_ajax_url = "{{ route('application.mlops_report',['serviceVersionId'=>$serviceVersionId]) }}";
            const data_report_table_id = "mlops-data-manual-judgment-dtable";
            const dataReportDeleteUrl = "/data_report/"
            setTimeout(() => {
                Custom.initDataTable(data_report_table_id, data_report_ajax_url, dataReportColumns, dataReportFilterColumns, dataReportDeleteUrl, 0, 'desc')
            }, 200);
        }
    </script>

@endsection