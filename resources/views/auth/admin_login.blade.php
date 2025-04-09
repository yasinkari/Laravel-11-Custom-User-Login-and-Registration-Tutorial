<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff8f6;
      font-family: 'Raleway', sans-serif;
      margin: 0;
      padding: 0;
    }
    .container-fluid {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .content-wrapper {
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: center;
      gap: 2rem;
    }
    .form-container {
      width: 400px;
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      text-align: center;
    }
    .form-container .standardized-image {
      width: 100px; /* Standardized width */
      height: 70px; /* Standardized height */
      object-fit: cover; /* Maintain aspect ratio, cover the area */
      margin-bottom: 1rem;
    }

    .form-container img {
      margin-bottom: 1rem;
    }
    .form-container h2 {
      margin-top: 0.5rem;
    }
    .form-container .form-control {
      background-color: #fef7f5;
      border: none;
      border-radius: 8px;
      margin-bottom: 1rem;
    }
    .form-container .form-control:focus {
      border: 1px solid #ed6c63;
      box-shadow: none;
    }
    .form-container .btn-primary {
      background-color: #ed6c63;
      border: none;
      border-radius: 8px;
      padding: 0.75rem;
      font-weight: bold;
    }
    .form-container .btn-primary:hover {
      background-color: #d85950;
    }
    .illustration img {
      max-width: 450px;
      height: auto;
    }

  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="content-wrapper">
      <!-- Login Form -->
      <div class="form-container">
        <img src="{{ asset('image/IMG_7281-removebg-preview.png') }}" class="standardized-image" alt="Admin Logo">
        <p>Welcome, Admin!</p>
        <h2 class="mb-3">Admin Sign In</h2>
        <form method="POST" action="{{ route('admin.login.post') }}">
          @csrf
          @if (session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required>
          @error('email')
          <div class="text-danger">{{ $message }}</div>
          @enderror
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
          @error('password')
          <div class="text-danger">{{ $message }}</div>
          @enderror
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <input type="checkbox" id="remember" name="remember">
              <label for="remember" class="text-muted">Keep me logged in</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </form>
      </div>
      <!-- Illustration -->
      <div class="illustration">
        <img src="{{ asset('image/IMG_9880.jpg') }}" alt="Admin Dashboard Illustration">
      </div>
    </div>
  </div>
</body>
</html>
