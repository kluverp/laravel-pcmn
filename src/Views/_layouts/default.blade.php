@extends('_layout.base)

@section('main')

    @include('pcmn::_components.navbar')

    <main role="main" class="container">

        <div class="container">
            <div class="row">
                <div class="col-4">
                    @include('pcmn::_components.sidebar')
                </div>
                <div class="col">
                    @yield('content')
                </div>
            </div>
        </div>

    </main><!-- /.container -->

@endsection