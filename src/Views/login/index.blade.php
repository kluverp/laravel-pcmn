@extends('pcmn::_layouts.base')

@section('main')

<div class="container">

    @include('pcmn::_components.messages')

    <form class="form-signin" action="{{ route('pcmn.login') }}" method="post">

        {{ csrf_field() }}

        {{-- title --}}
        <h2 class="form-signin-heading">@lang('pcmn::login.title')</h2>

        {{-- username --}}
        <div class="form-group">
            <label for="inputEmail" class="sr-only">@lang('pcmn::login.form.email')</label>
            <input type="email" id="inputEmail" class="form-control @if(!empty($errors) and $errors->has('email')) is-invalid @endif" placeholder="@lang('pcmn::login.form.email_placeholder')" value="{{ old('email') }}" name="email"  autofocus>
            <div class="invalid-feedback">
                {{ $errors->first('email') }}
            </div>
        </div>

        {{-- password --}}
        <div class="form-group">
            <label for="inputPassword" class="sr-only">@lang('pcmn::login.form.password')</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="@lang('pcmn::login.form.password_placeholder')" required>
        </div>

        {{-- remember me --}}
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" value="remember-me"> @lang('pcmn::login.form.remember_me')
                </label>
            </div>
        </div>

        {{-- submit --}}
        <button class="btn btn-lg btn-primary btn-block" type="submit">@lang('pcmn::login.form.btn_submit')</button>

    </form>

</div> <!-- /container -->

@endsection
