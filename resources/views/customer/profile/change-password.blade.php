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
    
    .btn-cancel {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-right: 1rem;
    }
    
    .btn-cancel:hover {
        background-color: #5a6268;
    }
    
    .password-requirements {
        margin-top: 1rem;
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .password-requirements h4 {
        font-size: 16px;
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .password-requirements ul {
        padding-left: 1.5rem;
        margin-bottom: 0;
    }
    
    .password-requirements li {
        margin-bottom: 0.25rem;
        color: #666;
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Change Password</h1>
        <p>Update your password to keep your account secure</p>
    </div>
    
    <div class="profile-card">
        <div class="profile-card-header">
            <span>Password Update</span>
        </div>
        <div class="profile-card-body">
            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                    @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>
                
                <div class="password-requirements">
                    <h4>Password Requirements:</h4>
                    <ul>
                        <li>At least 8 characters long</li>
                        <li>Must contain at least one uppercase letter</li>
                        <li>Must contain at least one lowercase letter</li>
                        <li>Must contain at least one number</li>
                        <li>Must contain at least one special character</li>
                    </ul>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('profile.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-update">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection