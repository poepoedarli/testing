@extends('applications.management.index')
@section('application-management-content')
    <div class="row items-push">
        <div class="col-6">
            <div class="block block-rounded h-100 block-bordered mb-0 pb-0" href="javascript:void(0)">
                <div class="block-content block-content-full text-start bg-body-light">
                    <div class="">
                        <p class="fw-semibold mb-0">
                            {{ $application->name }}
                            <i
                                class="fa fa-circle fs-s mb-0 ms-1 {{ $application->status ? 'text-success' : 'text-secondary' }}"></i>
                        </p>
                    </div>
                </div>
                <div class="block-content block-content-full text-start">
                    <div class="row g-sm">
                        <div class="col-12">
                            <p class="text-muted mb-0"> {{ $application->short_description }}
                            </p>
                        </div>
                        <div class="col-12">
                            <p class="text-muted mb-0">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 fs-md fw-semibold">
            <div class="block block-rounded h-100 block-bordered mb-0 pb-0">
                <div class="block-content">
                    <table aria-describedby="mydesc" class="table table-borderless table-striped">
                        <tbody>
                            <tr>
                                <td class="fw-medium text-muted">
                                    <i class="fa fa-fw fa-signal me-1"></i>
                                    {{ ucwords($application->state) }}
                                </td>
                            </tr>
                            {{-- <tr>
                                <td>
                                    <i class="fa fa-fw fa-asterisk me-1"></i>
                                    {{ $application->ref_no }}
                                </td>
                            </tr> --}}
                            <tr>
                                <td>
                                    <i class="fa fa-fw fa-link me-1"></i>
                                    @if ($application->documentation_link)
                                        <a class="link-fx" href="{{ $application->documentation_link }}" rel="noopener">
                                            {{ $application->documentation_link }} </a>
                                    @else
                                        <a class="text-muted fs-sm">-</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-medium text-muted">
                                    <i class="fa fa-fw fa-calendar me-1"></i>
                                    <a href="/users/{{ $application->creator_id }}">
                                        {{ $application->application_creator->name }}
                                    </a> on
                                    {{ \Carbon\Carbon::parse($application->updated_at)->format('d F Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td> <i class="fa fa-note-sticky me-1"></i> 
                                    {{ $application->remarks }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row items-push">
        @if ($carousel)
            <div class="col-12">
                <div class="block block-rounded block-bordered mb-0 pb-0">
                    <div class="block-header block-header-default">
                        <div class="fs-md fw-semibold">
                            <i class="fa-regular fa-images me-1"></i> Web Page Screenshots
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        {!! $carousel !!}
                    </div>
                </div>
            </div>
        @endif

        <div class="col-12">
            <div class="block block-rounded block-bordered mb-0 pb-0">
                <div class="block-header block-header-default">
                    <div class="fs-md fw-semibold">
                        <i class="fa fa-box-open me-1"></i> Container Information
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <table aria-describedby="mydesc" class="table table-borderless">
                        <tbody>
                            <tr>
                                <th class="fw-medium">
                                    Host Port: {{ $application->host_port }}
                                </th>
                                <th class="fw-medium">
                                    Container Port: {{ $application->container_port }}
                                </th>
                                <th class="fw-medium">
                                    Timeout: {{ $application->timeout }}
                                </th>
                            </tr>
                            <tr>
                                <td class="fw-medium">
                                    Memory Limit: {{ $application->memory_limit }}
                                </td>
                                <td class="fw-medium">
                                    CPU Limit: {{ $application->cpu_limit }}
                                </td>
                                <td class="fw-medium">
                                    GPU Limit: {{ $application->gpu_limit }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    {{ json_decode($application->container_info) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="block block-rounded block-bordered mb-0 pb-0">
                <div class="block-header block-header-default">
                    <div class="fs-md fw-semibold">
                        <i class="fa fa-clipboard-list me-1"></i>
                        Detailed Description
                    </div>
                </div>
                <div class="block-content block-content-full">
                    {!! $application->full_description !!}
                </div>
            </div>
        </div>
    </div>
@endsection
