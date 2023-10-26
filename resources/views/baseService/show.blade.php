@extends('layouts.backend')


@section('content')
    <div class="content">

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title text-secondary">View Service</h3>
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
                        <button type="button" class="btn btn-sm btn-secondary me-md-2"
                                onclick="location.href='{{ route('base_service.edit', $info->id) }}'"><i
                                    class="fa fa-edit me-1"></i>Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary "
                                onclick="location.href='{{ url('base_service') }}'"><i
                                    class="fa fa-backward me-1"></i>Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
