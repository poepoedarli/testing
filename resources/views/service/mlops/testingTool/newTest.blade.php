@extends('service.mlops.testingTool.index')

@section('testing-tool-content')
    <div class="block block-rounded">
        <div class="block-header block-header-default " style="background-color: white">
            <h3 class="block-title">
                <div class="d-flex" style="float:right">
                    <a class="btn btn-sm btn-secondary text-white"
                       onclick="addDataJob()"> <i
                                class="fa fa-plus me-1"></i>Add a Task</a>
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
                    <th>Dataset ID</th>
                    <th>Ref. No.</th>
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

    <div class="modal fade" id="addDataJobModal" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add a Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="data-job-insert-form">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Dataset</span>
                            <select class="form-control" name="data_set_id" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" required>
                                @foreach($dataSets as $key=>$value)
                                    {
                                    <option value="{{$key}}">{{$value}}</option>
                                    }
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Ref. N0.</span>
                            <input type="text" name="ref_no" class="form-control" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm" required>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Remarks</span>
                            <input type="text" name="remarks" class="form-control" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm">
                        </div>

                        <input type="hidden" name="service_version_id" value="{{$serviceVersionId}}">
                        <input type="hidden" name="operation_mode" value="1">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="subDataJob()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var table;
        $(function () {
            getDataJob()
        })

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
                    data: 'ref_no',
                    name: 'ref_no',
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
                    width: '100px',
                    class: 'notexport',
                    orderable: false,
                    searchable: false
                },
            ];
            const dataJobFilterColumns = {"inputs": ["ID"]};
            const data_job_ajax_url = "{{ route('data_set_job.index',['serviceVersionId'=>$serviceVersionId]) }}";
            const data_job_table_id = "mlops-data-job-dtable";
            const dataJobDeleteUrl = "/data_job/"
            setTimeout(() => {
                Custom.initDataTable(data_job_table_id, data_job_ajax_url, dataJobColumns, dataJobFilterColumns, dataJobDeleteUrl, 0, 'desc')
            }, 200);
        }


        function addDataJob() {
            var modal = $('#addDataJobModal');
            modal.modal('show');
        }

        function subDataJob() {
            let token = $("meta[name='csrf-token']").attr("content");
            var form = document.getElementById("data-job-insert-form");
            if (form.checkValidity() === false) {
                form.classList.add('was-validated');
            } else {
                var formData = new FormData(form);
                formData.append("_token", token)
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "/data_set_job/store", true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        location.reload();
                    }
                };
                xhr.send(formData);
                var modal = $('#addDataJobModal');
                modal.modal('hide');
            }
        }

    </script>

@endsection