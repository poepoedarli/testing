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
    <style>
        .nav-pills.flex-column {
            align-items: flex-start;
        }

        .input-group-text {
            width: 90px;
        }

        .summary-line {
            display: flex;
            align-items: center;
            border: #131e32 1px solid;
            width: 500px;
            height: 50px;
            border-radius: 10px;
            margin: 20px auto
        }

        .summary-line-button {
            margin-left: 20px;
            width: 140px
        }

        .summary-line-vertical {
            border-left: 1px solid #000;
            height: 30px;
            margin-left: 50px
        }
    </style>
@endsection
@section('content')
    <div class="content">

        <div class="block block-rounded">
            <div class="block-content block-content-full pt-0">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent
                <ul class="nav nav-tabs" id="myTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request()->is('developer/index') ? ' active' : '' }}"
                           href="{{ route('developer.index') }}">Documentation</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request()->is('developer/examples') ? ' active' : '' }}"
                           href="{{ route('developer.examples') }}">Examples</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ (request()->is('developer/testTools')  || request()->is('data_job') || request()->is('manual_judgment')|| request()->is('data_report'))? ' active' : '' }}"
                           href="{{ route('developer.testTools') }}">Development
                        </a>
                    </li>
{{--                    <li class="nav-item" role="presentation">--}}
{{--                        <a class="nav-link {{ request()->is('developer/sandbox') ? ' active' : '' }}"--}}
{{--                           href="{{ route('developer.sandbox') }}">Sandbox</a>--}}
{{--                    </li>--}}
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request()->is("developer/deploy") ? ' active' : '' }}"
                           href="{{ route('developer.deploy') }}">Deploy</a>
                    </li>

                </ul>
                <div class="tab-content" >
                    @yield('developer-content')
                </div>
            </div>
        </div>


    </div>

    <script >
        $(document).ready(function() {
            window.expanded = 0
            $("#menu-sidebar-toggle").click(function(){
                window.expanded = window.expanded == 0 ? 1 : 0;
                console.log('expanded '+window.expanded)
                
            })
        })
    </script>
@endsection
