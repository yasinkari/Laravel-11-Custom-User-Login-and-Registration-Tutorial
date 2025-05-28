@extends('layout.layout')

@section('css')
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .profile-header {
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .profile-header h1 {
        font-size: 28px;
        font-weight: 600;
        color: #0f2c1f;
        margin-bottom: 0.5rem;
    }
    
    .profile-header p {
        color: #666;
    }
    
    .profile-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .profile-card-header {
        background-color: #0f2c1f;
        color: white;
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .profile-card-body {
        padding: 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
        color: #333;
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }
    
    .btn-update {
        background-color: #0f2c1f;
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-update:hover {
        background-color: #0a1f16;
        transform: translateY(-2px);
    }
    
    .password-link {
        display: inline-block;
        margin-top: 1rem;
        color: #0f2c1f;
        text-decoration: none;
        font-weight: 500;
    }
    
    .password-link:hover {
        text-decoration: underline;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 4px;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>My Profile</h1>
        <p>Manage your account information</p>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="profile-card">
        <div class="profile-card-header">
            <span>Personal Information</span>
        </div>
        <div class="profile-card-body">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="user_name" class="form-label">Name</label>
                    <input type="text" id="user_name" name="user_name" class="form-control @error('user_name') is-invalid @enderror" value="{{ old('user_name', $user->user_name) }}" required>
                    @error('user_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" class="form-control" value="{{ $user->email }}" disabled>
                    <small class="text-muted">Email cannot be changed</small>
                </div>
                
                <div class="form-group">
                    <label for="user_phone" class="form-label">Phone Number</label>
                    <input type="text" id="user_phone" name="user_phone" class="form-control @error('user_phone') is-invalid @enderror" value="{{ old('user_phone', $user->user_phone) }}" required>
                    @error('user_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="user_address" class="form-label">Address</label>
                    <textarea id="user_address" name="user_address" class="form-control @error('user_address') is-invalid @enderror" rows="3" required>{{ old('user_address', $user->user_address) }}</textarea>
                    @error('user_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn-update">Update Profile</button>
            </form>
            
            <a href="{{ route('profile.password.form') }}" class="password-link">Change Password</a>
        </div>
    </div>
</div>
@endsection