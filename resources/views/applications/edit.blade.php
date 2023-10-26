@extends('layouts.backend')
@section('js')
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endsection
@section('content')
    <div class="">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title text-primary"><i class="fa fa-edit me-2"></i>Modify Application</h3>
            </div>
            <div class="block-content block-content-full">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent
                @component('components.message')
                    <!-- show  messages  -->
                @endcomponent
                {!! Form::model($application, [
                    'id' => 'application-form',
                    'method' => 'PATCH',
                    'files' => true,
                    'class' => 'js-validation',
                    'route' => ['applications.update', $application->id],
                ]) !!}

                @foreach ($form_controls as $key => $controls)
                    <div class="row mt-0 mb-0">
                        {{-- <div class="col-12 text-center">
                        <h4>{{ $key }}</h4>
                    </div> --}}
                        @foreach ($controls as $control)
                            {!! $control !!}
                        @endforeach
                    </div>

                    <input class="d-none" name="is_cloned" id="clonedApp" value="{{ $is_cloned }}">
                @endforeach

                @if ($is_cloned==true)
                <p class="text-warning">**** Before submit, please check and make sure your container Info is correct. ****</p>
                @endif
                
                <div class="row">
                    <div class="col-sm-12 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" id="btn-update" class="btn btn-sm btn-secondary me-md-2">
                            <i class="fa fa-save me-1"></i>Submit
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary "
                            onclick="location.href='{{ route('applications.index') }}'">
                            <i class="fa fa-backward me-1"></i>Cancel
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(function() {

            Dashmix.helpersOnLoad("jq-validation")
            $(".js-validation").validate()

            if ($("#clonedApp").val() == false) {
                Dashmix.helpersOnLoad(['js-ckeditor5']);

                ClassicEditor
                    .create(document.querySelector('#full_description'), {
                        toolbar: {
                            items: [
                                'heading',
                                '|', 'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                                '|', 'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',
                                '|', 'link', 'blockQuote', 'codeBlock',
                                '|', 'alignment',
                                '|', 'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent',
                                '|', 'undo', 'redo'
                            ],
                            shouldNotGroupWhenFull: true
                        },
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

        })


    </script>
@endsection
