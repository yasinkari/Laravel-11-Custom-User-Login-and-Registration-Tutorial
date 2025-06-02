<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - NILL for MAN</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Inter', sans-serif;
      background: #ffffff; /* Changed to white background (no color) */
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }
    
    .main-container {
      display: flex;
      width: 90%;
      max-width: 1000px;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.2);
      position: relative;
      z-index: 1;
    }
    
    .left-section {
      flex: 1;
      background: url('{{asset("/image/IMG_7363.jpg")}}') center/cover no-repeat;
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 3rem;
    }
    
    .left-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.5));
    }
    
    .shop-menu {
      position: relative;
      z-index: 2;
      color: white;
    }
    
    .shop-menu h2 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
    }
    
    .shop-menu ul {
      list-style: none;
      padding: 0;
    }
    
    .shop-menu li {
      margin-bottom: 0.75rem;
    }
    
    .shop-menu li.featured {
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
    }
    
    .shop-menu li.featured::before {
      content: '—';
      margin-right: 0.5rem;
      color: rgba(255, 255, 255, 0.8);
    }
    
    .right-section {
      flex: 1;
      padding: 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    
    .brand-section {
      text-align: center; /* Changed from right to center */
      margin-bottom: 2.5rem;
    }
    
    .brand-logo {
      max-width: 200px;
      margin: 0 auto 1rem; /* Center the logo with auto margins */
    }
    
    .welcome-text {
      color: #000000; /* Changed to black */
      font-size: 0.95rem;
      font-weight: 400;
      margin-bottom: 0.5rem;
      opacity: 0.8;
    }
    
    .page-title {
      color: #000000; /* Changed to black */
      font-size: 1.75rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
    }
    
    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }
    
    .form-control {
      background: rgba(0, 0, 0, 0.05); /* Changed to black with low opacity */
      border: 2px solid rgba(0, 0, 0, 0.1); /* Changed to black with low opacity */
      border-radius: 12px;
      padding: 1rem 1.25rem;
      font-size: 0.95rem;
      font-weight: 400;
      color: #000000; /* Changed to black */
      transition: all 0.3s ease;
      width: 100%;
    }
    
    .form-control:focus {
      background: rgba(255, 255, 255, 0.9);
      border-color: #000000; /* Changed to black */
      box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1); /* Changed to black with low opacity */
      outline: none;
    }
    
    .form-control::placeholder {
      color: rgba(0, 0, 0, 0.5); /* Changed to black with medium opacity */
      font-weight: 400;
    }
    
    /* Keep the button styling the same */
    
    .remember-section label {
      color: #000000; /* Changed to black */
      font-weight: 400;
      display: flex;
      align-items: center;
    }
    
    .remember-section a {
      color: #000000; /* Changed to black */
      text-decoration: none;
      font-weight: 500;
    }
    
    .remember-section a:hover {
      text-decoration: underline;
    }
    
    .form-footer a {
      color: #000000; /* Changed to black */
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }
    
    .form-footer a:hover {
      color: #333333; /* Slightly lighter black on hover */
      text-decoration: underline;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #667eea, #764ba2); /* Changed from brown gradient to blue/purple */
      border: none;
      border-radius: 12px;
      padding: 1rem 2rem;
      font-size: 0.95rem;
      font-weight: 600;
      color: white;
      width: 100%;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3); /* Changed from brown to blue */
      background: linear-gradient(135deg, #5a67d8, #667eea); /* Changed hover gradient */
    }
    
    .btn-primary:active {
      transform: translateY(0);
    }
    
    .btn-primary .arrow {
      position: absolute;
      right: 1.5rem;
      top: 50%;
      transform: translateY(-50%);
    }
    
    .form-footer {
      text-align: center;
      margin-top: 2rem;
    }
    
    .form-footer a {
      color: #D2691E;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }
    
    .form-footer a:hover {
      color: #B8860B;
      text-decoration: underline;
    }
    
    .alert {
      border-radius: 12px;
      border: none;
      margin-bottom: 1.5rem;
      padding: 1rem 1.25rem;
      font-size: 0.9rem;
    }
    
    .alert-danger {
      background: rgba(220, 53, 69, 0.1);
      color: #721c24;
    }
    
    .alert-success {
      background: rgba(25, 135, 84, 0.1);
      color: #0f5132;
    }
    
    .remember-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      font-size: 0.9rem;
    }
    
    .remember-section label {
      color: rgba(139, 69, 19, 0.8);
      font-weight: 400;
      display: flex;
      align-items: center;
    }
    
    .remember-section input[type="checkbox"] {
      margin-right: 0.5rem;
    }
    
    .remember-section a {
      color: #D2691E;
      text-decoration: none;
      font-weight: 500;
    }
    
    .remember-section a:hover {
      text-decoration: underline;
    }
    
    @media (max-width: 768px) {
      .main-container {
        flex-direction: column;
        width: 95%;
        max-width: 480px;
      }
      
      .left-section {
        display: none;
      }
      
      .right-section {
        padding: 2rem;
      }
      
      .brand-section {
        text-align: center;
      }
      
      .page-title {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="main-container">
    <div class="left-section">
      <div class="shop-menu">
        <h2>Shop</h2>
        <ul>
          <li class="featured">New Arrivals</li>
        </ul>
      </div>
    </div>
    
    <div class="right-section">
      <div class="brand-section">
        <img src="/image/IMG_7281-removebg-preview.png" alt="NILL for MAN PREMIUM" class="brand-logo">
      </div>
      
      <div class="welcome-text">EXISTING MEMBER</div>
      <h1 class="page-title">Welcome Back!</h1>
      
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0 list-unstyled">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}">
        @csrf
        
        <div class="form-group">
          <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
        </div>
        
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
        </div>
        
        <div class="remember-section">
          <label>
            <input type="checkbox" <p style="color: #000000; margin-bottom: 0;"name="remember">
            Remember me
          </label>
          <a href="{{ route('password.request') }}"<p style="color: #000000; margin-bottom: 0;">Forgot password?</a>
        </div>
        
        <button type="submit" class="btn btn-primary">
          Continue
          <span class="arrow">→</span>
        </button>
      </form>
      
      <div class="form-footer">
        <p style="color: #000000; margin-bottom: 0;">Don't have an account? <a href="{{ route('register') }}"<p style="color: #000000; margin-bottom: 0;">Register Now</a></p>
      </div>
    </div>
  </div>
  
  <script>
    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(function(alert) {
        setTimeout(function() {
          alert.style.opacity = '0';
          setTimeout(function() {
            alert.remove();
          }, 300);
        }, 5000);
      });
    });
  </script>
</body>
</html>
