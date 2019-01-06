@extends('pcmn::_layouts.default')

@section('content')

    {{-- breadcrumbs trail --}}
    {!! $breadcrumbs->html() !!}

    {{-- page title --}}
    <h1>
        {{ $title }}
        <small class="text-muted">edit</small>
    </h1>

    {{-- page description --}}
    @if(!empty($description))
        <p class="lead">
            {{ $description }}
        </p>
    @endif

    <hr>

    {{-- the genereated form --}}
    {!! $form->html() !!}

    @foreach($datatables as $datatable)
        <h2>{{$datatable->title()}}</h2>
        {!! $datatable->html() !!}
    @endforeach

@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function () {
            @foreach($datatables as $datatable)
                {!! $datatable->script() !!}
            @endforeach
        });
    </script>

@endsection
