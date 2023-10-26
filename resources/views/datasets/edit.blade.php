@extends('layouts.backend')
@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-treeview/bootstrap-treeview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
@endsection

@section('js')
    <!-- jQuery (required for DataTables plugin) -->
    <!--<script src="{{ asset('js/lib/jquery.min.js') }}"></script> -->

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/bootstrap-treeview/bootstrap-treeview.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
@endsection
@section('content')
    <div class="">
        <div class="block block-rounded">
            <div class="block-header bg-body-light">
                <h3 class="block-title text-primary"><i class="fa fa-edit me-2"></i>Modify Dataset</h3>
            </div>
            <div class="block-content">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent
                {!! Form::model($dataset, ['method' => 'PATCH','route' => ['datasets.update', $dataset->id], 'class' => 'mx-4']) !!}
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 mt-2">
                        <div class="form-group">
                            <strong>Type:</strong>
                            {!! Form::select('country_code', $dataset_types, 'Image Datasets', [
                                'class' => 'form-control',
                                'disabled' => true,
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                        <div class="form-group">
                            <strong data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Azure Storage - Full Directory Path where dataset images exist">File Path (Azure Storage Path):</strong>
                            {!! Form::text('data_path', null, ['placeholder' => 'URL', 'class' => 'form-control', 'readonly' => true, 'disabled' => true]) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                        <div class="form-group">
                            <strong data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Azure Storage - Full Directory Path where dataset images exist">Upload Images to Azure Storage:</strong>
                                <input type="file" name="local_upload[]" class="form-control" accept="image/*"  multiple="multiple" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                        <div class="form-group">
                            <strong>Descriptions:</strong>
                            <textarea class="form-control" name="descriptions" id="descriptions" rows="10">{{ $dataset->descriptions }}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                        <label for=""><strong>Tags:</strong></label>
                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="far fa-hashtag text-primary"></i>
                            </span>
                            <input type="text" class="form-control" id="tags" name="tags" data-role="tagsinput" value="{{ $dataset->tags }}">
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                        <div class="space-x-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" value="1" id="is_public"
                                    name="is_public"  {{ $dataset->is_public == true ? 'checked': ''}}>
                                <label class="form-check-label" for="is_public">Public to other departments</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 d-md-flex justify-content-md-end my-4">
                        <button type="submit" class="btn btn-sm btn-primary me-md-2"><i
                                class="fa fa-save me-1"></i>Submit</button>
                        <button type="button" class="btn btn-sm btn-secondary text-white"
                            onclick="location.href='{{ route('datasets.index') }}'"><i
                                class="fa fa-backward me-1"></i>Cancel</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        @if (isset($filenames) && sizeof($filenames))
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="row items-push js-gallery img-fluid-100 js-gallery-enabled">
                    @foreach ($filenames as $filename) 
                    {{-- Assumed each file is an image --}}
                    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
                        <a class="img-link img-thumb img-lightbox">
                            <img class="img-fluid" src="{{ config('global.AZURE_STORAGE_URL') . "/".  $filename . config('global.AZURE_BLOB_DATASET_SAS') }}" alt="">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
    <script type="text/javascript">
        $(function() {
            Dashmix.helpersOnLoad(['js-ckeditor5']);

            ClassicEditor
                .create( document.querySelector( '#descriptions' ), {
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
                } )
                .catch( error => {
                    console.error( error );
                } );
        })
    </script>
    <style>
        .bootstrap-tagsinput{
            width: 78vW;
        }

        .ck-content{
            min-height: 10rem;
        }
    </style>
@endsection
