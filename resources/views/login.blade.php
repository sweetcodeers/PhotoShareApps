@extends('layouts.master')
@section('content')
<main class="login">
    <div class="container mx-auto my-5 form-login">
        <form action="{{route('login.action')}}" class="row" method="POST" enctype="multipart/form-data" role="form">
            <div class="col-md-12 mb-4 text-center">
                <h1 class="display-2">
                    <a href="/" class="text-decoration-none text-dark"><i class="bi bi-camera2"></i></a>
                </h1>
                <small class="text-muted fs-6">
                    Don't have an account yet? <a class="text-dark fw-bold" href="{{url('register')}}">Register</a>
                </small>
            </div>
            @csrf
            @if(Session::has('success'))
                <div class="mb-2">
                    <small class="text-success">{!! Session::get('success') !!}</small>
                </div>
            @endif
            <div class="col-md-12 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
                <!--Notif error-->
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
                <!--Notif error-->
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-12">
                <button class="w-100 btn btn-md btn-dark" type="submit">Login</button>
            </div>
        </form>
    </div>
    
</main>
@endsection