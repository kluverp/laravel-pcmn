@extends('pcmn::_layouts.base')

@section('main')

    <div class="container">

        @include('pcmn::_components.messages')

        <form class="form-signin" action="{{ route('pcmn.login.reset', $token) }}" method="post">

            {{ csrf_field() }}

            {{-- title --}}
            <h2 class="form-signin-heading">@lang('pcmn::login.title_reset')</h2>

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
                <input type="password" id="inputPassword" name="password" class="form-control @if(!empty($errors) and $errors->has('password')) is-invalid @endif" placeholder="@lang('pcmn::login.form.password_placeholder')" required>
                <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                </div>
            </div>

            {{-- password confirmation --}}
            <div class="form-group">
                <label for="inputPasswordConfirm" class="sr-only">@lang('pcmn::login.form.password')</label>
                <input type="password" id="inputPasswordConfirm" name="password_confirmation" class="form-control @if(!empty($errors) and $errors->has('password_confirmation')) is-invalid @endif" placeholder="@lang('pcmn::login.form.password_placeholder')" required>
                <div class="invalid-feedback">
                    {{ $errors->first('password_confirmation') }}
                </div>
            </div>

            {{-- submit --}}
            <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block" type="submit">@lang('pcmn::login.form.btn_submit')</button>
            </div>

        </form>

    </div> <!-- /container -->

@endsection
