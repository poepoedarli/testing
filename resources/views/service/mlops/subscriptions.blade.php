@extends('service.mlops.index')

@section('mlops-content')
    {{--    @foreach ($subscriptions['allServiceVersionArr'] as $item)--}}
    {{--        <div class="form-check form-check-inline" style="margin-top: 20px">--}}
    {{--                <label>--}}
{{--                        <input type="checkbox" class="subscriptions-checkbox-input"--}}
{{--                               data-value="{{ $item['id'] }}" data-service-version-id="{{$serviceVersionId}}"--}}
{{--                               value="{{ $item['id'] }}" {{ in_array($item['id'], $subscriptions['serviceSubscriptions']) ? 'checked' : '' }}>--}}
{{--                        {{ $item['name'] }}--}}
    {{--                </label>--}}
    {{--        </div>--}}
    {{--    @endforeach--}}
    <div class="block block-rounded">

        <div class="block-content block-content-full pt-0" style="margin-top: 20px">

            <div class="row">
                @foreach($allService as $value)
                    <div class="col-lg-4">
                        <div class="card text-left">
                            <div class="card-body">
                                <h5 class="card-title">Subscribe: <label>
                                        <input type="checkbox" class="subscriptions-checkbox-input"
                                               data-service-id="{{ $value['id'] }}" data-application-id="{{$serviceVersionId}}"
                                               {{ in_array($value['id'], $subscriptionIds) ? 'checked' : '' }}>
                                    </label></h5>
                                <h5 class="card-title">Name: {{$value['name']}}</h5>
                                <h5 class="card-title">Version: {{$value['version']}}</h5>
                                <h5 class="card-title">Model: {{$value['model']}}</h5>
                                <h5 class="card-title">Short Desc: {{$value['short_desc']}}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script type="text/javascript">

        var checkboxes = document.querySelectorAll('.subscriptions-checkbox-input');
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('click', function () {
                var serviceId = this.getAttribute('data-service-id');
                var applicationId = this.getAttribute('data-application-id');
                var type = 2
                if (this.checked) {
                    type = 1
                }
                let token = $("meta[name='csrf-token']").attr("content");
                $.post({
                    url: "/service/subscription",
                    type: 'POST',
                    DataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': "application/json"
                    },
                    data: {
                        "_token": token,
                        "id": applicationId,
                        "subscriptionId": serviceId,
                        "type": type,
                    },
                    success: function (response) {

                    }

                });
            });
        });
    </script>
@endsection