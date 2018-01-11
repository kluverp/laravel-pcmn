@extends('pcmn::_layouts.base')

@section('main')

    <div class="container auth">

        @include('pcmn::_components.messages')

        <form class="form-signin" action="{{ route('pcmn.login') }}" method="post">

            {{ csrf_field() }}

            {{-- title --}}
            <h2 class="form-signin-heading">@lang($transNamespace . 'title')</h2>

            {{-- username --}}
            <div class="form-group">
                <label for="inputEmail" class="sr-only">@lang('pcmn::login.form.email')</label>
                <input type="email" id="inputEmail"
                       class="form-control @if(!empty($errors) and $errors->has('email')) is-invalid @endif"
                       placeholder="@lang($transNamespace . 'form.email_placeholder')" value="{{ old('email') }}"
                       name="email" autofocus>
                <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                </div>
            </div>

            {{-- password --}}
            <div class="form-group">
                <label for="inputPassword" class="sr-only">@lang($transNamespace . 'form.password')</label>
                <input type="password" id="inputPassword" name="password" class="form-control"
                       placeholder="@lang($transNamespace . 'form.password_placeholder')" required>
            </div>

            {{-- remember me --}}
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"
                               value="remember-me"> @lang($transNamespace . 'form.remember_me')
                    </label>
                </div>
            </div>

            {{-- submit --}}
            <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block"
                        type="submit">@lang($transNamespace . 'form.btn_submit')</button>
            </div>

            {{-- password forgotten link --}}
            <div class="form-group">
                <a href="{{ route('pcmn.login.forgotten') }}">@lang($transNamespace . 'password_forgotten')</a>
            </div>

        </form>

    </div> <!-- /container -->

@endsection
