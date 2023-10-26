@extends('applications.management.index')
@section('application-management-content')
    <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="application-logs-dtable">
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

    <script type="text/javascript">
        var table;
        $(function() {
            getServiceLog()
        });


        function getServiceLog() {
            const dtColumns = [{
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
            const log_types = JSON.parse('{!! json_encode(config('global.log_types')) !!}');
            const logTypeObj = {};
            for (const type of log_types) {
                logTypeObj[type] = type;
            }
            const filterColumns = {
                "inputs": ["Title", "Content", "Logged At"],
                "selects": {
                    "Type": logTypeObj
                },
                "dates": []
            }; //,
            const ajax_url = "{{ route('applications.logs', ['id' => $application->id]) }}";
            const table_id = "application-logs-dtable";
            const deleteUrl = "/service_log/"
            Custom.initDataTable(table_id, ajax_url, dtColumns, filterColumns, deleteUrl, 1, 'desc')
        }
    </script>
@endsection
