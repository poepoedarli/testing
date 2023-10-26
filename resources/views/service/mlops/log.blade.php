@extends('service.mlops.index')

@section('mlops-content')
    <div class="block block-rounded" style="margin-top: 20px">

        <div class="block-content block-content-full pt-0">
            <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter "
                   id="service-log-dtable">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Logged At</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Content</th>

                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        var table;
        $(function () {
            getServiceLog()
        })

        function getServiceLog() {
            const dtColumns =
                [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    width: '15px'
                },
                    {
                        data: 'log_at',
                        name: 'log_at',
                        width: '140px'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        width: '10%'
                    },
                    {
                        data: 'type-badge',
                        name: 'category',
                        width: '10%'
                    },
                    {
                        data: 'content',
                        name: 'content',
                        width: '50%'
                    }
                ];
            const log_types = JSON.parse('{!! json_encode( config("global.log_types")) !!}');
            const logTypeObj = {};
            for (const type of log_types) {
                logTypeObj[type] = type;
            }
            const filterColumns = {
                "inputs": ["Title", "Content", "Logged At"],
                "selects": {"Type": logTypeObj},
                "dates": []
            };//,
            const ajax_url = "{{ route('service_log.index', ['serviceVersionId'=>$serviceVersionId]) }}";
            const table_id = "service-log-dtable";
            const deleteUrl = "/service_log/"
            Custom.initDataTable(table_id, ajax_url, dtColumns, filterColumns, deleteUrl, 1, 'desc')
        }
    </script>
@endsection