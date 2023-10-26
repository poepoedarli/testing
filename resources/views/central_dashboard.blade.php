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
    <div class="">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title text-secondary">Central Dashboard</h3>
            </div>
            <div class="block-content block-content-full pt-0">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent
                @component('components.message')
                    <!-- show error messages  -->
                @endcomponent

                <div class="row g-1 p-1 m-1">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 border border-light rounded">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-shrink-0 bd-highlight">
                                <img alt="" src="{{ asset('media/images/examples/amc.png') }}" class="img-fluid" style="max-height: 100px;" />
                            </div>
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <h6>Auto Mask Checking</h6>
                                <p>Automatic Mask Checking</p>
                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="#"
                                    class="btn btn-outline-primary rounded-0">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 border border-light rounded">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-shrink-0 bd-highlight">
                                <img alt="" src="{{ asset('media/images/examples/cdsem.png') }}" class="img-fluid" style="max-height: 100px;" />
                            </div>
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <h6>Manual Assist Automation</h6>
                                <p>Tool Manual Assist Automation</p>
                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="#"
                                    class="btn btn-outline-primary rounded-0">View</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 border border-light rounded">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-shrink-0 bd-highlight">
                                <img alt="" src="{{ asset('media/images/examples/ocr.png') }}" class="img-fluid" style="max-height: 100px;" />
                            </div>
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <h6>OCR</h6>
                                <p>Optical Character Recognition</p>
                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="#"
                                    class="btn btn-outline-primary rounded-0">View</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 border border-light rounded">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-shrink-0 bd-highlight">
                                <img alt="" src="{{ asset('media/images/examples/adc.jpg') }}" class="img-fluid" style="max-height: 100px;" />
                            </div>
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <h6>ADC</h6>
                                <p>Automatic Defect Classification</p>
                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="#"
                                    class="btn btn-outline-primary rounded-0">View</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
