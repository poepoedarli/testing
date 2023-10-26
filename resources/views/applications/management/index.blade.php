@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/lib/echarts-5.3.1.min.js') }} "></script>
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
@endsection
@section('content')
    <div class="block block-rounded mt-2">
        <div class="block-header block-header-default pb-2">
            <h3 class="block-title text-primary">
                <i class="fa fa-circle-info me-2"></i>
                Application Manager - {{ $application->name }}
            </h3>
        </div>
        <div class="block-content block-content-full p-0">
            @component('components.error')
                <!-- show error messages  -->
            @endcomponent
            @component('components.message')
                <!-- show error messages  -->
            @endcomponent
            <div class="block block-themed">
                {{-- <div class="block-header bg-default text-center">
                    <h3 class="block-title">{{ $application->name }}</h3>
                </div> --}}
                <div class="block-content block-content-full p-0">
                    <ul class="nav nav-tabs nav-tabs-block" id="application_management_tabs" role="tablist">
                        <li class="nav-item " role="presentation">
                            <a class="nav-link {{ request()->is('applications/' . $application->id . '/summary') ? ' active' : '' }}"
                                href="{{ route('applications.summary', $application->id) }}">Summary</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request()->is('applications/' . $application->id . '/resources') ? ' active' : '' }}"
                                href="{{ route('applications.resources', $application->id) }}">Resources</a>
                        </li>
                        @if (isset($application->operation_pages) && count($application->operation_pages))
                            <li class="nav-item dropdown" role="presentation">
                                <a class="nav-link dropdown-toggle {{ request()->is('applications/' . $application->id . '/operations/*') ? ' active' : '' }}"
                                    href="#" id="operations-dropdown" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Operations
                                </a>
                                <div class="dropdown-menu col-12" aria-labelledby="navbarDropdown"
                                    id="operations-dropdown-menu">
                                    @foreach ($application->parent_pages as $page)
                                        <a class="dropdown-item col-12"
                                            href="{{ route('applications.operations', ['id' => $application->id, 'route_name' => $page->route_name]) }}">
                                            {{ $page->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                        <li class="nav-item d-none" role="presentation">
                            <a class="nav-link {{ request()->is('applications/' . $application->id . '/services') ? ' active' : '' }}"
                                href="{{ route('applications.services', $application->id) }}">Services</a>
                        </li>
                        <li class="nav-item d-none" role="presentation">
                            <a class="nav-link {{ request()->is('applications/' . $application->id . '/logs') ? ' active' : '' }}"
                                href="{{ route('applications.logs', $application->id) }}">Logs</a>
                        </li>
                    </ul>
                    <div class="block block-rounded tab-content">
                        <div class="block-content block-content-full">
                            @yield('application-management-content')
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
