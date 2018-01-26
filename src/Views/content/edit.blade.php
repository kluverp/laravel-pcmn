@extends('pcmn::_layouts.default')

@section('content')

    @include('pcmn::_components.breadcrumbs')

    <h1>
        {{ $title }}
        <small class="text-muted">edit</small>
    </h1>

    <hr>

    @if(!empty($description))
        <p class="lead">
            {{ $description }}
        </p>
    @endif

    {!! $form->html() !!}

@endsection
