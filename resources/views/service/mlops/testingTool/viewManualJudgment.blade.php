@extends('service.mlops.testingTool.index')

@section('testing-tool-content')
    <div class="block block-rounded" style="margin-left: -20px">
        <div class="block-content block-content-full pt-0">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
            <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter "
                   id="mlops-data-manual-judgment-dtable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Dataset ID</th>
                    <th>Raw Data ID</th>
                    <th>Part Ref. No.</th>
                    <th>Image</th>
                    <th>Result</th>
                    <th>Code</th>
{{--                    <th>Action</th>--}}
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="editDataReportModal" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Manual Judgment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="data-report-edit-form">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">manual_result</span>
                            <select class="form-control" name="manual_result" id="report-manual-result"
                                    aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" required>
                                <option value="G">G</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>

                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">manual_code</span>
                            <input type="text" name="manual_code" id="report-manual-code" class="form-control"
                                   aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm" required>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">remarks</span>
                            <input type="text" name="remarks" id="report-remarks" class="form-control"
                                   aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group">
                                <img alt="" id="report-manual-image" width="auto" height="200">
                            </div>
                        </div>
                        <input type="hidden" name="id" id="report-id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="subDataReport()">Confirm</button>
                </div>
            </div>
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
                    width: "10px",
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
                    data: 'result',
                    name: 'ai_result',
                },
                {
                    data: 'code',
                    name: 'code',
                },
                // {
                //     data: 'actions',
                //     name: 'actions',
                //     class: 'notexport',
                //     orderable: false,
                //     searchable: false
                // }
            ];
            const dataReportFilterColumns = {"inputs": ["ID"]};
            const data_report_ajax_url = "{{ route('manual_judgment.index',['serviceVersionId'=>$serviceVersionId]) }}";
            const data_report_table_id = "mlops-data-manual-judgment-dtable";
            const dataReportDeleteUrl = "/data_report/"
            setTimeout(() => {
                Custom.initDataTable(data_report_table_id, data_report_ajax_url, dataReportColumns, dataReportFilterColumns, dataReportDeleteUrl, 0, 'desc')
            }, 200);
        }

        function editReportModel(id) {
            var reportInfo = document.getElementById("edit_data_report_" + id);
            var result = reportInfo.getAttribute("data-report-result")
            var code = reportInfo.getAttribute("data-report-code")
            var remarks = reportInfo.getAttribute("data-report-remarks")
            var imgPath = reportInfo.getAttribute("data-report-image")
            var reportRemarks = document.getElementById("report-remarks")
            reportRemarks.value = remarks
            var reportManualCode = document.getElementById("report-manual-code")
            reportManualCode.value = code
            var reportManualResult = document.getElementById("report-manual-result")
            reportManualResult.value = result
            var reportId = document.getElementById("report-id")
            reportId.value = id
            var reportManualImage = document.getElementById("report-manual-image")
            reportManualImage.src = imgPath

            var modal = $('#editDataReportModal');
            modal.modal('show');
        }


        function subDataReport() {
            let token = $("meta[name='csrf-token']").attr("content");
            var form = document.getElementById("data-report-edit-form");
            if (form.checkValidity() === false) {
                form.classList.add('was-validated');
            } else {
                var formData = new FormData(form);
                formData.append("_token", token)
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "/data_report/update", true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        location.reload();
                    }
                };
                xhr.send(formData);
                var modal = $('#editDataReportModal');
                modal.modal('hide');
            }
        }
    </script>

@endsection