<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('pcmn.dashboard') }}">
        <img src="{{ url('vendor/pcmn/img/pacman-logo_35x23.png') }}" width="35" height="23" alt="PCMN logo">
        PCMN
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pcmn.content.index', 'pcmn_user') }}">{{  __('pcmn::navbar.users') }}</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $user->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('pcmn.content.edit', ['pcmn_user', $user->id]) }}">{{ __('pcmn::navbar.profile') }}</a>
                    <a class="dropdown-item" href="{{ route('pcmn.logout') }}">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>