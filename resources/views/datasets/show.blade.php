@extends('layouts.backend')
@section('js')
<script src="{{ asset('js/plugins/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
    <div class="">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title text-primary"><i class="fa fa-circle-info me-2"></i>Dataset Info</h3>
                <div class="d-flex" style="float:right">
                    <a class="btn btn-sm btn-light text-muted" href="{{ route('datasets.index') }}">
                        <i class="fa fa-backward me-1"></i>Back to Dataset List</a>
                </div>
            </div>
            <div class="block-content block-content-full">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent

                <div class="row">
                    <div class="col-xs-4 col-md-2 d-md-flex">
                        <div class="block block-rounded block-link-pop py-4" >
                            <img class="img-fluid mx-4" src="{{ asset('media/images/datasets/image-dataset.jpg')}}" alt="">
                        </div>
                    </div>
                    <div class="col-xs-8 col-md-10 d-md-flex">
                        <div class="block block-rounded block-link-pop py-2" >
                            <div class="block-content">
                                <h4 class="mb-1">{{ $dataset->name }} </h4>
                                <p class="fs-sm">
                                    <a href="/users/{{$dataset->creator_id}}">{{$dataset->creator->name}}</a> on {{ \Carbon\Carbon::parse($dataset->updated_at)->format('d F Y') }}
                                    <div class="form-check form-switch form-check-inline  form-control-sm">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_public" 
                                            name="is_public" {{ $dataset->is_public == true ? 'checked': ''}} disabled>
                                        <label class="form-check-label" for="is_public">Public</label>
                                    </div>
                                </p>
                                
                                <code class="text-primary fs-6">{{ $dataset->data_path}}</code>

                                <p>{!! $dataset->descriptions !!}</p>

                                <div>
                                    @php $tags = explode(',', $dataset->tags) @endphp
                                    @foreach ($tags as $tag)
                                    <span class="badge bg-primary">#{{$tag}}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            Dashmix.helpersOnLoad(['js-ckeditor']);
        })
    </script>
@endsection
