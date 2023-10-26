@extends('layouts.backend')


@section('content')

<div class="">

    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title text-primary">Change Password</h3>
        </div>
        <div class="block-content block-content-full pt-4">
            @component('components.error')
                <!-- show error messages  --> 
            @endcomponent
            <form method="POST" action="change_password">
                @csrf
                
                <div class="form-group row mt-2">
                    <label for="password" class="col-md-3 col-form-label text-md-right">Current Password:</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <label for="password" class="col-md-3 col-form-label text-md-right">New Password:</label>

                    <div class="col-md-6">
                        <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password" minlength="12" maxlength="120">
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <label for="password" class="col-md-3 col-form-label text-md-right">Confirm Password:</label>

                    <div class="col-md-6">
                        <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                    </div>
                </div>

                <div class="form-group row my-4">
                    <div class="col-md-6 offset-md-3 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-sm btn-primary me-md-2" ><i class="fa fa-save me-1"></i>Submit</button>
                        <button type="button" class="btn btn-sm btn-secondary text-white" onclick="location.href='{{ route('users.index') }}'"><i class="fa fa-backward me-1"></i>Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
