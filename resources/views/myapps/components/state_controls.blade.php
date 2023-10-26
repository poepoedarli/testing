@php
    $application = json_decode($application);
@endphp

@if (!is_null($application))
    @php
        $id = $application->id;
        $state = $application->state;
        $under_state_changing = $application->under_state_changing;
        $disabled = ' ';
        if($under_state_changing == true) {
            $disabled = 'disabled';
        }
    @endphp

    @if ($state == 'running')
        <a class="btn {{$disabled}} action-control-btn btn-alt-danger" onclick="doAction({{$id}}, 'stop')" data-bs-toggle="tooltip" title="Stop">
            <i class="fa fa-stop {{$under_state_changing!='' && $under_state_changing=='stop' ? 'fa-spin' : ''}}" ></i>
        </a>
        <a class="btn {{$disabled}} action-control-btn btn-alt-primary" onclick="doAction({{$id}}, 'restart')" data-bs-toggle="tooltip" title="Restart">
            <i class="fa fa-refresh {{$under_state_changing!='' && $under_state_changing=='restart' ? 'fa-spin' : ''}}" ></i>
        </a>
    @elseif ($state == 'restarting')
        <a class="btn {{$disabled}} action-control-btn btn-alt-danger" onclick="doAction({{$id}}, 'stop')" data-bs-toggle="tooltip" title="Stop">
            <i class="fa fa-stop {{$under_state_changing!='' && $under_state_changing=='stop' ? 'fa-spin' : ''}}" ></i>
        </a>
        <a class="btn {{$disabled}} action-control-btn btn-alt-success" onclick="doAction({{$id}}, 'start')" data-bs-toggle="tooltip" title="Start">
            <i class="fa fa-play {{$under_state_changing!='' && $under_state_changing=='start' ? 'fa-spin' : ''}}" ></i>
        </a>
    @elseif ($state == 'stopped')
        <a class="btn {{$disabled}} action-control-btn btn-alt-success" onclick="doAction({{$id}}, 'start')" data-bs-toggle="tooltip" title="Start">
            <i class="fa fa-play {{$under_state_changing!='' && $under_state_changing=='start' ? 'fa-spin' : ''}}" ></i>
        </a>
    @else
        <a class="btn {{$disabled}} action-control-btn btn-alt-secondary" onclick="doAction({{$id}}, 'test')" data-bs-toggle="tooltip" title="">
            ...
        </a>
        <a class="btn {{$disabled}} action-control-btn btn-alt-secondary" onclick="doAction({{$id}}, 'test')" data-bs-toggle="tooltip" title="">
            ...
        </a>
    @endif
    
@endif

<script type="text/javascript">

    function doAction(id, action='start') {
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: `ajax/applications/${id}/${action}`,
            type: 'GET',
            DataType: 'json',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': "application/json"
            },
            success: function(response) {
                console.log(response);
            }
        })
    }
</script>