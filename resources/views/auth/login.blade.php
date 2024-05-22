@extends('layouts.auth')

@section('content')
<div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">{{ __('Sign in your account') }}</h4>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="mb-1"><strong>{{ __('Email Address') }}</strong></label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" class="form-control" autocomplete="current-password" name="password" >
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                    @if (Route::has('register'))
                                    <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="./register">Sign up</a></p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
