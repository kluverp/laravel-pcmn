@extends('pcmn::_layouts.default')

@section('content')

    {{-- breadcrumbs trail --}}
    {!! $breadcrumbs->html() !!}

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

