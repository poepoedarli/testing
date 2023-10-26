@extends('service.mlops.index')
<style>
    .container {
        text-align: center;
    }

    .image-container {
        position: relative;
        display: inline-block;
    }

    .text-top-left,
    .text-top-right,
    .text-bottom-left,
    .text-bottom-right {
        position: absolute;
        color: white;
        font-size: large;
        border-radius: 4px;
        width: 300px;
        height: 50px;
        background-color: #4c54bc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .text-top-left {

        top: 95px;
        left: -285px;
    }

    .text-top-right {
        top: 95px;
        right: -285px;
    }

    .text-bottom-left {
        bottom: 90px;
        left: -285px;
    }

    .text-bottom-right {
        bottom: 95px;
        right: -285px;
    }

    .red-divider {
        /*border-color: black;*/
        border: 2px black solid;
    }
</style>
@section('mlops-content')
    <div class="container" style="margin-top: 20px">
        <div class="image-container">
            <img alt="" src="/media/images/serviceSummary.png" width="400px" height="400px">
            <div class="text-top-left"><b>Total Time: {{$summary['totalTime']}}</b></div>
            <div class="text-top-right"><b>Memory: {{$versionInfo->memory_limit}}</b></div>
            <div class="text-bottom-left"><b>Visits: {{$summary['visits']}}</b></div>
            <div class="text-bottom-right"><b> CPU: {{$versionInfo->cpu_limit}} GPU: {{$versionInfo->gpu_limit}}
                </b></div>
        </div>
    </div>
    <hr class="red-divider">


    <div class="container" style="margin-top: 40px">
        @if($versionInfo['status'] == 1)
            <a class='btn btn-lg btn-primary' id='start_service_{{$versionInfo['id']}}'
               data-service-name=''
               onclick='startService({{$versionInfo['id']}})'
               title='Start Application'>Start</a>
        @else
            <a class='btn btn-lg btn-primary' id='stop_service_{{$versionInfo['id']}}'
               data-service-name=''
               onclick='stopService({{$versionInfo['id']}})'
               title='Stop Application'>Stop</a>
        @endif
        <a class='btn btn-lg btn-primary' id='stop_service_'
           data-service-name=''
           onclick='restartService({{$versionInfo['id']}})'
           title='Stop Application'>Restart</a>
    </div>

    <!-- Confirmation On Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1" aria-hidden="false" data-service-id="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-service" style="display: none">
                    <div class="service-id"></div>
                    <div class="confirm-type"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmService()">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function startService(id) {
            var serviceDiv = document.getElementById("start_service_" + id)
            var serviceName = serviceDiv.getAttribute('data-service-name');

            var modal = $('#serviceModal');
            modal.find('.modal-title').text('Start Application ' + serviceName);
            modal.find('.modal-body').text('Are you sure to start ' + serviceName + ' ?');
            modal.find('.modal-service .service-id').text(id);
            modal.find('.modal-service .confirm-type').text(2);
            modal.modal('show');
        }

        function stopService(id) {
            var serviceDiv = document.getElementById("stop_service_" + id)
            var serviceName = serviceDiv.getAttribute('data-service-name');
            var modal = $('#serviceModal');
            modal.find('.modal-title').text('Stop Application ' + serviceName);
            modal.find('.modal-body').text('Are you sure to stop ' + serviceName + ' ?');
            modal.find('.modal-service .service-id').text(id);
            modal.find('.modal-service .confirm-type').text(1);
            modal.modal('show');
        }


        function confirmService() {
            var modal = $('#serviceModal');
            var id = modal.find('.modal-service .service-id').text();
            var confirmType = modal.find('.modal-service .confirm-type').text();
            if (confirmType == 4) {
                location.reload()
            }

            modal.modal('hide');
            let token = $("meta[name='csrf-token']").attr("content");
            $.post({
                url: '/service/confirm',
                type: 'POST',
                DataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': "application/json"
                },
                data: {
                    "_token": token,
                    "id": id,
                    "confirmType": confirmType,
                },
                success: function (response) {
                    location.reload()
                }
            });

        }

        function restartService(id) {
            var serviceDiv = document.getElementById("stop_service_" + id)
            var serviceName = serviceDiv.getAttribute('data-service-name');
            var modal = $('#serviceModal');
            modal.find('.modal-title').text('Restart Application ' + serviceName);
            modal.find('.modal-body').text('Are you sure to restart ' + serviceName + ' ?');
            modal.find('.modal-service .service-id').text(id);
            modal.find('.modal-service .confirm-type').text(4);
            modal.modal('show');
        }
    </script>
@endsection