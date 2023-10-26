<div class="row items-push">
    <div class="block border">
        <div class="block-header justify-content-end">
            
            <a class="btn btn-sm btn-secondary" href="{{ route('adc_pcb.tasks', [$application->id]) }}">Back</a>
        </div>
        <div class="block-content block-content-full p-0">
            <div class="row">
                <div class="col-12">
                    <div id="report_chart_container" style="height:400px;"></div>
                </div>
            </div>
        </div>
    </div>

    @php
        $references = $parameters['references'];
    @endphp
    <div class="block">
        <div class="block-header justify-content-center">
            <h3>References</h3>
        </div>
        <div class="block-content block-content-full p-0">
            <div class="content">
                <div class="row items-push">
                    @foreach ($references as $value)
                        <div class="col-md-6 col-xl-6">
                            <div class="block block-rounded h-100 mb-0 border">
                                <div class="block-header">
                                    <div class="flex-grow-1 text-muted fs-md fw-semibold">
                                        <i class="fa fa-image me-1"></i> {{ $value['img_name'] }}
                                    </div>
                                </div>
                                <div class="block-content block-content-full bg-body-light">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <img alt="" class="img-fluid" id="ref{{ $value['id'] }}" loading="lazy" as='image' rel='preload'
                                                src="{{ env('FILE_SERVER_DOMAIN', 'https://wavelengthblob.file.core.windows.net/') . $value['img_path'] . env('FILE_SERVER_SECRET_KEY', '?sv=2022-11-02&st=2023-08-16T07%3A40%3A45Z&se=2024-08-17T07%3A40%3A00Z&sr=s&sp=rl&sig=bxUw7R9IYysOnDNYY%2Bak9pCTIB4qY1iNuMfBVHqVxUM%3D') }}" />
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <div class="fs-md fw-semibold">
                                                Labelled: {{ count($value['results']) - $value['nil'] }} /
                                                {{ count($value['results']) }}
                                            </div>
                                            <div class="fs-md fw-semibold">
                                                <table aria-describedby="mydesc" class="table">
                                                    <tr>
                                                        <th>TP</th>
                                                        <th>FP</th>
                                                        <th>TN</th>
                                                        <th>FN</th>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $value['tp'] }} %</td>
                                                        <td>{{ $value['fp'] }} %</td>
                                                        <td>{{ $value['tn'] }} %</td>
                                                        <td>{{ $value['fn'] }} %</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div>
                                                <a class="btn w-100 btn-alt-secondary"
                                                    href="{{ route('adc_pcb.manual_labelling', [$application->id, $parameters['task']->id, $value['id']]) }}">
                                                    <i class="fa fa-edit me-1 opacity-50"></i> Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var references = @json($parameters['references']);
    $(function() {
        console.log(references);
        loadPieChart()
    })

    function loadPieChart() {
        let report = @json($parameters['report']);
        console.log(report);
        const {
            total_references = 0, total_results = 0,
                tp = 0, fp = 0, tn = 0, fn = 0, nil = 0
        } = report;

        let colorPalette = [];
        let chartData = [];
        let legendData = [];

        let report_chart_container = document.getElementById('report_chart_container');

        reportChart = echarts.init(report_chart_container, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });

        if (tp > 0) {
            chartData.push({
                value: tp,
                name: 'True Positive'
            });
            legendData.push('True Positive');
            colorPalette.push('#4BB543');
        }
        if (fp > 0) {
            chartData.push({
                value: fp,
                name: 'False Positive'
            });
            legendData.push('False Positive');
            colorPalette.push('#FFFF00');
        }
        if (tn > 0) {
            chartData.push({
                value: tn,
                name: 'True Negative'
            });
            legendData.push('True Negative');
            colorPalette.push('#0000FF');
        }
        if (fn > 0) {
            chartData.push({
                value: fn,
                name: 'False Negative'
            });
            legendData.push('False Negative');
            colorPalette.push('#FF0000');
        }
        if (nil !== 0) {
            chartData.push({
                value: nil,
                name: 'Unlabelled'
            })
            legendData.push('Unlabelled');
            colorPalette.push('#808080');
        }

        let chartOption = {
            title: {
                text: 'Task Report',
                subtext: `References ${total_references}, Results ${total_results}`,
                left: 'center'
            },
            tooltip: {
                trigger: 'item',
                // formatter: '{a} <br/>{b}: {c} ({d}%)'
                formatter: '{b}: {c} ({d}%)'
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: legendData,
                formatter: name => {
                    var series = reportChart.getOption().series[0];
                    var value = series.data.filter(row => row.name === name)[0].value
                    var percentile = value/total_results * 100
                    return percentile.toFixed(2) + '%' + ' ' + name;
                },
            },
            series: [{
                name: 'Results',
                type: 'pie',
                label: {
                    show: false
                },
                labelLine: {
                    show: false
                },
                radius: '50%',
                data: chartData,
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }],
            color: colorPalette,
        };

        reportChart.setOption(chartOption);
        window.activeCharts['adc_pcb_report_chart'] = reportChart
        window.addEventListener('resize', reportChart.resize)
    }
</script>
