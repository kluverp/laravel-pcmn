@extends('pcmn::_layouts.default')

@section('content')

    {{-- breadcrumbs trail --}}
    {!! $breadcrumbs->html() !!}

    <h1>
        {{ $title }}
        <small class="text-muted">@lang($transNs . '.index')</small>
    </h1>

    @if(!empty($description))
        <p class="lead">
            @lang($description)
        </p>
    @endif

    <hr>

    {!! $dataTable->html() !!}

@endsection
