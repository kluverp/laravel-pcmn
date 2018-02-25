@extends('pcmn::_layouts.default')

@section('content')

    {{-- breadcrumbs trail --}}
    {!! $breadcrumbs->html() !!}

    <p class="dashboard-ready text-center text-muted">Get ready!</p>
@endsection


