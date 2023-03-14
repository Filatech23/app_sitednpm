@extends('layouts.general')

@section('content')

    <div class="col-xxl-12">
        <div class="card">
            <div class="card-body">
                <div class="mt-3 text-center">
                    <h1 class="display-6">Bienvenue sur l'espace d'administration du site <br> {{ config('app.name') }}</h1>
                    
                    <!-- Buttons Grid -->
                    <div class="w-lg" >
                        <a href="/" class="btn btn-success">
                            Accéder au site
                        </a>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
@endsection
