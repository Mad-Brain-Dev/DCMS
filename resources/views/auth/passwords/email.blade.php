@extends('layouts.app')
@section('content')
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="bg-primary-theme">
                            <div class="text-primary text-center p-4">
                                <h5 class="text-white font-size-20 p-2">Forgot Password</h5>
                                <a href="index.html" class="logo logo-admin">
                                    <img src="{{ asset('admin/images/logo-sm.png') }}" height="40"
                                        alt="DCMS">
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="p-3">
                                <div class="alert alert-success mt-5" role="alert">
                                    Enter your Email and instructions will be sent to you!
                                </div>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="email"
                                            class="col-form-label text-md-end">{{ __('Email Address') }}</label>

                                        <div>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-0 text-center">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-dark">
                                                {{ __('Send Password Reset Link') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>

                    <div class="mt-5 text-center">
                        <p> <a href="{{ route('login') }}" class="fw-medium text-primary text-decoration-none"> Sign In here
                            </a> </p>
                        <div>
                            © 2024 Narkose Wien <span class="d-none d-sm-inline-block"> -
                                Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://madbrain.dev"
                                    target="_blank" class="text-dark">Mad Brain</a>.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
