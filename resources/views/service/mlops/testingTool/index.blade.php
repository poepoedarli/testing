@extends('service.mlops.index')
@section('mlops-content')
    <div class="row" style="margin-top: 20px">
        <div class="tab-content">
            @yield('testing-tool-content')
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

    <script>
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
            if (delType == 1) {
                url = '/data_set/destroy'
            } else {
                url = '/data_set_job/destroy'
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
                    location.reload();
                }

            });
            modal.modal('hide');
        }
    </script>
@endsection