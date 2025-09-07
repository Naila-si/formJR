<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Formulir CRM')</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #c3ecf9 0%, #e0c3fc 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .container {
        max-width: 900px;
        background: #fff;
        padding: 40px 50px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        overflow: hidden;
    }
    h1 {
        margin-bottom: 30px;
        color: #5b3cc4;
        font-weight: 700;
        text-align: center;
        opacity: 0;
        transform: translateY(-20px);
        animation: fadeInUp 0.6s forwards 0.2s;
    }
    .form-group {
        position: relative;
        margin-bottom: 20px;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s forwards;
    }
    .form-group:nth-child(1) { animation-delay: 0.4s; }
    .form-group:nth-child(2) { animation-delay: 0.6s; }
    .form-group:nth-child(3) { animation-delay: 0.8s; }
    .form-control {
        padding-left: 40px;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(91,60,196,0.2);
        border-color: #5b3cc4;
    }
    .form-group i {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: #5b3cc4;
    }
    .btn-primary {
        background: linear-gradient(45deg, #5b3cc4, #c678dd);
        border: none;
        font-weight: 600;
        padding: 10px 25px;
        border-radius: 50px;
        transition: background 0.3s ease, transform 0.2s ease;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s forwards 1s;
    }
    .btn-primary:hover {
        background: linear-gradient(45deg, #c678dd, #5b3cc4);
        transform: translateY(-2px);
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
</head>
<body>

<div class="container">
    @yield('content')
</div>

<style>
    .container > * {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s forwards;
    }
    .container > *:nth-child(1) { animation-delay: 0.2s; }
    .container > *:nth-child(2) { animation-delay: 0.4s; }
    .container > *:nth-child(3) { animation-delay: 0.6s; }
    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- Bootstrap JS & Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
