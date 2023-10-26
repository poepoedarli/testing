@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection

@section('js')
    <!-- jQuery (required for DataTables plugin) -->
    <!--<script src="{{ asset('js/lib/jquery.min.js') }}"></script> -->

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

    <!-- Page JS Code -->
    @vite(['resources/js/pages/datatables.js'])
@endsection
@section('content')
    <div class="content">

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title text-secondary">Application Management</h3>
            </div>
            <div class="block-content block-content-full pt-0">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent
                <ul class="nav nav-tabs" id="myTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request()->is('mlops/summary/'.$serviceVersionId) ? ' active' : '' }}"
                           href="{{ route('mlops.summary',$serviceVersionId) }}">Summary</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request()->is('mlops/resources/'.$serviceVersionId) ? ' active' : '' }}"
                           href="{{ route('mlops.resources',$serviceVersionId) }}">Resources</a>
                    </li>
                    <li class="nav-item dropdown" role="presentation">
                        <a class="nav-link dropdown-toggle {{ (request()->is('data_set_job') || request()->routeIs('manual_judgment.*') || request()->is('data_report') || request()->is('ocr') ) ? ' active' : '' }}"
                           href="#" id="mlopsNavbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if($versionInfo['ref_no'] == "inno-ocr")
                                OCR
                            @else
                                MLOps
                            @endif
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown" id="mlops-dropdown-menu">
                            <a class="dropdown-item"
                               href="{{ route('data_set_job.index',['serviceVersionId'=>$serviceVersionId]) }}">New
                                Test</a>
                            @if($versionInfo['ref_no'] == "inno-ocr")
                                <a class="dropdown-item"
                                   href="{{ route('ocr.index',['serviceVersionId'=>$serviceVersionId]) }}">Report</a>
                            @else
                                <a class="dropdown-item"
                                   href="{{ route('manual_judgment.index',['serviceVersionId'=>$serviceVersionId]) }}">View
                                    Manual Judgment</a>
                                <a class="dropdown-item"
                                   href="{{ route('data_report.index',['serviceVersionId'=>$serviceVersionId]) }}">Report</a>
                            @endif
                        </div>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request()->is('mlops/subscriptions/'.$serviceVersionId) ? ' active' : '' }}"
                           href="{{ route('mlops.subscriptions',$serviceVersionId) }}">Service</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request()->is('mlops/log/'.$serviceVersionId) ? ' active' : '' }}"
                           href="{{ route('mlops.log',$serviceVersionId)}}">Log</a>
                    </li>
                </ul>
                <div class="tab-content">
                    @yield('mlops-content')
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#mlopsNavbarDropdown').click(function () {
            $('#mlops-dropdown-menu').addClass('show').removeClass('hide');
        });
    </script>
@endsection
