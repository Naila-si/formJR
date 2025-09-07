<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form CRM / DTD Cabang Riau</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to bottom right, #eff6ff, #ffffff);
      color: #333;
      transition: opacity 0.6s ease;
    }

    /* Navbar */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 60px;
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 700;
      color: #1e3a8a;
      font-size: 18px;
    }

    .logo img {
      height: 40px;
    }

    .nav-buttons {
      display: flex;
      gap: 12px;
    }

    .btn {
      padding: 8px 18px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-login {
      background-color: #e0f2fe;
      color: #075985;
    }

    .btn-login:hover {
      background-color: #bae6fd;
    }

    .btn-register {
      background-color: #1e3a8a;
      color: white;
    }

    .btn-register:hover {
      background-color: #1d4ed8;
    }

    /* Main */
    main {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 80px 100px;
      gap: 40px;
    }

    .content {
      max-width: 550px;
      animation: fadeInUp 1s ease-in-out;
    }

    h1 {
      font-size: 38px;
      font-weight: 800;
      margin-bottom: 15px;
      color: #1e293b;
      line-height: 1.2;
    }

    p {
      color: #475569;
      margin-bottom: 30px;
      font-size: 16px;
    }

    .btn-start {
      background-color: #1e3a8a;
      color: white;
      padding: 14px 36px;
      font-size: 16px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(30,58,138,0.3);
      transition: transform 0.2s ease, background-color 0.3s ease;
    }

    .btn-start:hover {
      background-color: #1d4ed8;
      transform: translateY(-3px);
    }

    .illustration img {
      max-width: 320px;
      filter: drop-shadow(0 6px 12px rgba(0,0,0,0.1));
    }

    /* Animasi */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Responsif */
    @media (max-width: 900px) {
      main {
        flex-direction: column;
        text-align: center;
        padding: 60px 30px;
      }
      .illustration img {
        margin-top: 30px;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:40px;">
    </div>
    <div class="nav-buttons">
        <a href="{{ route('login') }}">
            <button class="btn btn-login">Login</button>
        </a>
        <a href="{{ route('register') }}">
            <button class="btn btn-register">Register</button>
        </a>
    </div>
  </header>

  <main>
    <div class="content">
      <h1>FORM CRM / DTD CABANG RIAU</h1>
      <p>Please register to be a part of the event.</p>
        <a href="{{ route('formulir.index') }}">
            <button class="btn-start" id="btnStart">Start</button>
        </a>
    </div>
    <div class="illustration">
        <img src="{{ asset('images/logo-bulat.png') }}" alt="Logo">
    </div>
  </main>
  <script>
    document.getElementById('btnStart').addEventListener('click', function() {
        // Fade out body
        document.body.style.transition = 'opacity 0.6s ease';
        document.body.style.opacity = '0';

        // Setelah fade selesai, redirect ke halaman form
        setTimeout(function() {
            window.location.href = "{{ route('formulir.index') }}";
        }, 600); // durasi sama dengan transition
    });
</script>
</body>
</html>
