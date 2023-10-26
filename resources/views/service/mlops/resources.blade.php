@extends('service.mlops.index')
<!-- Echart lib -->
<script src="{{ asset('js/lib/echarts-5.3.1.min.js') }} "></script>

@section('mlops-content')
    {{-- Bar Chart --}}
    <div class="block block-rounded">

        <div class="block-content block-content-full pt-4">
            <div class="row text-center">
                <div class="col-12 col-md-12">
                    <div id="service_resources_chart_container"
                         style="height: 450px; border: 1px solid rgb(194, 191, 191); width: 100%" class="py-4"></div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(function () {
            getResources();
        });

        function getResources() {

            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: '/resources/list?serviceVersionId={{$serviceVersionId}}',
                type: 'GET',
                DataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': "application/json"
                },
                data: {
                    "_token": token,
                },
                success: function (response) {

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
                                data: response.logAt,
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
                                data: response.cpu
                            },
                            {
                                name: 'GPU',
                                type: 'bar',
                                tooltip: {
                                    valueFormatter: function (value) {
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
                                    valueFormatter: function (value) {
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
            });
        }
    </script>

@endsection