@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
@endsection

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title text-primary"><i class="fa fa-dice-d6 me-1"></i>My Projects</h3>
        </div>
        <div class="block-content block-content-full p-2">
            @component('components.message')
                <!-- show error messages  -->
            @endcomponent
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                        aria-controls="home" aria-selected="true">My Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                        aria-controls="profile" aria-selected="false">Managed by Innowave</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row d-flex justify-content-center">
                        @foreach ($applications as $application)
                            <div class="col-11 p-4 ">
                                @php
                                    $block_div_class = 'bg-xmodern';
                                    
                                    if ($application->state == 'running') {
                                        $status_icon = '<span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Running" class="text-success"><i class="far fa-circle-check"></i></span>';
                                    } elseif ($application->state == 'stopped') {
                                        $status_icon = '<span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Stopped" class="text-danger"><i class="far fa-circle-stop"></i></span>';
                                    } elseif ($application->state == 'restarting') {
                                        $status_icon = '<span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Restarting" class="text-warning"><i class="fa fa-sync fa-spin"></i></span>';
                                    } else {
                                        $block_div_class = 'pe-none user-select-none bg-gray';
                                        $status_icon = '<span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Creating" class="text-primary"><i class="far fa-hourglass-half fa-spin "></i></span>';
                                    }
                                @endphp

                                <div class="block block-rounded block-link-shadow h-100 mb-0 {{ $block_div_class }}"
                                    id="block-div-{{ $application->id }}">
                                    <div class="row g-0  pt-1">
                                        <div class="col col-md-7 col-lg-7 d-flex align-items-top bg-white">
                                            <div class="block block-themed mb-0">
                                                <div class="block-header" style="background: #ffffff !important; ">
                                                    <a href="{{ route('applications.resources', $application->id) }}">
                                                        <button type="button" class="btn btn-sm btn-outline-primary  me-2"
                                                            data-bs-toggle="tooltip" title="View Application">
                                                            <i class="si si-settings"></i>
                                                        </button>
                                                    </a>
                                                    <h3 class="block-title  d-flex flex-left">
                                                        <a class=" fw-semibold me-2"
                                                            href="{{ route('applications.summary', $application->id) }}"
                                                            data-bs-toggle="tooltip" title="View Application">
                                                            {{ $application->name }}
                                                        </a>

                                                        <div id="status-icon-{{ $application->id }}">
                                                            {!! $status_icon !!}
                                                        </div>

                                                    </h3>
                                                </div>
                                                <div class="block-content">

                                                    <div class="block-content block-content-full p-0 mb-2">
                                                        <p class="mb-3 text-left">
                                                            @if (strlen($application->short_description) > 100)
                                                                {!! substr($application->short_description, 0, 100) !!} <a
                                                                    href="{{ route('applications.summary', $application->id) }}">Read
                                                                    More ... </a>
                                                            @else
                                                                {!! $application->short_description !!}
                                                            @endif
                                                        </p>

                                                        <div id="state-control-div-{{ $application->id }}">
                                                            @if (Auth()->user()->can('application-control'))
                                                                @component('myapps/components/state_controls')
                                                                    @slot('application')
                                                                        @json($application)
                                                                    @endslot
                                                                @endcomponent
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col col-md-5 col-lg-5 align-items-top bg-white">
                                            <div class="block mb-0">
                                                <div class="block-header text-center"
                                                    style="background: #ffffff   !important">
                                                    <h3 class="block-title">
                                                        <button type="button" class="btn-block-option pe-none d-none">
                                                            <i class="fa fa-microchip text-muted"></i>
                                                        </button>
                                                        Resources Usage
                                                    </h3>
                                                    <div class="block-options">

                                                    </div>
                                                </div>
                                                <div class="block-content block-content-full" id="resource-usages-div-{{ $application->id }}">
                                                    @component('myapps/components/resource_usages')
                                                        @slot('application')
                                                            @json($application)
                                                        @endslot
                                                        @slot('resource_usages')
                                                            @json($application->resource_usages)
                                                        @endslot
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    <div class="row d-flex justify-content-center">
                        <!-- CDSEM for Demo !-->
                        <div class="col-11 p-4 ">
                            <div class="block block-rounded block-link-shadow h-100 mb-0 bg-xmodern">
                                <div class="row g-0 pt-1">
                                    <div class="col col-md-7 col-lg-7 d-flex align-items-top bg-white">
                                        <div class="block block-themed mb-0">
                                            <div class="block-header" style="background: #ffffff !important; ">
                                                <a href="http://52.237.90.112:8081" rel="noopener">
                                                    <button type="button" class="btn btn-sm btn-outline-primary  me-2"
                                                        data-bs-toggle="tooltip" title="View Application">
                                                        <i class="fa fa-arrow-up-right-from-square"></i>
                                                    </button>
                                                </a>
                                                <h3 class="block-title d-flex flex-left">
                                                    <a class="fw-semibold me-2" href="http://52.237.90.112:8081"
                                                        rel="noopener" data-bs-toggle="tooltip" title="View Application">
                                                        CDSEM <span data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Running" class="text-success"><i
                                                                class="far fa-circle-check"></i></span>
                                                    </a>
                                                </h3>
                                            </div>
                                            <div class="block-content">
                                                <div class="block-content block-content-full p-0 mb-2">
                                                    <p class="mb-3 text-left">
                                                        A Critical Dimension SEM (CD-SEM: Critical Dimension Scanning
                                                        Electron
                                                        Microscope) is a dedicated system for measuring the dimensions
                                                        of the fine
                                                        patterns formed on a semiconductor wafer. CD-SEM is mainly used
                                                        in the
                                                        manufacturing lines of electronic devices of semiconductors.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col col-md-5 col-lg-5 align-items-top bg-white">
                                        <div class="block m-2">
                                            <div class="block-content block-content-full p-0 ">
                                                <div class="row">
                                                    <div
                                                        class="col overflow-hidden d-flex align-items-center img-fluid-100">
                                                        <a href="http://52.237.90.112:8081" rel="noopener">
                                                            <img alt="" class="img-fluid img-link"
                                                                src="{{ asset('media/images/cdsem.jpg') }}"
                                                                alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RECC for Demo !-->
                        <div class="col-11 p-4 ">
                            <div class="block block-rounded block-link-shadow h-100 mb-0 bg-xmodern">
                                <div class="row g-0 pt-1">
                                    <div class="col col-md-7 col-lg-7 d-flex align-items-top bg-white">
                                        <div class="block block-themed mb-0">
                                            <div class="block-header" style="background: #ffffff !important; ">
                                                <a href="http://52.237.90.112:8083/testers-monitoring?prober-type=opus"
                                                    rel="noopener">
                                                    <button type="button" class="btn btn-sm btn-outline-primary  me-2"
                                                        data-bs-toggle="tooltip" title="Manage Application">
                                                        <i class="fa fa-arrow-up-right-from-square"></i>
                                                    </button>
                                                </a>
                                                <h3 class="block-title d-flex flex-left">
                                                    <a class="fw-semibold me-2"
                                                        href="http://52.237.90.112:8083/testers-monitoring?prober-type=opus"
                                                        rel="noopener" data-bs-toggle="tooltip"
                                                        title="View Application">
                                                        RECC <span data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Running" class="text-success"><i
                                                                class="far fa-circle-check"></i></span>
                                                    </a>
                                                </h3>
                                            </div>
                                            <div class="block-content">

                                                <div class="block-content block-content-full p-0 mb-2">
                                                    <p class="mb-3 text-left">
                                                        RECC (Remote Access Control) is a cutting-edge project designed
                                                        to empower
                                                        users with seamless and secure remote access to their devices
                                                        and systems.
                                                        With RECC, you can take control of your technology from
                                                        anywhere, ensuring
                                                        efficiency, convenience, and peace of mind. Say goodbye to
                                                        geographical
                                                        limitations and embrace the future of remote connectivity with
                                                        RECC.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col col-md-5 col-lg-5 align-items-top bg-white">
                                        <div class="block m-2">
                                            <div class="block-content block-content-full p-0 ">
                                                <div class="row">
                                                    <div
                                                        class="col overflow-hidden d-flex align-items-center img-fluid-100">
                                                        <a href="http://52.237.90.112:8083/testers-monitoring?prober-type=opus"
                                                            rel="noopener">
                                                            <img alt="" class="img-fluid img-link"
                                                                src="{{ asset('media/images/control-center.png') }}"
                                                                alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script type="text/javascript">
        $(function() {
            Dashmix.helpersOnLoad(['jq-easy-pie-chart']);
            appStateListener();
            appResourcesListener();
        });

        function appStateListener() {
            const channel3 = Echo.channel('application-state-changed');
            console.log(channel3)
            channel3.listen('ApplicationStateChanged', (data) => { //return TesterID and tester_info
                console.log('ApplicationStateChanged')
                console.log(data)
                let appID = data.applicationID
                let state = data.state

                //
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url: `ajax/applications/${appID}/load-state-control-component`,
                    type: 'POST',
                    DataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': "application/json"
                    },
                    data: {
                        "_token": token,
                    },
                    success: function(response) {
                        //control
                        $("#state-control-div-" + appID).html(response)

                        //state
                        let status_icon = '';
                        if (state == 'running') {
                            status_icon =
                                '<span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Running" class="text-success"><i class="far fa-circle-check"></i></span>';
                        } else if (state == 'stopped') {
                            status_icon =
                                '<span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Stopped" class="text-danger"><i class="far fa-circle-stop"></i></span>';
                        } else if (state == 'restarting') {
                            status_icon =
                                '<span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Restarting" class="text-warning"><i class="fa fa-sync fa-spin"></i></span>';
                        } else { // 
                            status_icon =
                                '<span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Creating" class="text-primary"><i class="far fa-hourglass-half fa-spin "></i></span>';
                        }

                        $("#status-icon-" + appID).html(status_icon)
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        console.error("Error: " + status, error);
                        console.log(xhr.responseJSON.message)
                    }
                });
            });
        }

        function appResourcesListener() {
            const channel5 = Echo.channel('application-resources-updated');
            console.log(channel5)
            channel5.listen('ApplicationResourcesUpdated', (data) => {
                console.log('ApplicationResourcesUpdated')
                console.log(data)
                const {
                    applicationID: appID,
                } = data;

                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url: `ajax/applications/${appID}/load-resource-usages-component`,
                    type: 'POST',
                    DataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': "application/json"
                    },
                    data: {
                        "_token": token,
                    },
                    success: function(response) {
                        $("#resource-usages-div-" + appID).html(response)
                        Dashmix.helpersOnLoad(['jq-easy-pie-chart']);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        console.error("Error: " + status, error);
                        console.log(xhr.responseJSON.message)
                    }
                });
            });
        }
    </script>
@endsection
