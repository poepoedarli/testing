@extends('applications.management.index')
@section('application-management-content')
    <div class="block block-rounded block-bordered h-100">
        <div class="block-content block-content-full">
            <div class="container-info">
                <div class="container">
                    <div class="text-top-left">
                        <span>
                            Total Time: 35 minutes
                        </span>
                    </div>
                    <div class="text-top-right">
                        <span>
                            Memory: 4GB
                        </span>
                    </div>
                    <div class="text-bottom-left">
                        <span>
                            Visits: 6
                        </span>
                    </div>
                    <div class="text-bottom-right">
                        <span>
                            CPU: 2 GPU: 1
                        </span>
                    </div>
                </div>
                <img alt="" src="/media/images/serviceSummary.png" width="150px" height="150px">
            </div>
        </div>
        <div
            class="block-content block-content-full block-content-sm bg-body-light fs-sm d-flex justify-content-between p-1">

            @php
                $state_class = 'text-success';
                $start_disabled = $stop_disabled = $restart_disabled = '';
                switch ($application->state) {
                    case 'stopped':
                        $state_class = 'text-danger';
                        $stop_disabled = 'disabled';
                        break;
                    case 'restarting':
                        $state_class = 'text-warning';
                        $start_disabled = $stop_disabled = $restart_disabled = 'disabled';
                        break;
                    case 'running':
                    default:
                        $start_disabled = 'disabled';
                        break;
                }
            @endphp
            <div class="btn btm-sm pe-none">
                <span class="text-muted">Application State:</span>
                <span class="fw-semibold {{ $state_class }}">{{ ucwords($application->state) }}</span>
            </div>
            @if (Auth()->user()->can('application-control'))
                <div class="d-flex align-items-center">
                    <a class="btn btn-sm btn-success text-white w-10 {{ $start_disabled }} me-2" title="Start">
                        <i class="fa fa-play me-2"></i> Start
                    </a>
                    <a class="btn btn-sm btn-danger w-10 {{ $stop_disabled }} me-2" title="Stop">
                        <i class="fa fa-stop me-2"></i> Stop
                    </a>
                    <a class="btn btn-sm btn-primary w-10 {{ $restart_disabled }} me-2" title="Restart">
                        <i class="fa fa-rotate-left me-2"></i> Restart
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="block block-rounded block-bordered block-link-shadow h-100">
        <div class="block-content block-content-full">
            <div class="row text-center">
                <div class="col-12 col-md-12">
                    <div id="application_resources_chart_container"
                        style="height: 450px; border: 1px solid rgb(194, 191, 191); width: 100%" class="py-4"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            loadChart({
                "cpu": [],
                "gpu": [],
                "memory": [],
                "logAt": []
            });
        });

        function getResources() {
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: '',
                type: 'GET',
                DataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': "application/json"
                },
                data: {
                    "_token": token,
                },
                success: function(response) {
                    response = {
                        "cpu": [],
                        "gpu": [],
                        "memory": [],
                        "logAt": []
                    };
                }
            });
        }

        function loadChart(response) {
            //prepare chart
            let pc_chart_container = document.getElementById('application_resources_chart_container');
            serviceRescourcesChart = echarts.init(pc_chart_container, null, {
                renderer: 'canvas',
                useDirtyRect: false
            });

            serviceRescourcesChartOption = {
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'cross',
                        crossStyle: {
                            color: '#999'
                        }
                    }
                },
                toolbox: {
                    feature: {
                        dataView: {
                            show: true,
                            readOnly: false
                        },
                        magicType: {
                            show: true,
                            type: ['line', 'bar']
                        },
                        restore: {
                            show: true
                        },
                        saveAsImage: {
                            show: true
                        }
                    }
                },
                legend: {
                    data: ['CPU', 'GPU', 'Memory']
                },
                xAxis: [{
                    type: 'category',
                    data: response.logAt,
                    axisPointer: {
                        type: 'shadow'
                    }
                }],
                yAxis: [{
                        type: 'value',
                        name: 'CPU',
                        min: 0,
                        max: 100,
                        interval: 10,
                        axisLabel: {
                            formatter: '{value} %'
                        }
                    },
                    {
                        type: 'value',
                        name: 'GPU',
                        min: 0,
                        max: 100,
                        interval: 10,
                        axisLabel: {
                            formatter: '{value} %'
                        }
                    }
                ],
                series: [{
                        name: 'CPU',
                        type: 'bar',
                        tooltip: {
                            valueFormatter: function(value) {
                                return value + ' %';
                            }
                        },
                        data: response.cpu
                    },
                    {
                        name: 'GPU',
                        type: 'bar',
                        tooltip: {
                            valueFormatter: function(value) {
                                return value + ' %';
                            }
                        },
                        data: response.gpu
                    },
                    {
                        name: 'Memory',
                        type: 'bar',
                        yAxisIndex: 1,
                        tooltip: {
                            valueFormatter: function(value) {
                                return value + ' %';
                            }
                        },
                        data: response.memory
                    }
                ]
            };


            if (serviceRescourcesChartOption && typeof serviceRescourcesChartOption === 'object') {
                serviceRescourcesChart.setOption(serviceRescourcesChartOption);
                window.activeCharts['total_chart'] = serviceRescourcesChart
                window.addEventListener('resize', serviceRescourcesChart.resize)
            }
        }
    </script>

    <style>
        .container-info {
            width: 75vmin;
            margin: auto;
            text-align: center;
        }

        .container-info>img {
            margin-top: -33%;
        }

        .container-info>div {
            height: 20vmin;
            position: relative;
        }


        .text-top-left,
        .text-top-right,
        .text-bottom-left,
        .text-bottom-right {
            position: absolute;
            color: #FFFFFF;
            background-color: #4c54bc;
            font-weight: bold;
            border-radius: 4px;
            height: 5vmin;
            width: 35vmin;
            min-width: 35vmin;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .text-top-left {
            top: 0.5rem;
            left: -4rem;
        }

        .text-top-right {
            top: 0.5rem;
            right: -4rem;
        }

        .text-bottom-left {
            bottom: 0.5rem;
            left: -4rem;
        }

        .text-bottom-right {
            bottom: 0.5rem;
            right: -4rem;
        }
    </style>
@endsection
