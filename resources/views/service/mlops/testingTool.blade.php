@extends('service.mlops.index')

@section('mlops-content')
    <div class="row" style="margin-top: 20px">
        <div class="col-md-2">
            <ul class="nav nav-pills flex-column" id="nestedTabs">
                <li class="nav-item">
                    <button class="nav-link active" id="nested-tab2-tab" data-bs-toggle="tab"
                            data-bs-target="#nested-tab2" type="button" role="tab"
                            aria-controls="nested-tab2"
                            aria-selected="true">Dataset
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="nested-tab3-tab" data-bs-toggle="tab"
                            data-bs-target="#nested-tab3" type="button" role="tab"
                            aria-controls="nested-tab3"
                            aria-selected="true">New Test
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" id="nested-tab4-tab" data-bs-toggle="tab"
                            data-bs-target="#nested-tab4" type="button" role="tab"
                            aria-controls="nested-tab4"
                            aria-selected="true">Manual Judgment
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" id="nested-tab1-tab" data-bs-toggle="tab"
                            data-bs-target="#nested-tab1" type="button" role="tab"
                            aria-controls="nested-tab1"
                            aria-selected="true">Report
                    </button>
                </li>


            </ul>
        </div>
        <div class="tab-content col-md-10">
            <div class="tab-pane fade" id="nested-tab1" role="tabpanel"
                 aria-labelledby="nested-tab1-tab">
                <div class="block block-rounded">
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
                                <th>Dataset Id</th>
                                <th>Part Ref. No.</th>
                                <th>Img</th>
                                <th>Ai Result</th>
                                <th>Ai Code</th>
                                <th>Manual Result</th>
                                <th>Manual Code</th>
                                <th>Remarks</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nested-tab4" role="tabpanel"
                 aria-labelledby="nested-tab4-tab">
                <div class="block block-rounded">
                    <div class="block-content block-content-full pt-0">
                        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                        <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter "
                               id="mlops-data-manual-judgment-dtable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Job Id</th>
                                <th>Dataset Id</th>
                                <th>Part Ref. No.</th>
                                <th>Img</th>
                                <th>Ai Result</th>
                                <th>Ai Code</th>
                                <th>Manual Result</th>
                                <th>Manual Code</th>
                                <th>Remarks</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nested-tab2" role="tabpanel"
                 aria-labelledby="nested-tab2-tab">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            <div class="d-flex" style="float:right">
                                <a class="btn btn-sm btn-secondary text-white"
                                   onclick="addDataSet()"> <i
                                            class="fa fa-plus me-1"></i>Add Dataset</a>
                            </div>
                        </h3>

                    </div>
                    <div class="block-content block-content-full pt-0">

                        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                        <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter "
                               id="mlops-data-set-dtable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Department</th>
                                <th>Part Name</th>
                                <th>Lot Id</th>
                                <th>Ref. No.</th>
                                <th>Img</th>
                                <th>Remarks</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nested-tab3" role="tabpanel"
                 aria-labelledby="nested-tab3-tab">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            <div class="d-flex" style="float:right">
                                <a class="btn btn-sm btn-secondary text-white"
                                   onclick="addDataJob()"> <i
                                            class="fa fa-plus me-1"></i>Add Data Job</a>
                            </div>
                        </h3>

                    </div>
                    <div class="block-content block-content-full pt-0">

                        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                        <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter "
                               id="mlops-data-job-dtable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Dataset Id</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="addDataSetModal" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Dataset</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="data-set-insert-form">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">custom</span>
                            <select class="form-control" name="user_id" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm">
                                @foreach($customs as $key=>$value)
                                    {
                                    <option value="{{$key}}">{{$value}}</option>
                                    }
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">department</span>
                            <input type="text" name="department" class="form-control"
                                   aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">part_name</span>
                            <input type="text" name="part_name" class="form-control"
                                   aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">lot_id</span>
                            <input type="text" name="lot_id" class="form-control" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm" required>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">ref_no</span>
                            <input type="text" name="ref_no" class="form-control" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">remarks</span>
                            <input type="text" name="remarks" class="form-control" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <input type="hidden" name="service_version_id" value="{{$id}}">
                        <div class="input-group input-group-sm mb-3">
                            {{--                            <span class="input-group-text" id="inputGroup-sizing-sm">img</span>--}}
                            <input type="file" class="form-control" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm" name="img_path"
                                   accept="image/*" id="data-set-input">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group">
                                <img alt="" id="data-set-image" width="auto" height="100">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="subDataSet()">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delReportModal" tabindex="-1" aria-hidden="false" data-service-id="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-report" style="display: none">
                    <div class="primary-key-id"></div>
                    <div class="del-type"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="delReport()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addDataJobModal" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Data Job</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="data-job-insert-form">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">data_set</span>
                            <select class="form-control" name="data_set_id" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm">
                                @foreach($dataSets as $key=>$value)
                                    {
                                    <option value="{{$key}}">{{$value}}</option>
                                    }
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">ref_no</span>
                            <input type="text" name="ref_no" class="form-control" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">remarks</span>
                            <input type="text" name="remarks" class="form-control" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm">
                        </div>

                        <input type="hidden" name="service_version_id" value="{{$id}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="subDataJob()">Confirm</button>
                </div>
            </div>
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
                                   aria-describedby="inputGroup-sizing-sm" required>
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
            getDataSet()
            getDataJob()
            getDataReport()
            getDataManualJudgment()
            $('#data-set-input').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#data-set-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });

        function getDataSet() {
            const dataSetColumns = [
                {
                    data: 'id',
                    name: 'id',
                    width: "50px",
                },
                {
                    data: 'department',
                    name: 'department',
                },
                {
                    data: 'part_name',
                    name: 'part_name',
                },
                {
                    data: 'lot_id',
                    name: 'lot_id',
                },
                {
                    data: 'ref_no',
                    name: 'ref_no',
                },
                {
                    data: 'img_path',
                    name: 'img_path',
                    orderable: false,
                    searchable: false,
                    width: '5%',
                    class: 'text-center',
                },
                {
                    data: 'remarks',
                    name: 'remarks'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    width: '80px',
                    class: 'notexport',
                    orderable: false,
                    searchable: false
                },
            ];
            const dataSetFilterColumns = {"inputs": ["ID"]};
            const data_set_ajax_url = "{{ route('data_set.index') }}";
            const data_set_table_id = "mlops-data-set-dtable";
            const dataSetDeleteUrl = "/data_set/"
            setTimeout(() => {
                Custom.initDataTable(data_set_table_id, data_set_ajax_url, dataSetColumns, dataSetFilterColumns, dataSetDeleteUrl, 0, 'desc')
            }, 200);
        }

        function getDataJob() {
            const dataJobColumns = [
                {
                    data: 'id',
                    name: 'id',
                    width: "50px",
                },
                {
                    data: 'data_set_id',
                    name: 'data_set_id',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'remarks',
                    name: 'remarks'
                },
                {
                    data: 'start_time',
                    name: 'start_time'
                },
                {
                    data: 'end_time',
                    name: 'end_time'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    width: '60px',
                    class: 'notexport',
                    orderable: false,
                    searchable: false
                },
            ];
            const dataJobFilterColumns = {"inputs": ["ID"]};
            const data_job_ajax_url = "{{ route('data_set_job.index') }}";
            const data_job_table_id = "mlops-data-job-dtable";
            const dataJobDeleteUrl = "/data_job/"
            setTimeout(() => {
                Custom.initDataTable(data_job_table_id, data_job_ajax_url, dataJobColumns, dataJobFilterColumns, dataJobDeleteUrl, 0, 'desc')
            }, 200);
        }

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
                {
                    data: 'remarks',
                    name: 'remarks'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },

            ];
            const dataReportFilterColumns = {"inputs": ["ID"]};
            const data_report_ajax_url = "{{ route('data_report.index') }}";
            const data_report_table_id = "mlops-data-report-dtable";
            const dataReportDeleteUrl = "/data_report/"
            setTimeout(() => {
                Custom.initDataTable(data_report_table_id, data_report_ajax_url, dataReportColumns, dataReportFilterColumns, dataReportDeleteUrl, 0, 'desc')
            }, 200);
        }

        function getDataManualJudgment() {

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
                {
                    data: 'remarks',
                    name: 'remarks'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    width: '60px',
                    class: 'notexport',
                    orderable: false,
                    searchable: false
                }
            ];
            const dataReportFilterColumns = {"inputs": ["ID"]};
            const data_report_ajax_url = "{{ route('data_report.index') }}";
            const data_report_table_id = "mlops-data-manual-judgment-dtable";
            const dataReportDeleteUrl = "/data_report/"
            setTimeout(() => {
                Custom.initDataTable(data_report_table_id, data_report_ajax_url, dataReportColumns, dataReportFilterColumns, dataReportDeleteUrl, 0, 'desc')
            }, 200);
        }

        function addDataSet() {
            var modal = $('#addDataSetModal');
            modal.modal('show');
        }

        function subDataSet() {
            let token = $("meta[name='csrf-token']").attr("content");
            var form = document.getElementById("data-set-insert-form");
            var formData = new FormData(form);
            formData.append("_token", token)
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/data_set/store", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    getDataSet()
                }
            };
            xhr.send(formData);
            var modal = $('#addDataSetModal');
            modal.modal('hide');
        }

        function delReportModel(id, delType) {

            var modal = $('#delReportModal');
            modal.find('.modal-title').text('Delete Data');
            modal.find('.modal-body').text('Are you sure to delete this data ?');
            modal.find('.modal-report .primary-key-id').text(id);
            modal.find('.modal-report .del-type').text(delType);
            modal.modal('show');
        }

        function delReport() {
            var modal = $('#delReportModal');
            var id = modal.find('.modal-report .primary-key-id').text();
            var delType = modal.find('.modal-report .del-type').text();

            let token = $("meta[name='csrf-token']").attr("content");
            var url = ''
            if (delType === 1) {
                url = '/data_set/destroy'
            } else {
                url = '/data_job/destroy'
            }
            $.ajax({
                url: url,
                type: 'DELETE',
                DataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': "application/json"
                },
                data: {
                    "_token": token,
                    "id": id,
                },
                success: function (response) {

                }

            });
            modal.modal('hide');
        }


        function addDataJob() {
            var modal = $('#addDataJobModal');
            modal.modal('show');
        }

        function subDataJob() {
            let token = $("meta[name='csrf-token']").attr("content");
            var form = document.getElementById("data-job-insert-form");
            var formData = new FormData(form);
            formData.append("_token", token)
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/data_job/store", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    getDataJob()
                }
            };
            xhr.send(formData);
            var modal = $('#addDataJobModal');
            modal.modal('hide');
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
            var formData = new FormData(form);
            formData.append("_token", token)
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/data_report/update", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    getDataReport()
                }
            };
            xhr.send(formData);
            var modal = $('#editDataReportModal');
            modal.modal('hide');
        }
    </script>
@endsection