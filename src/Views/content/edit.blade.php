@extends('pcmn::_layouts.default')

@section('content')

    {{-- breadcrumbs trail --}}
    {!! $breadcrumbs->html() !!}

    {{-- page title --}}
    <h1>
        {{ $title }}
        <small class="text-muted">edit</small>
    </h1>

    <hr>

    {{-- page description --}}
    @if(!empty($description))
        <p class="lead">
            {{ $description }}
        </p>
    @endif

    {{-- the genereated form --}}
    {!! $form->html() !!}

@endsection
