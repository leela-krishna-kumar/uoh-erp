@extends('auth.layouts.master')
@section('title', __('auth_login'))
@section('content')


<div class="row">
    <div class="card mb-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="feather icon-unlock auth-icon"></i>
                    <h3 class="mb-4">{{ __('auth_login_title') }}</h3>
                    @include('web.student.inc.message')
                    <!-- Form Start -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input id="staff_id" type="text" class="form-control @error('staff_id') is-invalid @enderror" name="staff_id" value="{{ old('staff_id') }}" required autocomplete="staff_id" placeholder="Staff ID" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-4">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('field_password') }}">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <div class="checkbox checkbox-fill d-inline">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="cr" for="remember">
                                    {{ __('field_remember') }}
                                </label>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary shadow-2 mb-4" name="submit" value="{{ __('auth_login') }}">
                    </form>
                    <!-- Form End -->
                    @if (Route::has('student.password.request'))
                        <p class="mb-2 text-muted">
                            <a href="{{ 'password/reset' }}">
                                {{ __('auth_forgot_password') }}
                            </a>
                        </p>
                    @endif

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

                    <!-- Content of the first card goes here -->
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4" >
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="feather icon-unlock auth-icon"></i>
                    <h3 class="mb-4">{{ __('student_login_title') }}</h3>
                    @include('web.student.inc.message')
                    <!-- Form Start -->
                    <form method="POST" action="{{ route('student.login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input id="roll_no" type="text" class="form-control @error('roll_no') is-invalid @enderror" name="roll_no" value="{{ old('roll_no') }}" required autocomplete="roll_no" placeholder="Roll Number" autofocus>

                            @error('roll_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-4">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('field_password') }}">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <div class="checkbox checkbox-fill d-inline">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="cr" for="remember">
                                    {{ __('field_remember') }}
                                </label>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary shadow-2 mb-4" name="submit" value="{{ __('auth_login') }}">
                    </form>
                    <!-- Form End -->
                    @if (Route::has('student.password.request'))
                        <p class="mb-2 text-muted">
                            <a href="{{ 'password/reset' }}">
                                {{ __('auth_forgot_password') }}
                            </a>
                        </p>
                    @endif

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
        </div>
    </div>
    <div class="card mb-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="feather icon-unlock auth-icon"></i>
                    <h3 class="mb-4">{{ __('student_login_title') }}</h3>
                    @include('web.student.inc.message')
                    <!-- Form Start -->
                    <form method="POST" action="{{ route('student.login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input id="roll_no" type="text" class="form-control @error('roll_no') is-invalid @enderror" name="roll_no" value="{{ old('roll_no') }}" required autocomplete="roll_no" placeholder="Roll Number" autofocus>

                            @error('roll_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-4">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('field_password') }}">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <div class="checkbox checkbox-fill d-inline">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="cr" for="remember">
                                    {{ __('field_remember') }}
                                </label>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary shadow-2 mb-4" name="submit" value="{{ __('auth_login') }}">
                    </form>
                    <!-- Form End -->
                    @if (Route::has('student.password.request'))
                        <p class="mb-2 text-muted">
                            <a href="{{ 'password/reset' }}">
                                {{ __('auth_forgot_password') }}
                            </a>
                        </p>
                    @endif

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
        </div>
    </div>
</div>


<!-- Start Content-->
{{-- <div class="card">
    <div class="card-body text-center">
        <div class="mb-4">
            <i class="feather icon-unlock auth-icon"></i>
        </div>
        <h3 class="mb-4">{{ __('student_login_title') }}</h3>
        @include('web.student.inc.message')
        <!-- Form Start -->
        <form method="POST" action="{{ route($loginRoute) }}">
            @csrf
            <div class="input-group mb-3">
                <input id="roll_no" type="text" class="form-control @error('roll_no') is-invalid @enderror" name="roll_no" value="{{ old('roll_no') }}" required autocomplete="roll_no" placeholder="Roll Number" autofocus>

                @error('roll_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-4">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('field_password') }}">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group text-left">
                <div class="checkbox checkbox-fill d-inline">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="cr" for="remember">
                        {{ __('field_remember') }}
                    </label>
                </div>
            </div>
            <input type="submit" class="btn btn-primary shadow-2 mb-4" name="submit" value="{{ __('auth_login') }}">
        </form>
        <!-- Form End -->
        @if (Route::has('student.password.request'))
            <p class="mb-2 text-muted">
                <a href="{{ 'password/reset' }}">
                    {{ __('auth_forgot_password') }}
                </a>
            </p>
        @endif

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
<div class="card">
    <div class="card-body text-center">
        <div class="mb-4">
            <i class="feather icon-unlock auth-icon"></i>
        </div>
        <h3 class="mb-4">{{ __('student_login_title') }}</h3>
        @include('web.student.inc.message')
        <!-- Form Start -->
        <form method="POST" action="{{ route($loginRoute) }}">
            @csrf
            <div class="input-group mb-3">
                <input id="roll_no" type="text" class="form-control @error('roll_no') is-invalid @enderror" name="roll_no" value="{{ old('roll_no') }}" required autocomplete="roll_no" placeholder="Roll Number" autofocus>

                @error('roll_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-4">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('field_password') }}">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group text-left">
                <div class="checkbox checkbox-fill d-inline">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="cr" for="remember">
                        {{ __('field_remember') }}
                    </label>
                </div>
            </div>
            <input type="submit" class="btn btn-primary shadow-2 mb-4" name="submit" value="{{ __('auth_login') }}">
        </form>
        <!-- Form End -->
        @if (Route::has('student.password.request'))
            <p class="mb-2 text-muted">
                <a href="{{ 'password/reset' }}">
                    {{ __('auth_forgot_password') }}
                </a>
            </p>
        @endif

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
</div> --}}
<style>
.custom-row {
    /* Custom row styling */
    max-width: 1200px; /* Increase the width of the row */
    margin: 0 auto; /* Center the row horizontally */
}

.custom-card {
    /* Custom card styles */
    background-color: #f2f2f2;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}

.custom-card .card-body {
    /* Customize card body styles */
}

.custom-card .mb-4 {
    /* Customize margin-bottom for inner content */
}

</style>
@endsection
