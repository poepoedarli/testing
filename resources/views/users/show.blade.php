@extends('layouts.backend')


@section('content')

<div class="">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title text-primary">User Profile</h3>
        </div>
        <div class="block-content block-content-full pt-4">
            @component('components.error')
                <!-- show error messages  --> 
            @endcomponent

            @component('components.message')
            <!-- show alert message  --> 
            @endcomponent


            {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" readonly class="form-control" value="{{$user->name}}" >
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="text" readonly class="form-control" value="{{$user->email}}" >
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 mt-2">
                    <div class="form-group">
                        <strong>Country Code:</strong>
                        <input type="text" readonly class="form-control" value="{{$user->country_code}}" >
                    </div>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 mt-2">
                    <div class="form-group">
                        <strong>Mobile:</strong>
                        <input type="text" readonly class="form-control" value="{{$user->phone}}" >
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Role:</strong>
                        @php
                        $user_roles = [];
                        $roles =  $user->roles ;
                        foreach ($roles as $role) {
                            $user_roles[] = $role->name;
                        }
                        @endphp
                        <input type="text" readonly class="form-control" value="{{implode(',', $user_roles)}}" >
                    </div>
                </div>

                <div class="col-sm-12 d-md-flex justify-content-md-end mt-4">
                    <button type="button" class="btn btn-sm btn-secondary text-white " onclick="location.href='/'"><i class="fa fa-backward me-1"></i>Back to Dashboard</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection