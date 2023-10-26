@extends('layouts.backend')


@section('content')
    <div class="content">

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title text-secondary">Create Service</h3>
            </div>
            <div class="block-content block-content-full">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent

                {!! Form::open(['route' => 'base_service.store',  'method' => 'POST']) !!}
                @foreach ($form_controls as $key => $controls)
                    <div class="row mb-2">
                        @foreach ($controls as $control)
                            {!! $control !!}
                        @endforeach
                    </div>
                @endforeach

                <div class="row">
                    <div class="col-sm-12 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-sm btn-secondary me-md-2"><i
                                    class="fa fa-save me-1"></i>Submit
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary "
                                onclick="location.href='{{ url('base_service') }}'"><i
                                    class="fa fa-backward me-1"></i>Cancel
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
