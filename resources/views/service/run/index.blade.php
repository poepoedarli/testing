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
                <h3 class="block-title text-secondary">Run Application</h3>
            </div>
            <div class="block-content block-content-full pt-0">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent
                <ul class="nav nav-tabs" id="myTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request()->is('application/show_task*') ? ' active' : '' }}"
                           href="{{ route('application.show_task',['serviceVersionId'=>$serviceVersionId])}}">Task</a>
                    </li>
                    @if($versionInfo['ref_no'] == "inno-ocr")
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request()->is('application/ocr_report*') ? ' active' : '' }}"
                               href="{{ route('application.ocr_report',['serviceVersionId'=>$serviceVersionId])}}">Report</a>
                        </li>
                    @else
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request()->is('application/mlops_report*') ? ' active' : '' }}"
                               href="{{ route('application.mlops_report',['serviceVersionId'=>$serviceVersionId])}}">Report</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content">
                    @yield('run-application-content')
                </div>
            </div>
        </div>


    </div>

@endsection
