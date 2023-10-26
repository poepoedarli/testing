@extends('applications.management.index')
@section('application-management-content')
    @if (isset($page))
        {{-- {{ dd($page->section) }} --}}
        @component('applications.operations.' . $page, compact('application', 'page', 'parameters'))
        @endcomponent
    @endif
@endsection
