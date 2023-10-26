@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible fade show mb-0 mt-2" id="session-msg">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if ($message = Session::get('warning'))
<div class="alert alert-danger alert-dismissible fade show mb-0 mt-2" id="session-msg">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="mt-2" id="status-message" >
    
</div>
