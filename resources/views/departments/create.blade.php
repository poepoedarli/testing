@extends('layouts.backend')


@section('content')
    <div class="">

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title text-primary">Create Department</h3>
            </div>
            <div class="block-content block-content-full">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent

                {!! Form::open(['route' => 'departments.store',  'method' => 'POST']) !!}
                @foreach ($form_controls as $key => $controls)
                    <div class="row mb-2 mx-4">
                        @foreach ($controls as $control)
                            {!! $control !!}
                        @endforeach
                    </div>
                @endforeach

                <div class="row mx-4">
                    <div class="col-sm-12 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-sm btn-primary me-md-2"><i
                                    class="fa fa-save me-1"></i>Submit
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary "
                                onclick="location.href='{{ url('departments') }}'"><i
                                    class="fa fa-backward me-1"></i>Cancel
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
