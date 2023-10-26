@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection

@section('js')
    <!-- jQuery (required for DataTables plugin) -->
    <!--<script src="{{ asset('js/lib/jquery.min.js') }}"></script> -->

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

    <!-- Page JS Code -->
    @vite(['resources/js/pages/datatables.js'])
@endsection
@section('content')

    <div class="content" style="background-color:white">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <i class="fa fa-service mr-2"></i>Application Management
                    @if (Auth::user()->can('service-create'))
                        <div class="d-flex" style="float:right">
                            <a class="btn btn-sm btn-success text-white" href="{{ route('service.create') }}"> <i
                                        class="fa fa-plus me-1"></i>Create Application</a>
                        </div>
                    @endif
                    {{--                    @if (Auth::user()->can('submit-order'))--}}
                    {{--                    <div>--}}
                    {{--                        <a class="btn btn-sm btn-success text-white" onclick="submitOrder()">Submit Order</a>--}}
                    {{--                    </div>--}}
                    {{--                    @endif--}}
                </h3>

            </div>
            <div class="block-content block-content-full pt-0">

                @component('components.message')
                    <!-- show alert message  -->
                @endcomponent

                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                {{--                <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="service-dtable">--}}
                {{--                    <thead>--}}
                {{--                    <tr>--}}
                {{--                        --}}{{--                        <th></th>--}}
                {{--                        <th>ID</th>--}}
                {{--                        <th>Name</th>--}}
                {{--                        <th>Version</th>--}}
                {{--                        <th>Ref. No.</th>--}}
                {{--                        <th>Status</th>--}}
                {{--                        <th>Description</th>--}}
                {{--                        <th>Created At</th>--}}
                {{--                        <th>Action</th>--}}
                {{--                    </tr>--}}
                {{--                    </thead>--}}
                {{--                    <tbody>--}}
                {{--                    </tbody>--}}
                {{--                </table>--}}

                <div class="row">
                    @foreach($data as $value)
                        <div class="col-lg-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    {{--                                    <h5 class="card-title">ID: {{$value['id']}} </h5>--}}
                                    <h5 class="card-title">Name: {{$value['service']['name']}}</h5>
                                    <h5 class="card-title">Version: {{$value['version']}}</h5>
                                    <h5 class="card-title">Description: {{$value['description']}}</h5>
                                    {{--                                    <h5 class="card-title">Version: {{$value['version']}}</h5>--}}
                                    {{--                                    <h5 class="card-title">Ref. No.: {{$value['ref_no']}}</h5>--}}
                                    <h5 class="card-title">Status: {{$value['status'] == 1 ?"stop":"running"}}</h5>
                                    {{--                                    <h5 class="card-title">Services: @foreach($value['baseServiceName'] as $name)--}}
                                    {{--                                            {{$name}}--}}
                                    {{--                                        @endforeach</h5>--}}
                                    {{--                                    <h5 class="card-title">Created At: {{$value['created_at']}}</h5>--}}


                                    <a href="{{ route('service.show', $value['id']) }}" title="View Application"
                                       class="notexport btn btn-sm btn-primary me-1">View</a>
{{--                                    <a href="{{ route('service.edit', $value['id']) }}" title="Edit Application"--}}
{{--                                       class="notexport btn btn-sm btn-secondary me-1"><i--}}
{{--                                                class="fa fa-xs fa-edit"></i></a>--}}
                                    <a href="{{ route('mlops.summary', $value['id']) }}" title="Management"
                                       class="notexport btn btn-sm btn-primary me-1">Manage</a>
{{--                                    @if($value['status'] == 1)--}}
{{--                                        <a class='btn btn-sm btn-secondary me-1' id='start_service_{{$value['id']}}'--}}
{{--                                           data-service-name='{{$value['service']['name']}}'--}}
{{--                                           onclick='startService({{$value['id']}})'--}}
{{--                                           title='Start Application'><i--}}
{{--                                                    class='fa fa-xs fa-light fa-circle-play'></i></a>--}}
{{--                                    @else--}}
{{--                                        <a class='btn btn-sm btn-secondary me-1' id='stop_service_{{$value['id']}}'--}}
{{--                                           data-service-name='{{$value['service']['name']}}'--}}
{{--                                           onclick='stopService({{$value['id']}})'--}}
{{--                                           title='Stop Application'><i--}}
{{--                                                    class='fa fa-xs fa-regular fa-circle-stop'></i></a>--}}
{{--                                    @endif--}}

