@extends('layouts.backend')


@section('content')
<div class="content">
    
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title text-primary">Create Permission</h3>
        </div>
        <div class="block-content block-content-full pt-4">
            @component('components.error')
                <!-- show error messages  --> 
            @endcomponent
            

            {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                    <div class="form-group">
                        <strong>Sync with Roles:</strong>
                        <p class="mb-2"></p>
                        @foreach($roles as $value)
                            <label>{{ Form::checkbox('role[]', $value->id, false, array('class' => 'name')) }}
                            {{ $value->name }}</label>
                        <br/>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-12 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-sm btn-primary me-md-2" ><i class="fa fa-save me-1"></i>Submit</button>
                    <button type="button" class="btn btn-sm btn-secondary text-white" onclick="location.href='{{ route('permissions.index') }}'"><i class="fa fa-backward me-1"></i>Cancel</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection