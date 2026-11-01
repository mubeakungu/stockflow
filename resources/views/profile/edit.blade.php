@extends('layouts.layout')
@section('title', 'Edit Profile')

@section('main')
    <form method="POST" action="{{ route('profile.update') }}">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-8">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-header">
                        <h5>Edit Profile</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <h6 class="mb-3">Change Password (Optional)</h6>

                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                    id="current_password" name="current_password" 
                                    placeholder="Enter current password (required to change password)">
                                <button type="button" class="btn btn-sm position-absolute togglePassword" 
                                    data-target="current_password"
                                    style="right: 10px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; z-index: 10;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    id="password" name="password" placeholder="Leave empty to keep current password">
                                <button type="button" class="btn btn-sm position-absolute togglePassword" 
                                    data-target="password"
                                    style="right: 10px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; z-index: 10;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control" 
                                    id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                                <button type="button" class="btn btn-sm position-absolute togglePassword" 
                                    data-target="password_confirmation"
                                    style="right: 10px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; z-index: 10;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.togglePassword').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});
</script>
@endpush
