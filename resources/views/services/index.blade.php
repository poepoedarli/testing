@extends('layouts.backend')

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title text-primary"><i class="fab fa-speaker-deck me-1"></i>Services Management</h3>
            <div class="d-flex" style="float:right">
                @if (Auth::user()->can('service-create'))
                <a class="btn btn-sm btn-primary text-white" href="{{ route('services.create') }}">
                    <i class="fa fa-plus me-1"></i>New Service</a>
                @endif
            </div>
        </div>
        <div class="block-content block-content-full pt-0">
            @component('components.error')
                <!-- show error messages  -->
            @endcomponent
            @component('components.message')
                <!-- show error messages  -->
            @endcomponent

            <div class="row g-1 p-1 m-1">
                @foreach ($services as $service)
                <div class="d-lg-flex">
                    <div class="ms-xs-2 me-sm-4 py-3 mt-2">
                        <a class="item item-rounded bg-body-dark text-dark fs-1 mb-1 " href="{{ route('services.show', $service->id) }}" style="width: 6rem; height: 6rem" title="Service Details Info">
                            <img alt="" src="{{ asset('media/images/services/' . $service->icon) }}" class="" style="width: 100%" />
                        </a>
                        @if (Auth::user()->can('application-create'))
                        <a class="btn btn-sm btn-primary w-100" href="{{ route('applications.create', ['service_id' => $service->id]) }}" style="max-width: 100px">
                            <i class="fab fa-2x fa-autoprefixer" title="Create App"></i>
                        </a>
                        @endif
                    </div>
                    <div class=" py-3 mt-2">
                        <a class="link-fx h4 mb-1 d-inline-block text-dark" href="{{ route('services.show', $service->id) }}" title="Service Details Info">
                            {{ $service->name }}
                        </a>
                        <div class="fs-sm fw-semibold text-muted mb-2">
                            <a href="/users/{{$service->creator_id}}" title="Service Creator">{{$service->service_creator->name}}</a> on {{ \Carbon\Carbon::parse($service->updated_at)->format('d F Y') }}
                        </div>
                        <p class="text-muted mb-1" style="min-height: 3.1rem">
                            @if(strlen($service->description)>250)
                            {{ substr($service->description, 0, 250)}} <a href="{{ route('services.show', $service->id) }}">Read More ... </a>
                            @else
                            {{ $service->description }} 
                            @endif
                        </p>
                        <div class="">
                            <a class="btn btn-sm btn-primary w-10 d-none" href="{{ route('services.show', $service->id) }}" title="More Details">
                                <i class="far fa-eye" ></i>
                            </a>
                            @if (Auth::user()->can('service-edit'))
                            <a class="btn btn-sm btn-primary w-10" href="{{ route('services.edit', $service->id) }}" title="Modify Service">
                                <i class="fa fa-edit"></i>
                            </a>
                            @endif

                            @if (Auth::user()->can('service-delete'))
                            <a class="btn btn-sm btn-danger w-10" title="Delete Service" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this service?')) { document.getElementById('delete-form-{{$service->id}}').submit(); }">
                                <i class="fa fa-trash"></i>
                            </a>
                            @endif
                            <form id="delete-form-{{$service->id}}" action="{{ route('services.destroy', $service->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                            
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
@endsection
