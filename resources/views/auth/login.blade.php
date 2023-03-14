@extends('layouts.app')

@section('content')
<?php $log = \App\Models\GiwuSociete::logoSoc(); ?>
<div class="auth-fluid">
            <!--Auth fluid left content -->
            <div class="auth-fluid-form-box">
                <div class="align-items-center d-flex h-100">
                    <div class="card-body">

                        <!-- Logo -->
                        <div class="auth-brand text-center text-lg-left mb-0">
                            <div class="auth-logo">
                                <a href="/" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src={{url('assets/docs/logos/'.$log)}} alt="" height="">
                                    </span>
                                    <span class="logo-lg">
                                        <img src={{url('assets/docs/logos/'.$log)}} alt="" height="">
                                    </span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- title-->
                        <h4 class="mt-0">Connexion</h4>
                        <p class="text-muted mb-2">
                            Entrez votre adresse e-mail et votre mot de passe pour accéder au compte.
                        </p>
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
                        <!-- end form-->

                        <!-- Footer-->
                        <footer class="footer footer-alt">

                        </footer>

                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->

            <!-- Auth fluid right content -->
            <div class="auth-fluid-right text-center">
                <div class="auth-user-testimonial">
                    <h5 class="text-white">Powered by Filatech Technologies</h5>
                </div> <!-- end auth-user-testimonial-->
            </div>
            <!-- end Auth fluid right content -->
        </div>

@endsection


