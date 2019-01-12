<table class="table datatable" data-table="{{ $config->getTable() }}" data-columns='{!!json_encode($data)!!}' data-url="{{ route($routeNs . ".index", $config->getTable()) }}">
    <thead>
    <tr>
    @foreach($thead as $th)
        <th>{!! $th !!}</th>
    @endforeach
    <th>
        @if($config->canCreate())
            <div class="text-right">
                <a href="{{ route('pcmn.content.create', $config->getTable()) }}" class="btn btn-success btn-sm">
                    @lang($transNs . '.actions.create')
                </a>
            </div>
        @endif
    </th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>