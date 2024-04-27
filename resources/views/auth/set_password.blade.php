@extends('auth.layouts.master')
@section('title', __('auth_login'))
@section('content')

<!-- Start Content-->
<div class="card">
    <div class="card-body text-center">
        <div class="mb-4">
            <i class="feather icon-unlock auth-icon"></i>
        </div>
        <h3 class="mb-4">Admin Reset Password</h3>
        @include('web.student.inc.message')
        <!-- Form Start -->
        <form method="POST" action="{{ route('admin.password.set') }}">
            @csrf

            {{-- <input type="hidden" name="token" value="1322"> --}}
  
            <div class="input-group mb-3">
              <input id="staff_id" type="text" readonly class="form-control @error('staff_id') is-invalid @enderror" name="staff_id" value="{{ Auth::user()->staff_id ?? old('staff_id') }}" required>
  
              @error('staff_id')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>                  
            <div class="input-group mb-3">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="New Password">
  
              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
            <div class="input-group mb-4">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('field_confirm_password') }}">
            </div>
            <input type="submit" class="btn btn-primary shadow-2 mb-4" name="submit" value="{{ __('auth_reset') }}">
          </form>
        <!-- Form End -->

       
        @if (Route::has('student.register'))
        <p class="mb-0 text-muted">
            {{ __("auth_dont_have_account") }} 
            <a href="{{ route('student.register') }}">
                {{ __('auth_register') }}
            </a>
        </p>
        @endif

        @isset($setting->copyright_text)
        <p class="mb-0 text-muted">&copy; {!! strip_tags($setting->copyright_text, '<a><b><br>') !!}</p>
        @endisset
    </div>
</div>
<!-- End Content-->

@endsection