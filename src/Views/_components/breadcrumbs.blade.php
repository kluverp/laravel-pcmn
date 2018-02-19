<nav aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb">
        @foreach($breadcrumbs as $url => $label)
            <li class="breadcrumb-item @if($loop->last) active @endif">
                @if($loop->last)
                    {{ $label }}
                @else
                    <a href="{{ $url }}">{{ $label }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>