<div class="text-right">
    @if($config->canShow())
        <a class="btn btn-default btn-sm" href="{{ route($routeNs . '.show', [$config->getTable(), $rowId]) }}">
            @lang($transNs . '.actions.show')
        </a>
    @endif
    @if($config->canEdit())
        <a class="btn btn-primary btn-sm" href="{{ route($routeNs . '.edit', [$config->getTable(), $rowId]) }}">
            @lang($transNs . '.actions.edit')
        </a>
    @endif
    @if($config->canDestroy())
            <form action="" method="post">
                    <input type="hidden" name="_method" value="delete">
                    {{ csrf_field() }}
        <button class="btn btn-danger btn-sm" href="{{ route($routeNs . '.destroy', [$config->getTable(), $rowId]) }}">
            @lang($transNs . '.actions.destroy')
        </button>
            </form>
    @endif
</div>