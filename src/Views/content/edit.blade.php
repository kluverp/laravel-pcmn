@extends('pcmn::_layouts.default')

@section('content')

    {{-- breadcrumbs trail --}}
    {!! $breadcrumbs->html() !!}

    {{-- page title --}}
    <h1>
        {{ $title }}
        <small class="text-muted">
            @if(!empty($model->id))
                @lang($transNs . '.edit')
            @else
                @lang($transNs . '.create')
            @endif
        </small>
        @if(!empty($model))
            <form class="mt-5 float-right"
                  action="{{ route($routeNs . '.destroy', [$config->getTable(), $model->id]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <button class="btn btn-danger btn-sm btn-destroy" type="button"
                        data-redirect="{{ route($routeNs . '.index', $config->getTable()) }}">
                    @lang($transNs . '.destroy')
                </button>
            </form>
        @endif
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
