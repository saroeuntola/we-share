<?php
include('./admin/lib/auth.php');
$auth = new Auth();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);
    if ($auth->login($username, $password, $remember)) {
        $result = dbSelect('users', 'role_id', "username=" . $auth->db->quote($username));
        if ($result && count($result) > 0) {
            $user = $result[0];
            if ($user['role_id'] == 1) {
                header('Location: ./admin/index.php');
                exit();
            } elseif ($user['role_id'] == 2) {
                header('Location: ./index.php');
                exit();
            } elseif ($user['role_id'] == 3) {
                header('Location: ./admin/players_record');
                exit();
            }
        }
    } else {
        echo "<div class='error-message'><p>Invalid username or password!</p></div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Welcome Back</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #ffeaa7, #dda0dd);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            opacity: 0.1;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-field {
            width: 100%;
            padding: 1rem 1.25rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .input-field:focus {
            outline: none;
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
            background: rgba(255, 255, 255, 0.15);
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .input-label {
            position: absolute;
            top: -0.5rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.3);
        }

        .checkbox-custom {
            appearance: none;
            width: 1.5rem;
            height: 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.1);
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .checkbox-custom:checked {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
        }

        .checkbox-custom:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: -2s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 70%;
            right: 15%;
            animation-delay: -4s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 40%;
            right: 20%;
            animation-delay: -1s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .title-text {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .subtitle-text {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
        }

        .link-text {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            margin-top: 1rem;
        }

        .link-text:hover {
            color: #60a5fa;
            transform: translateY(-1px);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 1rem;
            border-radius: 12px;
            margin-top: 1rem;
            backdrop-filter: blur(10px);
        }

        .login-container {
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="gradient-bg">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="flex items-center justify-center min-h-screen relative z-10 px-4">
        <div class="w-full max-w-md login-container">
            <div class="glass-card p-8 rounded-2xl">
                <div class="text-center mb-8">
                    <h1 class="title-text">Welcome Back</h1>
                    <p class="subtitle-text">Sign in to your account</p>
                </div>

                <form action="login" method="POST">
                    <div class="input-group">

                        <input type="text" id="username" name="username" required
                            class="input-field" placeholder="Enter your username">
                    </div>

                    <div class="input-group">
                        <input type="password" id="password" name="password" required
                            class="input-field" placeholder="Enter your password">
                    </div>

                    <div class="flex items-center mb-6">
                        <input type="checkbox" id="remember" name="remember" class="checkbox-custom">
                        <label for="remember" class="ml-3 text-sm text-white opacity-90">Remember me</label>
                    </div>

                    <button type="submit" class="btn-primary w-full">
                        Sign In
                    </button>

                    <div class="text-center">
                        <a href="register.php" class="link-text">Don't have an account? Create one</a>
                    </div>

                    <?php if (isset($error_message)): ?>
                        <div class="error-message">
                            <p><?php echo $error_message; ?></p>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>