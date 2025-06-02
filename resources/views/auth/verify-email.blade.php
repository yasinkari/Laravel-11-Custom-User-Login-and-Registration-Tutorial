<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify Email</title>
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
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 2rem;
    }
    .form-container {
      width: 500px;
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      text-align: center;
    }
    .form-container img {
      margin-bottom: 1rem;
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
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="content-wrapper">
      <div class="form-container">
        <img src="{{asset('image/IMG_7281-removebg-preview.png')}}" width="100px" alt="Logo">
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        <h2 class="mb-3">Verify Your Email Address</h2>
        <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?</p>
        <p>If you didn't receive the email, we will gladly send you another.</p>
        
        <form method="POST" action="{{ route('verification.send') }}">
          @csrf
          <button type="submit" class="btn btn-primary w-100">Resend Verification Email</button>
        </form>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Auto-dismiss alerts after 5 seconds
    window.setTimeout(function() {
      document.querySelectorAll('.alert').forEach(function(alert) {
        var bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      });
    }, 5000);
  </script>
</body>
</html>