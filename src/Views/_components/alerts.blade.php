@if($errors->count())
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>
@endif


@if (session('alert_info'))
    <div class="alert alert-info" role="alert">
        {{ session('alert_info') }}
    </div>
@endif

@if (session('alert_success'))
    <div class="alert alert-success" role="alert">
        {{ session('alert_success') }}
    </div>
@endif

@if (session('alert_warning'))
    <div class="alert alert-warning" role="alert">
        {{ session('alert_warning') }}
    </div>
@endif

@if (session('alert_danger'))
    <div class="alert alert-danger" role="alert">
        {{ session('alert_danger') }}
    </div>
@endif
