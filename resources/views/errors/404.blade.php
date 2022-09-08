@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-6">

                <div class="card">
                    <div class="card-body p-4 text-center">

                        <h1 class="fw-bold">404</h1>

                        <p class="lead text-uppercase">Page not found</p>

                        <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
