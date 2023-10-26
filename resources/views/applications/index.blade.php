@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/magnific-popup/magnific-popup.css')}}">
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
@endsection

@section('content')
    <div class="block block-rounded bg-light">
        <div class="block-header block-header-default">
            <h3 class="block-title text-primary"><i class="fa fa-dice-d6 me-1"></i>Applications</h3>
            <div class="d-flex d-none" style="float:right">
                <a class="btn btn-sm btn-success text-white" href="{{ route('applications.create') }}">
                    <i class="fa fa-plus me-1"></i>Create Application</a>
            </div>
        </div>
        <div class="block-content block-content-full p-2 pt-0 ">
            @component('components.message')
                <!-- show error messages  -->
            @endcomponent
            <div class="row ">
                @foreach ($applications as $application)
                    <div class="col-sm-12 col-md-12">
                        <div class="block block-rounded">
                            <div class="block-header bg-primary-light py-0 pe-0" style="line-height: 1.8rem">
                                <h3 class="block-title">
                                    @can('application-launch')
                                        <button type="button" class="btn btn-sm btn-outline-primary active clone-app" data-bs-toggle="tooltip" title="Create Project from Application" data-app-id="{{$application->id}}">
                                            <i class="fa fa-rocket"></i>
                                        </button>
                                    @endcan
                                    @can('application-edit')
                                    <a href="{{ route('applications.edit', $application->id) }}" class="btn btn-sm btn-outline-primary active" data-bs-toggle="tooltip" title="Edit Application" >
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @endcan
                                    <a class="text-white" href="/applications" data-bs-toggle="tooltip" title="View Application">{{$application->name}}</a>
                                   
                                </h3>
                                <div class="block-options">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" title="App Descriptions" data-bs-toggle="tab" data-bs-target="#nav-descriptions-{{$application->id}}" type="button" role="tab" aria-controls="nav-descriptions" aria-selected="true">
                                            <i class="fa fa-book-open-reader"></i>
                                        </button>
                                        <button class="nav-link" title="App Pages" data-bs-toggle="tab" data-bs-target="#nav-images-{{$application->id}}" type="button" role="tab" aria-controls="nav-images" aria-selected="true">
                                            <i class="far fa-images"></i>
                                        </button>
                                        <button class="nav-link" title="App Flow" data-bs-toggle="tab" data-bs-target="#nav-flow-{{$application->id}}" type="button" role="tab" aria-controls="nav-flow" aria-selected="false">
                                            <i class="fa fa-diagram-project"></i>
                                        </button>
                                        <button class="nav-link" title="App DataSource" data-bs-toggle="tab" data-bs-target="#nav-datasource-{{$application->id}}" type="button" role="tab" aria-controls="nav-datasource" aria-selected="false">
                                            <i class="fa fa-layer-group"></i>
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                            @php
                                $web_page_screenshots = json_decode($application->web_page_screenshots,  true);
                            @endphp
                            <div class="block-content block-content-full">
                                <div class="tab-content overflow-hidden" id="nav-tabContent">
                                    <div class="tab-pane fade fade-right show active" id="nav-descriptions-{{$application->id}}" role="tabpanel" aria-labelledby="nav-descriptions-tab" tabindex="0">
                                        <div class="block block-rounded block-link-pop">
                                            <div class="block-content">
                                                <h4 class="mb-1">{{ $application->name }} 
                                                    @can('isSuperAdmin')
                                                        @if($application->ref_no)
                                                            <code>(Ref: {{ $application->ref_no }})</code>
                                                        @endif
                                                    @endcan
                                                </h4>
                                                <p class="fs-sm">
                                                    <a href="/users/{{ $application->creator_id }}">{{ $application->application_creator->name }}</a> on
                                                    {{ \Carbon\Carbon::parse($application->updated_at)->format('d F Y') }}
                                                </p>
                                                <p class="">{{ $application->short_description }}</p>
                                                <p class="">{!! $application->full_description !!}</p>
                                                @if($application->documentation_link)
                                                <i class="fa fa-link me-1 mt-4"></i><span class="fw-semibold">Documentation Link:</span><a class="fw-semibold" href="{{ $application->documentation_link }}"> {{ $application->documentation_link }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade fade-right" id="nav-images-{{$application->id}}" role="tabpanel" aria-labelledby="nav-images-tab"  tabindex="0">
                                        <div id="carouselControls-{{$application->id}}" class="carousel slide carousel-fade">
                                            <div class="carousel-indicators">
                                                @if (!is_null($web_page_screenshots))
                                                    @foreach ($web_page_screenshots as $key=>$item)
                                                        <button type="button" data-bs-target="#carouselControls-{{$application->id}}" data-bs-slide-to="{{$key}}" class="{{$key==0?'active':''}}" aria-current="true" aria-label="Slide {{$key}}"></button>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="carousel-inner">
                                                @if (!is_null($web_page_screenshots))
                                                    @foreach ($web_page_screenshots as $key=>$item)
                                                        <div class="carousel-item {{$key==0?'active':''}}">
                                                            <img alt="" src="{{ asset('media/images/applications/web_page_screenshots/' . $item['filename']) }}" class="d-block w-100" alt="{{$item['name']}}">
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselControls-{{$application->id}}"
                                                data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselControls-{{$application->id}}"
                                                data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade fade-right" id="nav-flow-{{$application->id}}" role="tabpanel" aria-labelledby="nav-flow-tab" tabindex="0">
                                        @if (\View::exists("applications/designs/$application->ref_no/design_flow"))
                                            @component("applications/designs/$application->ref_no/design_flow")
                                                @slot('title')
                                                    Prepare Data Source
                                                @endslot
                                            @endcomponent
                                        @else
                                            @component("applications/designs/default/design_flow")
                                                @slot('title')
                                                    Prepare Data Source
                                                @endslot
                                            @endcomponent
                                        @endif
                                    </div>
                                    <div class="tab-pane fade fade-right" id="nav-datasource-{{$application->id}}" role="tabpanel" aria-labelledby="nav-datasource-tab" tabindex="0">
                                        @if (\View::exists("applications/designs/$application->ref_no/datasource_flow"))
                                            @component("applications/designs/$application->ref_no/datasource_flow")
                                                @slot('title')
                                                    Prepare Data Source
                                                @endslot
                                            @endcomponent
                                        @else
                                            @component("applications/designs/default/datasource_flow")
                                                @slot('title')
                                                    Prepare Data Source
                                                @endslot
                                            @endcomponent
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            Dashmix.helpersOnLoad(['jq-easy-pie-chart', 'jq-magnific-popup']);
        });

        $(".clone-app").on('click', function(e){
            let app_id = $(this).data('app-id');
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: `ajax/applications/${app_id}/clone-app`,
                type: 'POST',
                DataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': "application/json"
                },
                data: {
                    "_token": token,
                },
                success: function(response) {
                    window.location.href = `applications/${response.data.id}/clone-app`
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error("Error: " + status, error);
                    console.log(xhr.responseJSON.message)
                }
            });
        })
    </script>
    <style>
        .carousel-indicators [data-bs-target] {
            background-color: #8789f0 !important; 
        }

        .carousel-indicators {
            top: 0 !important;
        }
    </style>
@endsection

