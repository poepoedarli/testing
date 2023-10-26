<div class="row items-push">
    <div class="block">
        <div class="block-header justify-content-end">
            <a class="btn btn-sm btn-dark me-2" href="{{ route('dca_ma.new_task', ['id' => $application->id]) }}">
                <i class="fa fa-plus me-1"></i>
                New Task
            </a>
        </div>
        <div class="block-content block-content-full p-0">
            <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="tasks-dtable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Dataset</th>
                        <th>Template Data</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    var table;
    $(function() {
        getTasks()
    })

    function getTasks() {
        const columns = [{
                data: 'id',
                name: 'id',
                width: "50px",
            },
            {
                data: 'name',
                name: 'dataset.name',
            },
            {
                data: 'dataset_template_data',
                name: 'dataset_template_data',
            },
            {
                data: 'created_at',
                name: 'application_task.created_at',
            },
            {
                data: 'updated_at',
                name: 'application_task.updated_at',
            },
            {
                data: 'actions',
                name: 'actions',
                width: '66px',
                class: 'notexport',
                orderable: false,
                searchable: false
            },
        ];


        const filterColumns = {
            "inputs": ["ID", "Dataset"],
        };

        const ajax_url = "{!! route('dca_ma.tasks', ['id' => $application->id]) !!}";
        console.log(ajax_url);
        const table_id = "tasks-dtable";
        // const delete_url = "/data_job/"
        setTimeout(() => {
            Custom.initDataTable(table_id, ajax_url, columns, filterColumns, "", 0, 'desc')
        }, 200);
    }
</script>
