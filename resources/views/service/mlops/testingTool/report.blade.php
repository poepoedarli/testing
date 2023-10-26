@extends('service.mlops.testingTool.index')

@section('testing-tool-content')
    <div class="block block-rounded">
        <div class="block-content block-content-full pt-0">
            <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " style="text-align: center">
                <thead>
                <th>TP</th>
                <th>FP</th>
                <th>TN</th>
                <th>FN</th>
                </thead>
                <tbody>
                <td>{{ $result['tp']??0}}</td>
                <td>{{ $result['fp']??0}}</td>
                <td>{{ $result['tn']??0}}</td>
                <td>{{ $result['fn']??0}}</td>
                </tbody>
            </table>
        </div>
        <div class="block-header ">
            <h3 class="block-title">
                <i class="fa fa-service mr-2"></i>

                <div class="d-flex" style="float:right">
                    {{--                                                        {{ route('/export-mlops-report') }}--}}
                    <a class="btn btn-sm btn-secondary text-white"
                       href=" {{ route('export_mlops_report') }}"> <i
                                class="fa "></i>Export to Excel</a>
                </div>
            </h3>
        </div>
        <div class="block-content block-content-full pt-0">

            <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
            <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter "
                   id="mlops-data-report-dtable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Job Id</th>
                    <th>Dataset ID</th>
                    <th>Raw Data ID</th>
                    <th>Part Ref. No.</th>
                    <th>Image</th>
                    <th>AI Result</th>
                    <th>AI Code</th>
                    <th>Manual Result</th>
                    <th>Manual Code</th>
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
                    data: 'manual_result',
                    name: 'manual_result',
                },
                {
                    data: 'manual_code',
                    name: 'manual_code',
                },
            ];
            const dataReportFilterColumns = {"inputs": ["ID"]};
            const data_report_ajax_url = "{{ route('data_report.index',['serviceVersionId'=>$serviceVersionId]) }}";
            const data_report_table_id = "mlops-data-report-dtable";
            const dataReportDeleteUrl = "/data_report/"
            setTimeout(() => {
                Custom.initDataTable(data_report_table_id, data_report_ajax_url, dataReportColumns, dataReportFilterColumns, dataReportDeleteUrl, 0, 'desc')
            }, 200);
        }
    </script>

@endsection