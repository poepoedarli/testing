@extends('developer.index')

@section('developer-content')

                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter" id="mlops-data-set-training-dtable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Dataset IDs</th>
                        <th>Status</th>
                        <th>Application Name</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>




    <script type="text/javascript">
        var table;
        $(function () {
            getDataSet();
        })

        function getDataSet() {
            const dataSetColumns = [
                {
                    data: 'id',
                    name: 'id',
                    width: "20px",
                },
                {
                    data: 'data_set_ids',
                    name: 'data_set_ids',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'serviceName',
                    name: 'serviceName',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }
            ];
            const dataSetFilterColumns = {"inputs": ["ID"]};
            const data_set_ajax_url = "{{ route('data_set_training.index') }}";
            const data_set_table_id = "mlops-data-set-training-dtable";
            const dataSetDeleteUrl = "/data_set_training/"
            setTimeout(() => {
                Custom.initDataTable(data_set_table_id, data_set_ajax_url, dataSetColumns, dataSetFilterColumns, dataSetDeleteUrl, 0, 'desc')
            }, 200);
        }
    </script>

@endsection