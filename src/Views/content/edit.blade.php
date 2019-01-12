@extends('pcmn::_layouts.default')

@section('content')

    {{-- breadcrumbs trail --}}
    {!! $breadcrumbs->html() !!}

    {{-- page title --}}
    <h1>
        {{ $title }}
        <small class="text-muted">@lang($transNs . '.edit')</small>
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

    {{-- xref datatables --}}
    @if(isset($datatables))
        <div class="xrefs">
            @foreach($datatables as $datatable)
                <h2>
                    {{ $datatable->title() }}
                    <small class="text-muted">@lang($transNs . '.index')</small>
                </h2>
                @if(!empty($description))
                    <p class="lead">
                        {{ $description }}
                    </p>
                @endif
                <hr>
                {!! $datatable->html() !!}
            @endforeach
        </div>
    @endif

@endsection
