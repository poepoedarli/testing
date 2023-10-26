@extends('layouts.backend')
@section('js')
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
@endsection
@section('content')
    <div class="">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title text-primary"><i class="fa fa-circle-info me-2"></i>Service Info</h3>
                <div class="d-flex" style="float:right">
                    <a class="btn btn-sm btn-light text-muted" href="{{ route('services.index') }}">
                        <i class="fa fa-backward me-1"></i>Back to Service List</a>
                </div>
            </div>
            <div class="block-content block-content-full">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent

                <div class="row">
                    <div class="col-xs-4 col-md-2 d-md-flex">
                        <div class="block block-rounded block-link-pop py-4">
                            <img alt="" class="img-fluid mx-4" src="{{ asset('media/images/services') . '/' . $service->icon }}"
                                alt="">

                        </div>
                    </div>
                    <div class="col-xs-8 col-md-10 d-md-flex">
                        <div class="block block-rounded block-link-pop py-2">
                            <div class="block-content">
                                <h4 class="mb-1">{{ $service->name }} <code>(Version:{{ $service->version }})</code></h4>
                                <p class="fs-sm">
                                    <a href="/users/{{ $service->creator_id }}">{{ $service->service_creator->name }}</a> on
                                    {{ \Carbon\Carbon::parse($service->updated_at)->format('d F Y') }}
                                </p>
                                <p class="">{{ $service->description }}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            Dashmix.helpersOnLoad(['js-ckeditor5']);
        })
    </script>
@endsection
