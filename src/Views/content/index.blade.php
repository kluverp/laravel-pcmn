@extends('pcmn::_layouts.default')

@section('content')

    @include('pcmn::_components.breadcrumbs')

    <h1>
        {{ $title }}
        <small class="text-muted">overzicht</small>
    </h1>

    <hr>

    @if(!empty($description))
        <p class="lead">
            {{ $description }}
        </p>
    @endif

    {!! $dataTable->html() !!}

@endsection


@section('scripts')

    <script type="text/javascript">

        $(document).ready(function () {

            {!! $dataTable->script() !!}

        });

    </script>

@endsection

