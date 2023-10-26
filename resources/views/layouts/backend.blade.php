<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    {{-- 
    * =========================================================
    * @copyright    © 2020 - 2023 Innowave Tech Pte Ltd - All rights reserved.
    * @license        Innowave Tech Software License Agreement
    * @author        Innowave Tech Pte Ltd <legal@innowave.com.sg>
    * @url            https://innowave.com.sg/license
    *
    * You may not use, distribute and modify this code
    * under the terms of Innowave Tech Software License Agreement
    *
    * You should have received a copy of the license with this file.
    * If not, please write to: legal@innowave.com.sg or visit: https://innowave.com.sg/license
    * =========================================================
    --}}
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{ config('app.name', 'Innowave') }}</title>

    <meta name="description" content="{{ config('app.name', 'Innowave') }}">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/logo.png') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/logo.png') }}">

    <!-- Modules -->
    @vite(['resources/sass/main.scss', 'resources/sass/dashmix/themes/xpro.scss', 'resources/js/dashmix/app.js', 'resources/js/app.js' ])

    @yield('css')

    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    @yield('js')

    <script>
        window.activeCharts = [] //reset 
    </script>
</head>

<body>
<div id="page-container" class="sidebar-dark side-scroll page-header-fixed page-header-dark main-content-narrow">
    
    <nav id="sidebar" aria-label="Main Navigation">
        <!-- Side Header -->
        <div class="content-header bg-primary">
            <!-- Logo -->
            <a class="fw-semibold text-white tracking-wide" href="/my-apps">
                Wave<span class="opacity-75">length</span>
                <span class="fw-normal">AI</span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                <!-- Close Sidebar, Visible only on mobile screens -->
                <a class="d-lg-none text-white ms-2" data-toggle="layout" data-action="sidebar_close"
                    href="javascript:void(0)">
                    <i class="fa fa-times-circle"></i>
                </a>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
        <!-- END Side Header -->

         <!-- Sidebar Scrolling -->
         <div class="js-sidebar-scroll">
            <!-- Side Navigation -->
            <div class="content-side content-side-full">
                <ul class="nav-main">
                    <li class="nav-main-item d-none">
                        <a class="nav-main-link{{ request()->is('dashboard') || (request()->root()==request()->url()) ? ' active' : '' }}"
                           href="/dashboard">
                            <i class="nav-main-link-icon fa fa-location-arrow"></i>
                            <span class="nav-main-link-name">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-main-item {{ request()->routeIs('datasets.*') || request()->routeIs('services.*') || request()->routeIs('applications.*')|| request()->routeIs('my-apps.*')? ' open' : ' ' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="true" href="#">
                            <i class="nav-main-link-icon fa fa-cubes"></i>
                            <span class="nav-main-link-name">Management</span>
                        </a>
                        <ul class="nav-main-submenu">
                            
                            @if (Auth::user()->can('dataset-list'))
                            <li class="nav-main-item">
                                <a class="nav-main-link{{  (request()->routeIs("datasets.*")) ? ' active' : '' }}"
                                href="/datasets">
                                    <i class="nav-main-link-icon fa fa-database"></i>
                                    <span class="nav-main-link-name">Datasets</span>
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->can('service-list'))
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->routeIs('services.*')  ? ' active' : '' }}"
                                href="/services">
                                    <i class="nav-main-link-icon fab fa-speaker-deck"></i>
                                    <span class="nav-main-link-name">Services</span>
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->can('application-list'))
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->routeIs('applications.*')  ? ' active' : '' }}"
                                href="/applications">
                                    <i class="nav-main-link-icon fab fa-app-store"></i>
                                    <span class="nav-main-link-name">Application Store</span>
                                </a>
                            </li>
                            @endif
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->routeIs('my-apps.*')  ? ' active' : '' }}"
                                href="/my-apps">
                                    <i class="nav-main-link-icon fa fa-dice-d6"></i>
                                    <span class="nav-main-link-name">My Projects</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- ACL -->
                    <li class="nav-main-heading">Administration</li>
                    <li class="nav-main-item{{ request()->is('logs/*') ? ' open' : ' ' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                            <i class="nav-main-link-icon si si-notebook "></i>
                            <span class="nav-main-link-name">Log</span>
                        </a>
                        <ul class="nav-main-submenu">
                            @if (Auth::user()->can('logs-audit'))
                                <li class="nav-main-item d-none">
                                    <a class="nav-main-link{{ request()->is('logs/audit_logs') ? ' active' : '' }}"
                                       href="/logs/audit_logs">
                                        <span class="nav-main-link-name"><i class="fa fa-book-journal-whills me-1"></i>Audit Logs</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->can('logs-system'))
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('logs/system_logs') ? ' active' : '' }}"
                                       href="/logs/system_logs">
                                        <span class="nav-main-link-name"><i class="fa fa-book-tanakh me-1"></i>System Logs</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                    <li class="nav-main-item{{ request()->routeIs('roles.*') || request()->routeIs('users.*') || request()->routeIs('permissions.*') || request()->routeIs('departments.*') ? ' open' : ' ' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                            <i class="nav-main-link-icon fa fa-users-rectangle"></i>
                            <span class="nav-main-link-name">Access Control</span>
                        </a>
                        <ul class="nav-main-submenu">
                            @if (Auth::user()->id == 1)
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs('permissions.*') ? ' active' : '' }}"
                                       href="/permissions">
                                        <span class="nav-main-link-name"><i
                                                    class="fa fa-lock me-1"></i>Permissions</span>
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->can('role-list'))
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs('roles.*') ? ' active' : '' }}"
                                       href="/roles">
                                        <span class="nav-main-link-name"><i class="fa fa-sitemap me-1"></i>Roles</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->can('user-list'))
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs('users.*') ? ' active' : '' }}"
                                       href="/users">
                                        <span class="nav-main-link-name"><i class="fa fa-fw fa-user-group me-1"></i>Users </span>
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->can('department-list'))
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->routeIs('departments.*') ? ' active' : '' }}"
                                   href="/departments">
                                    <span class="nav-main-link-name"><i class="fa fa-fw fa-id-card me-1"></i>Departments </span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- END Side Navigation -->
        </div>
        <!-- END Sidebar Scrolling -->
    </nav>
    <!-- END Sidebar -->

    <!-- Header -->
    <header id="page-header">
        <!-- Header Content -->
        <div class="content-header">
            <!-- Left Section -->
            <div class="d-flex align-items-center">
                <!-- Logo -->
                <a class="fw-semibold text-dual tracking-wide" href="/">
                    Wave<span class="opacity-75">length</span>.AI
                </a>
                <!-- END Logo -->

                <!-- Menu -->
                <ul class="nav-main nav-main-horizontal nav-main-hover d-none d-lg-block ms-3">
                    <!-- Dashboard -->
                    <li class="nav-main-item d-none">
                        <a class="nav-main-link{{ request()->is('dashboard') || (request()->root()==request()->url()) ? ' active' : '' }}"
                           href="/dashboard">
                            <i class="nav-main-link-icon fa fa-location-arrow"></i>
                            <span class="nav-main-link-name">Dashboard</span>
                        </a>
                    </li>

                    <!-- Management -->
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu {{ request()->routeIs('datasets.*') || request()->routeIs('services.*') || request()->routeIs('applications.*')|| request()->routeIs('my-apps.*')? ' active' : ' ' }}" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                           <i class="nav-main-link-icon fa fa-cubes"></i>
                            <span class="nav-main-link-name">Management</span>
                        </a>
                        <ul class="nav-main-submenu">
                            @if (Auth::user()->can('dataset-list'))
                                <li class="nav-main-item">
                                    <a class="nav-main-link"
                                    href="/datasets">
                                        <span class="nav-main-link-name"><i class="fa fa-database me-1"></i>DataSets</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->can('service-list'))
                                <li class="nav-main-item">
                                    <a class="nav-main-link"
                                       href="/services">
                                        <span class="nav-main-link-name"><i class="fab fa-speaker-deck me-1"></i>Services</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->can('application-list'))
                                <li class="nav-main-item">
                                    <a class="nav-main-link"
                                       href="/applications">
                                        <span class="nav-main-link-name"><i class="fab fa-app-store me-1"></i>Application Store</span>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-main-item">
                                <a class="nav-main-link"
                                   href="/my-apps">
                                    <span class="nav-main-link-name"><i class="fa fa-dice-d6 me-1"></i>My Projects</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Logs -->
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu {{ request()->is('logs/*') ? ' active' : ' ' }}" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                            <i class="nav-main-link-icon si si-notebook"></i>
                            <span class="nav-main-link-name">Logs</span>
                        </a>
                        <ul class="nav-main-submenu">
                            @if (Auth::user()->can('logs-audit'))
                                <li class="nav-main-item d-none">
                                    <a class="nav-main-link"
                                       href="/logs/audit_logs">
                                        <span class="nav-main-link-name"><i class="fa fa-book-journal-whills me-1"></i>Audit Logs</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->can('logs-system'))
                                <li class="nav-main-item">
                                    <a class="nav-main-link"
                                       href="/logs/system_logs">
                                        <span class="nav-main-link-name"><i class="fa fa-book-tanakh me-1"></i>System Logs</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>

                    <!-- ACL -->
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu  {{request()->routeIs('permissions.*') || request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('departments.*') ? ' active' : ' fsdfasd' }}" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                            <i class="nav-main-link-icon fa fa-users-rectangle"></i>
                            <span class="nav-main-link-name">Access Control</span>
                        </a>
                        <ul class="nav-main-submenu">
                            @if (Auth::user()->id == 1)
                                <li class="nav-main-item">
                                    <a class="nav-main-link"
                                       href="/permissions">
                                        <span class="nav-main-link-name"><i
                                                    class="fa fa-lock me-1"></i>Permissions</span>
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->can('role-list'))
                                <li class="nav-main-item">
                                    <a class="nav-main-link"
                                       href="/roles">
                                        <span class="nav-main-link-name"><i class="fa fa-sitemap me-1"></i>Roles</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->can('user-list'))
                                <li class="nav-main-item">
                                    <a class="nav-main-link"
                                       href="/users">
                                        <span class="nav-main-link-name"><i class="fa fa-fw fa-user-group me-1"></i>Users </span>
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->can('department-list'))
                            <li class="nav-main-item">
                                <a class="nav-main-link"
                                   href="/departments">
                                    <span class="nav-main-link-name"><i class="fa fa-fw fa-id-card me-1"></i>Departments </span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                </ul>
                <!-- END Menu -->
            </div>
            <!-- END Left Section -->

            <!-- Right Section -->
            <div>
                
                <!-- Notifications Dropdown -->
                @if (Auth::user())
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-alt-secondary btn-sm" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-user d-sm-none"></i>
                            <span class="d-none d-sm-inline-block">{{ Auth()->user()->name}}</span>
                            <i class="fa fa-fw fa-angle-down opacity-50 ms-1 d-none d-sm-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
                            <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                                User Options
                            </div>
                            <div class="p-2">
                                <a class="dropdown-item" href="/users/{{ Auth()->user()->id }}">
                                    <i class="far fa-fw fa-user me-1"></i> Profile
                                </a>
                                <a class="dropdown-item" href="/change_password">
                                    <i class="fa fa-fw fa-key me-1"></i> Change Password
                                </a>

                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item py-2" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="far fa-fw fa-arrow-alt-circle-left me-1"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- END Notifications Dropdown -->

                <!-- Toggle Sidebar -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-alt-secondary btn-sm d-lg-none" data-toggle="layout"
                    data-action="sidebar_toggle">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <!-- END Toggle Sidebar -->
            </div>
            <!-- END Right Section -->
        </div>
        <!-- END Header Content -->
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
        <div class="content py-1">
            @yield('content')
        </div>
    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer" class="bg-body-light">
        <div class="content py-0">
            <div class="row fs-sm">
                <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-end">
                    Crafted with <i class="fa fa-heart text-danger"></i> by <a class="fw-semibold"
                                                                               href="https://innowave.com.sg/"
                                                                               rel="noopener">Innowave Tech</a>
                </div>
                <div class="col-sm-6 order-sm-1 text-center text-sm-start">
                    <a class="fw-semibold" href="#" rel="noopener">{{ config('app.name') }}</a> &copy;
                    <span data-toggle="year-copy"></span>
                </div>
            </div>
        </div>
    </footer>
    <!-- END Footer -->


</div>
<!-- END Page Container -->

<style>
    .dataTables_processing {
        z-index: 1 !important;
    }
</style>
</body>
</html>
