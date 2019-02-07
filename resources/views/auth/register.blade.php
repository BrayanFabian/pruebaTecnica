@extends('layouts.app')

@section('content')
<div class="container-login100">
        <div class="wrap-login100">

          <form method="POST" action="{{ route('register') }}" class="login100-form" autocomplete="off">
            @csrf
            <span class="login100-form-title p-b-26">
						@lang('all.register')
					</span>
          <span class="login100-form-title p-b-48">
					</span>
          <div class="wrap-input100">
						<input class="input100" id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="@lang('all.name')" required>
						<span class="focus-input100"></span>
					</div>
          @if ($errors->has('name'))
              <div class="alert alert-danger">
                  <strong>{{ $errors->first('name') }}</strong>
              </div>
          @endif

          <div class="wrap-input100">
						<input class="input100" id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="@lang('all.email')" >
						<span class="focus-input100"></span>
					</div>
          @if ($errors->has('email'))
          <div class="alert alert-danger">
            <strong>{{ $errors->first('email') }}</strong>
          </div>
          @endif

          <div class="wrap-input100">
						<span class="btn-show-pass">
							<i class="far fa-eye"></i>
						</span>
						<input class="input100" id="password" type="password" name="password" placeholder="@lang('all.password')" required>
						<span class="focus-input100"></span>
					</div>
          @if ($errors->has('password'))
          <div class="alert alert-danger">
            <strong>{{ $errors->first('password') }}</strong>
          </div>
          @endif

          <div class="wrap-input100">
						<input class="input100" id="password_confirmation" type="password" name="password_confirmation" placeholder="@lang('all.password-confirm')" required>
						<span class="focus-input100"></span>
					</div>
          <div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
              <button type="submit" class="login100-form-btn">
                @lang('all.register')
              </button>
						</div>
					</div>
          </form>
  </div>
</div>
@endsection
