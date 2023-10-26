@extends('layouts.backend')


@section('content')

<div class="">

    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title text-primary">Create User</h3>
        </div>
        <div class="block-content block-content-full pt-4">
            @component('components.error')
                <!-- show error messages  --> 
            @endcomponent

            {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
            <div class="row mx-4">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Email:</strong>
                        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 mt-2">
                    <div class="form-group">
                        <strong>Country Code:</strong>
                        {!! Form::select('country_code', $country_codes, "+65", ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 mt-2">
                    <div class="form-group">
                        <strong>Mobile:</strong>
                        {!! Form::number('phone', null, array('placeholder' => '99999999','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Password:</strong>
                        <input id="password" type="password" class="form-control" name="password" autocomplete="password" minlength="12" maxlength="120">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Confirm Password:</strong>
                        {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Role:</strong>
                        {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Department:</strong>
                        {!! Form::select('department_id', $departments,"", array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-sm-12 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-sm btn-primary me-md-2" ><i class="fa fa-save me-1"></i>Submit</button>
                    <button type="button" class="btn btn-sm btn-secondary text-white" onclick="location.href='{{ route('users.index') }}'"><i class="fa fa-backward me-1"></i>Cancel</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection