<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOVEON</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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
            font-size: 60px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1e293b;
            line-height: 1.2;
        }

        p {
            color: #475569;
            margin-bottom: 30px;
            font-size: 22px;
        }

        .btn-start {
            background-color: #1e3a8a;
            color: white;
            padding: 14px 36px;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
            transition: transform 0.2s ease, background-color 0.3s ease;
        }

        .btn-start:hover {
            background-color: #1d4ed8;
            transform: translateY(-3px);
        }

        .illustration img {
            width: 500px;
            max-width: 90%;
            height: auto;
            filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.1));
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
                margin-top: 50px;
            }
        }

        /* Modal overlay */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            transition: opacity 0.3s ease;
        }

        /* Modal content */
        .modal-content {
            background-color: #fff;
            margin: 12% auto;
            padding: 30px;
            border-radius: 15px;
            max-width: 500px;
            text-align: center;
            position: relative;
            animation: fadeInUp 0.5s ease;
        }

        /* Close button */
        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
        }

        /* Form options */
        .form-options {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            gap: 20px;
        }

        .form-card {
            flex: 1;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #ddd;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .form-card img {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }

        .form-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
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
            <h1>MOVEON</h1>
            <p>Mobility Operation & Voyage Engagement Network</p>
            <button class="btn-start" id="btnStart">Start</button>
        </div>
        <div class="illustration">
            <img src="{{ asset('images/logo moveon.png') }}" alt="Logo" style="width: 500px; height: auto;">
        </div>
    </main>

    <!-- Modal pilih form -->
    <div id="formModal" class="modal">
        <div class="modal-content">
            <h2>Pilih Formulir</h2>
            <div class="form-options">
                <div class="form-card" onclick="redirectTo('{{ route('formulir.index') }}')">
                    <span class="material-icons" style="font-size:64px; color:#1e3a8a;">directions_car</span>
                    <p>Form CRM/DTD</p>
                </div>
                <div class="form-card" onclick="redirectTo('{{ route('manifest.index') }}')">
                    <span class="material-icons" style="font-size:64px; color:#1e3a8a;">directions_boat</span>
                    <p>Data Manifest Real Time</p>
                </div>
            </div>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
    </div>

    <script>
        const btnStart = document.getElementById('btnStart');
        const modal = document.getElementById('formModal');

        btnStart.addEventListener('click', function(e) {
            e.preventDefault(); // cegah default behavior
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // disable scroll
        });

        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function redirectTo(url) {
            window.location.href = url;
        }

        // Tutup modal jika klik di luar content
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>
