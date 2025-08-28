<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Forbidden</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .background-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .floating-shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 70%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .error-container {
            text-align: center;
            color: white;
            z-index: 10;
            position: relative;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 60px 40px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 600px;
            width: 90%;
            animation: slideIn 1s ease-out;
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .error-code {
            font-size: 8rem;
            font-weight: 900;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #ff6b6b, #ffd93d, #6bcf7f, #4d9de0);
            background-size: 400% 400%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 3s ease infinite;
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
        }

        @keyframes gradientShift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        .lock-icon {
            font-size: 4rem;
            margin-bottom: 30px;
            animation: shake 2s ease-in-out infinite;
            display: inline-block;
        }

        @keyframes shake {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-5deg); }
            75% { transform: rotate(5deg); }
        }

        .error-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .error-message {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            box-shadow: 0 10px 25px rgba(255, 107, 107, 0.3);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #ee5a24, #ff6b6b);
            box-shadow: 0 15px 35px rgba(255, 107, 107, 0.4);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .glitch {
            position: relative;
            animation: glitchAnimation 3s infinite;
        }

        @keyframes glitchAnimation {
            0%, 90%, 100% {
                transform: translate(0);
            }
            10% {
                transform: translate(-2px, 1px);
            }
            20% {
                transform: translate(2px, -1px);
            }
            30% {
                transform: translate(-1px, 2px);
            }
            40% {
                transform: translate(1px, -2px);
            }
            50% {
                transform: translate(-2px, 1px);
            }
            60% {
                transform: translate(2px, -1px);
            }
            70% {
                transform: translate(-1px, 2px);
            }
            80% {
                transform: translate(1px, -1px);
            }
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 6rem;
            }
            .error-title {
                font-size: 2rem;
            }
            .error-container {
                padding: 40px 30px;
            }
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            .btn {
                width: 100%;
                max-width: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="background-animation">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </div>

    <div class="error-container">
        <div class="lock-icon">🔒</div>
        <div class="error-code glitch">403</div>
        <h1 class="error-title">Access Forbidden</h1>
        <p class="error-message">
            Sorry, you don't have permission to access this resource. 
            This could be due to insufficient privileges or restricted content.
        </p>
        
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="goBack()">
                ← Go Back
            </button>
            <button class="btn btn-secondary" onclick="goHome()">
                🏠 Home Page
            </button>
        </div>
    </div>

    <script>
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
        }

        function goHome() {
            window.location.href = '/';
        }

        // Add some interactive sparkle effects on mouse movement
        document.addEventListener('mousemove', function(e) {
            createSparkle(e.clientX, e.clientY);
        });

        function createSparkle(x, y) {
            const sparkle = document.createElement('div');
            sparkle.style.position = 'absolute';
            sparkle.style.left = x + 'px';
            sparkle.style.top = y + 'px';
            sparkle.style.width = '4px';
            sparkle.style.height = '4px';
            sparkle.style.background = 'rgba(255, 255, 255, 0.8)';
            sparkle.style.borderRadius = '50%';
            sparkle.style.pointerEvents = 'none';
            sparkle.style.zIndex = '5';
            sparkle.style.animation = 'sparkleAnimation 1s ease-out forwards';
            
            document.body.appendChild(sparkle);
            
            setTimeout(() => {
                if (sparkle.parentNode) {
                    sparkle.parentNode.removeChild(sparkle);
                }
            }, 1000);
        }

        // Add sparkle animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes sparkleAnimation {
                0% {
                    opacity: 1;
                    transform: scale(0) rotate(0deg);
                }
                50% {
                    opacity: 1;
                    transform: scale(1) rotate(180deg);
                }
                100% {
                    opacity: 0;
                    transform: scale(0) rotate(360deg);
                }
            }
        `;
        document.head.appendChild(style);

        // Add breathing effect to the lock icon
        const lockIcon = document.querySelector('.lock-icon');
        setInterval(() => {
            lockIcon.style.transform = 'scale(1.1)';
            setTimeout(() => {
                lockIcon.style.transform = 'scale(1)';
            }, 1000);
        }, 2000);
    </script>
</body>
</html>