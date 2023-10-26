@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection

@section('js')
    <!-- Echart lib -->
    <script src="{{ asset('js/lib/echarts-5.3.1.min.js') }} "></script>
    
    <!-- Page JS Plugins -->

@endsection

@section('content')
<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title text-primary"><i class="fa fa-location-arrow me-2"></i>Dashboard

        </h3>
    </div>

    <div class="block-content block-content-full pt-4">
        <div class="row text-center">
            <div class="col-6 col-md-4">
                <div id="service_dashboard_chart_container" style="height: 400px;" class="py-4"></div>
            </div>
            <div class="col-6 col-md-8">
                <div id="service_resources_chart_container" style="height: 400px; width: 100%" class="py-4"></div>
            </div>
        </div>
    </div>

    <div class="block-content block-content-full pt-0">
        <ul id="myTab" class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link  active" href="#bulletin" role="tab"
                    data-toggle="pill">Recent
                    Activities</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#rule" role="tab"
                    data-toggle="pill">
                    Applications</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#forum" role="tab"
                    data-toggle="pill">Datasets</a>
            </li>
        </ul>
    </div>

    <div class="block-content block-content-full pt-0">
        <!-- 选项卡面板 -->
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active show" id="bulletin">
                <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter ">
                    <thead>
                        <th>Type</th>
                        <th>Activity</th>
                        <th>ID</th>
                        <th>Date and Time</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Applications</td>
                            <td>Model Testing</td>
                            <td>M0020</td>
                            <td>2023-08-21 11:20</td>
                        </tr>
                        <tr>
                            <td>MLOPS</td>
                            <td>Model Testing</td>
                            <td>M0020</td>
                            <td>2023-08-21 11:25</td>
                        </tr>
                        <tr>
                            <td>MLOPS</td>
                            <td>Manual Labelling</td>
                            <td>ML0037</td>
                            <td>2023-08-21 12:21</td>
                        </tr>
                        <tr>
                            <td>Dataset</td>
                            <td>Dataset Modified</td>
                            <td>DS12223</td>
                            <td>2023-08-21 11:45</td>
                        </tr>
                        <tr>
                            <td>Applications</td>
                            <td>Model Testing</td>
                            <td>M0019</td>
                            <td>2023-08-21 13:15</td>
                        </tr>
                        <tr>
                            <td>Dataset</td>
                            <td>Dataset Upload</td>
                            <td>DS1223</td>
                            <td>2023-08-21 15:20</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="rule">
                <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter ">
                    <thead>
                        <th>Metric</th>
                        <th>Value</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Applications Running</td>
                            <td>2</td>

                        </tr>
                        <tr>
                            <td>Applications Stopped</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Number Errors</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>CPU used by Applications</td>
                            <td>4</td>

                        </tr>
                        <tr>
                            <td>GPU used by Applications</td>
                            <td>6</td>

                        </tr>
                        <tr>
                            <td>Memory used by Applications</td>
                            <td>40</td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="forum">
                <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter ">
                    <thead>
                        <th>Metric</th>
                        <th>Value</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Number of Datasets</td>
                            <td>118</td>

                        </tr>
                        <tr>
                            <td>Number of Tags</td>
                            <td>16</td>

                        </tr>
                        <tr>
                            <td>CPU used by Datasets</td>
                            <td>23</td>

                        </tr>
                        <tr>
                            <td>GPU used by Datasets</td>
                            <td>34</td>

                        </tr>
                        <tr>
                            <td>Memory used by Datasets</td>
                            <td>21</td>

                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
        <script type="text/javascript">
            $(function () {
                getDashboard();
                getResources();

            });
            $("#myTab a").click(function (e) {
                e.preventDefault();
                $(this).tab("show");
            });

            function getDashboard() {
                let pc_chart_container = document.getElementById('service_dashboard_chart_container');
                serviceRescourcesChart = echarts.init(pc_chart_container, null, {
                    renderer: 'canvas',
                    useDirtyRect: false
                });
                const gaugeData = [
                    {
                        value: 35,
                        name: 'CPU',
                        title: {
                            offsetCenter: ['0%', '-30%']
                        },
                        detail: {
                            valueAnimation: true,
                            offsetCenter: ['0%', '-20%']
                        }
                    },
                    {
                        value: 40,
                        name: 'GPU',
                        title: {
                            offsetCenter: ['0%', '0%']
                        },
                        detail: {
                            valueAnimation: true,
                            offsetCenter: ['0%', '12%']
                        }
                    },
                    {
                        value: 54,
                        name: 'Memory',
                        title: {
                            offsetCenter: ['0%', '25%']
                        },
                        detail: {
                            valueAnimation: true,
                            offsetCenter: ['0%', '40%']
                        }
                    }
                ];
                var serviceRescourcesChartOption =
                    {

                        series: [
                            {
                                type: 'gauge',
                                startAngle: 90,
                                endAngle: -270,
                                pointer: {
                                    show: false
                                },
                                progress: {
                                    show: true,
                                    overlap: false,
                                    roundCap: true,
                                    clip: false,
                                    itemStyle: {
                                        borderWidth: 1,
                                        borderColor: '#464646'
                                    }
                                },
                                axisLine: {
                                    lineStyle: {
                                        width: 40
                                    }
                                },
                                splitLine: {
                                    show: false,
                                    distance: 0,
                                    length: 10
                                },
                                axisTick: {
                                    show: false
                                },
                                axisLabel: {
                                    show: false,
                                    distance: 50
                                },
                                data: gaugeData,
                                title: {
                                    fontSize: 10
                                },
                                detail: {
                                    width: 50,
                                    height: 8,
                                    fontSize: 10,
                                    color: 'inherit',
                                    borderColor: 'inherit',
                                    borderRadius: 20,
                                    borderWidth: 1,
                                    formatter: '{value}%'
                                }
                            }
                        ]
                    };
                setTimeout(function () {
                    gaugeData[0].value = +(Math.random() * 100).toFixed(2);
                    gaugeData[1].value = +(Math.random() * 100).toFixed(2);
                    gaugeData[2].value = +(Math.random() * 100).toFixed(2);
                    serviceRescourcesChart.setOption({
                        series: [
                            {
                                data: gaugeData,
                                pointer: {
                                    show: false
                                }
                            }
                        ]
                    });
                }, 0);

                if (serviceRescourcesChartOption && typeof serviceRescourcesChartOption === 'object') {
                    serviceRescourcesChart.setOption(serviceRescourcesChartOption);
                    window.activeCharts['total_chart'] = serviceRescourcesChart
                    window.addEventListener('resize', serviceRescourcesChart.resize)
                }
            }

            function getResources() {


                //prepare chart
                let pc_chart_container = document.getElementById('service_resources_chart_container');
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
                            dataView: {show: true, readOnly: false},
                            magicType: {show: true, type: ['line', 'bar']},
                            restore: {show: true},
                            saveAsImage: {show: true}
                        }
                    },
                    legend: {
                        data: ['CPU', 'GPU', 'Memory']
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: ["2023/09/16", "2023/09/17", "2023/09/18", "2023/09/19", "2023/09/20", "2023/09/21"],
                            axisPointer: {
                                type: 'shadow'
                            }
                        }
                    ],
                    yAxis: [
                        {
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
                    series: [
                        {
                            name: 'CPU',
                            type: 'bar',
                            tooltip: {
                                valueFormatter: function (value) {
                                    return value + ' %';
                                }
                            },
                            data: [25, 34, 42, 38, 58, 34]
                        },
                        {
                            name: 'GPU',
                            type: 'bar',
                            tooltip: {
                                valueFormatter: function (value) {
                                    return value + ' %';
                                }
                            },
                            data: [34, 51, 63, 40, 42, 38]
                        },
                        {
                            name: 'Memory',
                            type: 'bar',
                            yAxisIndex: 1,
                            tooltip: {
                                valueFormatter: function (value) {
                                    return value + ' %';
                                }
                            },
                            data: [65, 38, 48, 76, 39, 52]
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
@endsection
