@extends('auth.login_layout')
@section('title', __('common.login'))

@section('content')
  <div class="d-flex flex-column justify-content-center align-items-center">
  <div class="logo-container">
    <img src="{{ public_asset('/assets/img/logo_white.svg') }}" width="320" height="320">
    </div>
    <div class="card w-100" style="max-width: 400px;">
      <div class="card-body">
        <form method="post" action="{{ url('/login') }}" class="form">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">@lang('common.email') @lang('common.or') @lang('common.pilot_id')</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            @if ($errors->has('email'))
              <div class="text-danger">
                <strong>{{ $errors->first('email') }}</strong>
              </div>
            @endif
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">@lang('auth.password')</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            @if ($errors->has('password'))
              <div class="text-danger">
                <strong>{{ $errors->first('password') }}</strong>
              </div>
            @endif
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">@lang('common.login')</button>
          </div>

          @if(config('services.discord.enabled'))
            <div class="d-grid mt-3">
              <a href="{{ route('oauth.redirect', ['provider' => 'discord']) }}" class="btn" style="background-color:#738ADB;">
                @lang('auth.loginwith', ['provider' => 'Discord'])
              </a>
            </div>
          @endif

          @if(config('services.ivao.enabled'))
            <div class="d-grid mt-3">
              <a href="{{ route('oauth.redirect', ['provider' => 'ivao']) }}" class="btn" style="background-color:#0d2c99;">
                @lang('auth.loginwith', ['provider' => 'IVAO'])
              </a>
            </div>
          @endif

          @if(config('services.vatsim.enabled'))
            <div class="d-grid mt-3">
              <a href="{{ route('oauth.redirect', ['provider' => 'vatsim']) }}" class="btn" style="background-color:#29B473;">
                @lang('auth.loginwith', ['provider' => 'VATSIM'])
              </a>
            </div>
          @endif
        </form>
      </div>
      <div class="card-footer d-flex justify-content-between">
        <a href="{{ url('/register') }}" class="link">@lang('auth.createaccount')</a>
        <a href="{{ url('/password/reset') }}" class="link">@lang('auth.forgotpassword')?</a>
      </div>
    </div>
  </div>
@endsection
