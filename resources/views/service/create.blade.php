@extends('layouts.backend')


@section('content')
    <div class="content">

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title text-secondary">Create Application</h3>
            </div>
            <div class="block-content block-content-full">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent

                {!! Form::open(['route' => 'service.store',  'method' => 'POST']) !!}

                <div class="col-xs-4 col-sm-4 col-md-4 mt-3">
                    <div class="form-group">
                        <label class="form-label">Application Name:(Type to create a new application,
                            else select existing version from drop down menu )</label>
                        <input type="text" class="form-control" name="service[name]" list="serviceNames"
                               id="serviceNameInput" onfocus="this.value=''">
                        <datalist id="serviceNames">
                            @foreach($serviceName as $key => $value)
                                <option>{{$value}}</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                @foreach ($form_controls as $key => $controls)
                    <div class="row mb-2">
                        @foreach ($controls as $control)
                            {!! $control !!}
                        @endforeach
                    </div>
                @endforeach

                <div class="row">
                    <div class="col-sm-12 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-sm btn-primary me-md-2"><i
                                    class="fa fa-save me-1"></i>Submit
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary "
                                onclick="location.href='{{ url('service') }}'"><i
                                    class="fa fa-backward me-1"></i>Cancel
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
