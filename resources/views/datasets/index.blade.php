@extends('layouts.backend')

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title text-primary"><i class="fa fa-database me-1"></i>Dataset Management
                <div class="d-flex" style="float:right">
                    @if (Auth::user()->can('dataset-create'))
                    <a class="btn btn-sm btn-primary text-white" href="{{ route('datasets.create') }}"> <i class="fa fa-plus me-1"></i> Create Dataset</a>
                    @endif
                </div>
            </h3>
        </div>
        <div class="block-content block-content-full">
            @component('components.message')
                <!-- show alert message  -->
            @endcomponent
            <h2 class="content-heading py-2 mb-3">
                <i class="fa fa-briefcase text-muted me-1"></i> Your Department Datasets
            </h2>
            <div class="block block-rounded">
                @foreach ($departmentDatasets as $dataset)
                    <x-dataset_list :dataset="$dataset"/>  
                @endforeach
            </div>


            <h2 class="content-heading py-2 mb-3">
                <i class="fa fa-briefcase text-muted me-1"></i> Other Department Datasets
            </h2>
            <div class="block block-rounded">
                @foreach ($otherDepartmentDatasets as $dataset)
                    <x-dataset_list :dataset="$dataset"/>  
                @endforeach
            </div>
        </div>
    </div>
        
    <script type="text/javascript">
        var table;
        $(function () {
            
        })



        function addDataSet() {
            var modal = $('#addDataSetModal');
            modal.modal('show');
        }

        function subDataSet() {
            let token = $("meta[name='csrf-token']").attr("content");
            var form = document.getElementById("data-set-insert-form");

            if (form.checkValidity() === false) {
                form.classList.add('was-validated');
            } else {
                var formData = new FormData(form);
                formData.append("_token", token)
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "/data_set/store", true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        location.reload();
                    }
                };
                xhr.send(formData);
                var modal = $('#addDataSetModal');
                modal.modal('hide');
            }

        }

        function delDataSetModel(id) {

            var modal = $('#delDataSetModal');
            modal.find('.modal-title').text('Delete Data');
            modal.find('.modal-body').text('Are you sure to delete this data ?');
            modal.find('.modal-report .primary-key-id').text(id);
            modal.modal('show');
        }

        function delDataSet() {
            var modal = $('#delDataSetModal');
            var id = modal.find('.modal-report .primary-key-id').text();
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: '/data_set/destroy',
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


        function datasetTraining() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var checkedData = [];
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checkedData.push(checkboxes[i].value);
                }
            }
            if (checkedData.length <= 0) {
                alert("please check the dataset in the list")
                return
            }
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: '/ajax/data_set_training/store',
                type: 'POST',
                DataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': "application/json"
                },
                data: {
                    "_token": token,
                    "dataSetIds": checkedData
                },
                success: function (response) {
                    var modal = $('#selection-service');
                    modal.modal('hide');
                }
            });
        }

        function selectionService() {
            var modal = $('#selection-service');
            modal.modal('show');
        }
    </script>
@endsection