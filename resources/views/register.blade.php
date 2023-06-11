@extends('layouts.master')
@section('content')
<main class="register">
    <div class="container mx-auto my-5 form-register">
        <form action="{{route('register.action')}}" class="row" method="POST" enctype="multipart/form-data" role="form">
            <div class="col-md-12 mb-4 text-center">
                <h1 class="display-2">
                    <a href="/" class="text-decoration-none text-dark"><i class="bi bi-camera2"></i></a>
                </h1>
                <small class="text-muted fs-6">Do you already have an account? <a class="text-dark fw-bold" href="{{url('login')}}">Login</a></small>
            </div>
            @csrf
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
                <!--Notif error-->
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{old('username')}}">
                <!--Notif error-->
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
                <!--Notif error-->
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="{{old('confirm_password')}}">
                <!--Notif error-->
                @error('confirm_password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-12">
                <button class="w-100 btn btn-md btn-dark" type="submit">Register</button>
            </div>
        </form>
    </div>
    
</main>
@endsection