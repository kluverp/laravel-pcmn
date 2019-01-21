<table class="table datatable" data-table="{{ $config->getTable() }}" data-columns='{!!json_encode($data)!!}'
       data-url="{{ route($routeNs . ".index", $config->getTable()) }}"
       @if(isset($model))data-parent-table="{{ $model->getTable() }}" data-parent-id="{{ $model->getId() }}" @endif>
    <thead>
    <tr>
        @foreach($thead as $th)
            <th>{!! $th !!}</th>
        @endforeach
        <th>
            @if($config->canCreate())
                <div class="text-right">
                    @if(isset($model))
                        <a href="{{ route('pcmn.content.create', [$config->getTable(), $model->getId(), $model->getTable()]) }}"
                           class="btn btn-success btn-sm">
                            @lang($transNs . '.actions.create')
                        </a>
                    @else
                        <a href="{{ route('pcmn.content.create', $config->getTable()) }}"
                           class="btn btn-success btn-sm">
                            @lang($transNs . '.actions.create')
                        </a>
                    @endif
                </div>
            @endif
        </th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>