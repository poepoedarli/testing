@extends('layouts.backend')
@section('js')
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
@endsection
@section('content')
    <div class="">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title text-primary"><i class="fa fa-square-plus me-2"></i>Create Application</h3>
            </div>
            <div class="block-content block-content-full">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent
                @component('components.message')
                    <!-- show  messages  -->
                @endcomponent
                {!! Form::open(['route' => 'applications.store', 'files' => true, 'method' => 'POST']) !!}
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
                            onclick="location.href='{{ route('applications.index') }}'"><i
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

            $('#icon').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        })
    </script>
    <style>
        .ck-content{
            min-height: 10rem;
        }
    </style>
@endsection
