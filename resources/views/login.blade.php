<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jasa Raharja</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom right, #eff6ff, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
            position: relative;
        }

        .card {
            background: white;
            padding: 40px 50px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            animation: fadeInUp 1s ease, floatCard 3s ease-in-out infinite;
        }

        h2 {
            text-align: center;
            color: #1e3a8a;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 6px;
            color: #475569;
        }

        .input-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: border 0.3s ease;
        }

        .input-group input:focus {
            border: 1px solid #1e3a8a;
        }

        .btn {
            background-color: #1e3a8a;
            color: white;
            padding: 14px;
            width: 100%;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #1d4ed8;
            transform: translateY(-3px);
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .footer a {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: 600;
        }

        /* Floating Back Button */
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #1e3a8a;
            color: white;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, background-color 0.3s ease;
        }

        .back-btn:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        /* Animations */
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

        @keyframes floatCard {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>

<body>
    <a href="{{ url('/') }}">
        <button class="back-btn">←</button>
    </a>

    <div class="card">
        <h2>Login</h2>
        <form method="POST" action="{{ route('login.custom') }}">
            @csrf
            <div class="input-group">
                <label>Name</label>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <button class="btn" type="submit">Login</button>
        </form>
        <div class="footer">
            Don’t have an account? <a href="/register">Register</a>
        </div>
    </div>
</body>

</html>
