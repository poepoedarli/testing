@php
    $application = json_decode($application);
    $memory_limit = $application->memory_limit;
    $cpu_usage = $gpu_usage = $memory_usage = 0;
    $cpu_data_percentage = $gpu_data_percentage = $memory_data_percentage = 0;

    $resource_usages = json_decode($resource_usages);
    if(!is_null($resource_usages)){
        $cpu_usage = $resource_usages->cpu_usage;
        $gpu_usage = $resource_usages->gpu_usage;
        $memory_usage = $resource_usages->memory_usage;

        $cpu_data_percentage = $resource_usages->cpu_usage;
        $gpu_data_percentage = $resource_usages->gpu_usage;
        if($memory_limit>0 && $memory_usage>0){
            $memory_data_percentage = $memory_usage/$memory_limit * 100;
        }
        
    }
@endphp

@if (!is_null($application))
    <div class="row mb-2">
        <div class="col-4">
            <!-- Pie Chart Container -->
            <div class="js-pie-chart pie-chart" data-percent="{{$memory_data_percentage}}" data-line-width="3"
                data-size="70" data-bar-color="#6f89c0" data-track-color="#e9e9e9">
                <span>{{$memory_usage}}GB</span>
            </div>
            <p class="fw-medium text-muted mt-2 mb-0 text-center">
                Memory Usage
            </p>
        </div>
        <div class="col-4">
            <!-- Pie Chart Container -->
            <div class="js-pie-chart pie-chart" data-percent="{{$cpu_data_percentage}}" data-line-width="3"
                data-size="70" data-bar-color="#6f89c0" data-track-color="#e9e9e9">
                <span>{{$cpu_usage}}%</span>
            </div>
            <p class="fw-medium text-muted mt-2 mb-0  text-center">
                CPU Usage
            </p>
        </div>
        <div class="col-4">
            <!-- Pie Chart Container -->
            <div class="js-pie-chart pie-chart" data-percent="{{$gpu_data_percentage}}" data-line-width="3"
                data-size="70" data-bar-color="#6f89c0" data-track-color="#e9e9e9">
                <span>{{$gpu_usage}}%</span>
            </div>
            <p class="fw-medium text-muted mt-2 mb-0 text-center">
                GPU Usage
            </p>
        </div>
    </div>
@endif


