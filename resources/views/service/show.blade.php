@extends('layouts.backend')


@section('content')
    <div class="content">

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title text-primary">View Application</h3>
            </div>
            <div class="block-content block-content-full">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent

                @foreach ($form_controls as $key => $controls)
                    <div class="row mt-4 mb-2">
                        <div class="col-12 text-center">
                            <h4>{{ $key }}</h4>
                        </div>
                        @foreach ($controls as $control)
                            {!! $control !!}
                        @endforeach
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-sm-12 d-md-flex justify-content-md-end mt-4">

                        <button type="button" class="btn btn-sm btn-primary me-md-2"
                                onclick="location.href='{{ route('service.edit', $info->id) }}'"><i
                                    class="fa fa-edit me-1"></i>Edit
                        </button>
                        <a type="button" class="btn btn-sm btn-primary me-md-2"
                           onclick="delService({{$info->id}})"><i
                                    class="fa  fa-trash me-1"></i>Delete
                        </a>
                        <button type="button" class="btn btn-sm btn-secondary "
                                onclick="location.href='{{ url('service') }}'"><i
                                    class="fa fa-backward me-1"></i>Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Confirmation On Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1" aria-hidden="false" data-service-id="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Del Application</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete  ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmService()">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function delService(id) {
            var modal = $('#serviceModal');
            modal.modal('show');
        }

        function confirmService() {
            var modal = $('#serviceModal');
            modal.modal('hide');
            let token = $("meta[name='csrf-token']").attr("content");
            $.post({
                url: '/service/confirm',
                type: 'POST',
                DataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': "application/json"
                },
                data: {
                    "_token": token,
                    "id": {{$info->id}},
                    "confirmType": 3,
                },
                success: function (response) {
                    location.href = "/service";
                }
            });

        }
    </script>
@endsection
