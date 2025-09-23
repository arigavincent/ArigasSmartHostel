<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Student Login' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0d111d;
            background-image: radial-gradient(at 30% 60%, hsla(240, 100%, 70%, 0.1), transparent), 
                              radial-gradient(at 70% 30%, hsla(180, 100%, 50%, 0.1), transparent);
            animation: pan-background 30s infinite alternate ease-in-out;
        }

        .futuristic-card {
            position: relative;
            background-color: rgba(31, 41, 55, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(75, 85, 99, 0.4);
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            animation: card-glow 5s infinite ease-in-out alternate;
        }

        .glow-button {
            transition: all 0.4s ease;
        }
        .glow-button:hover {
            transform: scale(1.03);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.7), 0 0 10px rgba(59, 130, 246, 0.6);
        }

        /* Keyframe Animations */
        @keyframes pan-background {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }

        @keyframes card-glow {
            0%, 100% { box-shadow: 0 0 15px rgba(59, 130, 246, 0.2), 0 0 5px rgba(59, 130, 246, 0.2); }
            50% { box-shadow: 0 0 25px rgba(59, 130, 246, 0.4), 0 0 10px rgba(59, 130, 246, 0.4); }
        }
        
        .animate-pulse-subtle {
            animation: subtle-pulse 2.5s infinite ease-in-out;
        }
        
        @keyframes subtle-pulse {
            0%, 100% { transform: scale(1); opacity: 0.95; }
            50% { transform: scale(1.03); opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen flex items-center justify-center p-8">
    <div class="max-w-md w-full futuristic-card p-6">
        <!-- Header -->
        <div class="text-center mb-6">
            <i class="fas fa-user-graduate text-5xl text-indigo-400 mb-4 animate-pulse-subtle"></i>
            <h1 class="text-3xl font-bold text-white mb-2">Student Login</h1>
            <p class="text-gray-400">Access your hostel account</p>
        </div>

        <!-- Login Form -->
        <form action="index.php?url=student/authenticate" method="POST" class="space-y-4">
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg relative">
                    <span class="block sm:inline"><?= $_SESSION['login_error'] ?></span>
                </div>
                <?php unset($_SESSION['login_error']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['register_success'])): ?>
                <div class="bg-green-900 border border-green-700 text-green-300 px-4 py-3 rounded-lg relative">
                    <span class="block sm:inline"><?= $_SESSION['register_success'] ?></span>
                </div>
                <?php unset($_SESSION['register_success']); ?>
            <?php endif; ?>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-400 mb-2">
                    <i class="fas fa-envelope mr-2"></i>Email Address
                </label>
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white glow-input focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                       placeholder="Enter your email">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-400 mb-2">
                    <i class="fas fa-lock mr-2"></i>Password
                </label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white glow-input focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                       placeholder="Enter your password">
            </div>

            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-indigo-500 focus:ring-indigo-400 border-gray-600 rounded-sm bg-gray-700">
                    <label for="remember" class="ml-2 block text-gray-400">
                        Remember me
                    </label>
                </div>
                <a href="#" class="text-indigo-400 hover:text-indigo-300 transition-colors">
                    Forgot password?
                </a>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 glow-button">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>
        </form>

        <!-- Registration Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                Don't have an account? 
                <a href="index.php?url=student/register" class="text-indigo-400 hover:text-indigo-300 font-medium">
                    Register here
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div class="mt-4 text-center">
            <a href="index.php" class="text-sm text-gray-500 hover:text-gray-400">
                <i class="fas fa-arrow-left mr-1"></i>Back to Home
            </a>
        </div>
    </div>
</body>
</html>
