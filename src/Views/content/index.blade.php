@extends('pcmn::_layouts.default')

@section('content')

    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol>
    </nav>

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

