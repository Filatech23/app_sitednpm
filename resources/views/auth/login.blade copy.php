@extends('layouts.app')

@section('content')


<div class="auth-page-wrapper pt-5 " >
    <!-- auth page bg -->
    <!-- <div class="auth-one-bg-position auth-one-bg"  id="auth-particles">
        <div class="bg-overlay"></div>
        
        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div> -->

    <!-- auth page content -->
    <div class="auth-page-content" >
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                        </div>
                        <!-- <p class="mt-3 fs-15 fw-medium" style="color:white">{{config('app.name')}}</p>
                        <p class="mt-3 fs-15 fw-medium">{{config('app.descrApp')}}</p> -->
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-left ">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">
                    <!-- auth-bg-cover -->
                        <div class="card-body p-4 ">  
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Bienvenue sur {{config('app.name')}} !</h5>
                                <p class="text-muted">Connectez-vous</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('E-mail') }}</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">{{ __('Mot de passe') }}</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 text-center">
                                        <button type="submit" class="btn btn-success w-100"> {{ __('Se connecter') }} </button>
                                        @if (Route::has('password.request'))
                                            <!-- <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Mot de passe oublié ?') }}
                                            </a> -->
                                        @endif
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                    <div class="mt-4 text-center">
                        <!-- <p class="mb-0">Vous n'avez pas de compte ?  <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline"> S'inscrire </a> </p> -->
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center" style="color:white;">
                    <p class="mb-0 text-muted"><span style="color:white;">&copy; <script>document.write(new Date().getFullYear())</script> {{config('app.name')}}.</span></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>

@endsection


