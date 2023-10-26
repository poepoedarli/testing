@extends('layouts.backend')
@section('js')
    <script src="{{ asset('js/plugins/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
    <div class="">
        <div class="block block-rounded mb-2">
            <div class="block-header block-header-default">
                <h3 class="block-title text-secondary">Raw Data Upload</h3>
            </div>

            <div class="block-content block-content-full">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent
                
                {!! Form::open(['route' => 'dataset_templates.store', 'method' => 'POST']) !!}
                @foreach ($form_controls as $key => $controls)
                    <div class="row mt-0 mb-0">
                        {{-- <div class="col-12 text-center">
                            <h4>{{ $key }}</h4>
                        </div> --}}
                        @foreach ($controls as $control)
                            {!! $control !!}
                        @endforeach
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-sm-12 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-sm btn-primary me-md-2"><i class="fa fa-save me-1"></i>Submit
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary "
                            onclick="location.href='{{ route('datasets.index') }}'"><i
                                class="fa fa-backward me-1"></i>Cancel
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {

        })
    </script>
@endsection
