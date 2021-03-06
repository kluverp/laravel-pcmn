<div class="list-group">

    @foreach($menu as $item)
        <a href="#"
           class="list-group-item d-flex justify-content-between align-items-center list-group-item-action list-group-item-secondary">
            @if(!empty($item['label']))
                {{ $item['label'] }}
            @else
                &lt;missing label&gt;
            @endif
        </a>
        @if(!empty($item['tables']))
            <div class="list-group">
                @foreach($item['tables'] as $table)
                    <a href="@if(!empty($table['url'])){{ $table['url'] }}@else#@endif"
                       class="list-group-item d-flex justify-content-between align-items-center list-group-item-action @if($loop->last)last @endif">
                        @if(!empty($table['label']))
                            {{ $table['label'] }}
                        @endif
                        @if(!empty($table['records']))
                            <span class="badge badge-secondary badge-pill">{{ $table['records'] }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    @endforeach

</div>
