@extends('layouts.backend')

@section('content')
    <div class="">
        <div class="block block-rounded">
            <div class="block-header bg-body-light">
                <h3 class="block-title text-primary"><i class="fa fa-square-plus me-2"></i>Create Service</h3>
            </div>
            <div class="block-content">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent
                {!! Form::open(['route' => 'services.store', 'files' => true, 'method' => 'POST', 'class' => 'mx-4']) !!}
                @foreach ($form_controls as $key => $controls)
                    <div class="row mt-0 mb-0 px-4">
                        @foreach ($controls as $control)
                            {!! $control !!}
                        @endforeach
                    </div>
                @endforeach
                <div class="row mb-4">
                    <div class="col-sm-12 d-md-flex justify-content-md-end px-4">
                        <button type="submit" class="btn btn-sm btn-primary me-md-2"><i class="fa fa-save me-1"></i>Submit
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary "
                            onclick="location.href='{{ route('services.index') }}'"><i
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
            $('#icon').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        })
    </script>
@endsection
