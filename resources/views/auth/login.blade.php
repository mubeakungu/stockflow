@extends('layouts.auth-layout')

@section('title', 'Login')

@section('form')

@if (session('status'))
<div class="alert alert-primary" role="alert">
    {{ session('status') }}
</div>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="form-group mb-3">
        <input type="email" class="form-control @error('email') is-invalid @enderror" id=" Email"
            placeholder="Email address" value="{{ old('email') }}" required autocomplete="email" name="email" autofocus>
        @error('email')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group mb-4 position-relative">
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="Password"
            placeholder="Password" name="password" required autocomplete="current-password">
        <button type="button" class="btn btn-sm position-absolute" id="togglePassword" 
            style="right: 10px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; z-index: 10;">
            <i class="fas fa-eye"></i>
        </button>
    </div>
    <div class="custom-control custom-checkbox text-left mb-4 mt-2">
        <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember">
        <label class="custom-control-label" for="customCheck1">Save credentials.</label>
    </div>
    <button class="btn btn-block btn-primary mb-4">Signin</button>
</form>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('Password');
    const toggleIcon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
});
</script>
<hr>
<p class="mb-2 text-muted">
    Forgot password?
    <a href="{{ route('password.request') }}" class="f-w-400">Reset</a>
</p>
@endsection