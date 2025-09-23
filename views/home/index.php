<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Welcome' ?></title>
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
<body class="bg-gray-900 text-gray-200 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full futuristic-card p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <i class="fas fa-building text-5xl text-cyan-400 mb-4 animate-pulse-subtle"></i>
            <h1 class="text-3xl font-bold text-white mb-2">Ariga's Smart Hostel</h1>
            <p class="text-gray-400">Management System</p>
        </div>
        
        <div class="space-y-4">
            <a href="index.php?url=student/login" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center glow-button">
                <i class="fas fa-user-graduate mr-2"></i>
                Student Login
            </a>
            
            <a href="index.php?url=admin/login" class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center glow-button">
                <i class="fas fa-user-shield mr-2"></i>
                Admin Login
            </a>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">New student? 
                <a href="student/register" class="text-blue-400 hover:text-blue-300 font-medium">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>