{{--                                    <a class='btn btn-sm btn-secondary me-1' id='del_service_{{$value['id']}}'--}}
{{--                                       data-service-name='{{$value['service']['name']}}'--}}
{{--                                       onclick='delService({{$value['id']}})'--}}
{{--                                       title='Delete Application'><i class='fa fa-xs fa-light fa-trash'></i></a>--}}
                                    <a
                                            href="{{ route('application.show_task', ['serviceVersionId'=>$value['id']]) }}"
                                            title="Run Application"
                                            class="notexport btn btn-sm btn-primary me-1">Run Task</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

       
    </div>

    <script type="text/javascript">
        var table;
        {{--$(function () {--}}
        {{--    const dtColumns = [--}}
        {{--        // {--}}
        {{--        //     data: 'checkbox',--}}
        {{--        //     name: 'checkbox',--}}
        {{--        //     width: "20px",--}}
        {{--        //     orderable: false,--}}
        {{--        //     searchable: false--}}
        {{--        // },--}}
        {{--        {--}}
        {{--            data: 'id',--}}
        {{--            name: 'id',--}}
        {{--            width: "50px",--}}
        {{--        },--}}
        {{--        {--}}
        {{--            data: 'name',--}}
        {{--            name: 'name',--}}
        {{--            orderable: false,--}}
        {{--            searchable: false--}}
        {{--        },--}}
        {{--        {--}}
        {{--            data: 'version',--}}
        {{--            name: 'version',--}}
        {{--            width: "50px",--}}
        {{--        },--}}
        {{--        {--}}
        {{--            data: 'ref_no',--}}
        {{--            name: 'ref_no'--}}
        {{--        },--}}
        {{--        {--}}
        {{--            data: 'status',--}}
        {{--            name: 'status'--}}
        {{--        },--}}
        {{--        {--}}
        {{--            data: 'description',--}}
        {{--            name: 'description'--}}
        {{--        },--}}
        {{--        {--}}
        {{--            data: 'created_at',--}}
        {{--            name: 'created_at',--}}
        {{--            width: '140px',--}}
        {{--        },--}}
        {{--        {--}}
        {{--            data: 'actions',--}}
        {{--            name: 'actions',--}}
        {{--            width: '180px',--}}
        {{--            class: 'notexport',--}}
        {{--            orderable: false,--}}
        {{--            searchable: false--}}
        {{--        },--}}
        {{--    ];--}}
        {{--    const filterColumns = {"inputs": ["ID", "Version","Ref. No."]};--}}
        {{--    const ajax_url = "{{ route('service.index') }}";--}}
        {{--    const table_id = "service-dtable";--}}
        {{--    const deleteUrl = "/service/"--}}
        {{--    setTimeout(() => {--}}
        {{--        Custom.initDataTable(table_id, ajax_url, dtColumns, filterColumns, deleteUrl)--}}
        {{--    }, 200);--}}

        {{--});--}}

        // function submitOrder() {
        //     var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        //     var checkedData = [];
        //     for (var i = 0; i < checkboxes.length; i++) {
        //         if (checkboxes[i].checked) {
        //             checkedData.push(checkboxes[i].value);
        //         }
        //     }
        //     if (checkedData.length <= 0) {
        //         alert("please check the services in the list")
        //         return
        //     }
        //     let token = $("meta[name='csrf-token']").attr("content");
        //     $.ajax({
        //         url: '/order/submit_order',
        //         type: 'POST',
        //         DataType: 'json',
        //         headers: {
        //             'X-CSRF-TOKEN': token,
        //             'Accept': "application/json"
        //         },
        //         data: {
        //             "_token": token,
        //             "serviceVersionIds": checkedData
        //         },
        //         success: function (response) {
        //             alert(response['data']['msg'])
        //         }
        //     });
        // }

        
    </script>
@endsection