<div class="row items-push">
    <div class="block">
        <div class="block-header justify-content-start">
            <h4 class="block-title text-secondary">
                New Task
            </h4>
        </div>
        <div class="block-content block-content-full">
            {{-- Dataset Template Controller + Images Selection --}}
            @if (isset($parameters) && !is_null($parameters))
                @php
                    $form_controls = $parameters['form_controls'];
                @endphp
                {!! Form::open(['route' => ['dca_ma.store_new_task', $application->id], 'method' => 'POST', 'files' => true]) !!}
                <div class="row">
                    {!! $parameters['datasets_control'] !!}
                </div>

                @foreach ($form_controls as $key => $controls)
                    <div class="row">
                        @foreach ($controls as $control)
                            {!! $control !!}
                        @endforeach
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-sm-12 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-sm btn-primary me-md-2"><i
                                class="fa fa-save me-1"></i>Submit
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary "
                            onclick="location.href='{{ route('dca_ma.tasks', ['id' => $application->id]) }}'"><i
                                class="fa fa-backward me-1"></i>Cancel
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            @endif
        </div>
    </div>
</div>
