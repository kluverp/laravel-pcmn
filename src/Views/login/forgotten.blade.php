@extends('pcmn::_layouts.base')

@section('main')

    <div class="container">

        <img class="mx-auto d-block" src="http://placehold.it/30x50" width="" height="" alt="pcmn logo" />

        @include('pcmn::_components.messages')

        <form class="form-forgotten" action="{{ route('pcmn.auth.forgotten') }}" method="post">

            {{ csrf_field() }}

            {{-- title --}}
            <h2 class="form-signin-heading">@lang($transNamespace . 'title_forgotten')</h2>

            <p>@lang('pcmn::login.texts.forgotten')</p>

            {{-- username --}}
            <div class="form-group">
                <label for="inputEmail" class="sr-only">@lang('pcmn::login.form.email')</label>
                <input type="email" id="inputEmail" class="form-control @if(!empty($errors) and $errors->has('email')) is-invalid @endif" placeholder="@lang('pcmn::login.form.email_placeholder')" value="{{ old('email') }}" name="email"  autofocus>
                <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                </div>
            </div>

            {{-- submit --}}
            <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block" type="submit">@lang('pcmn::login.form.btn_forgotten')</button>
            </div>

        </form>

    </div> <!-- /container -->

@endsection
