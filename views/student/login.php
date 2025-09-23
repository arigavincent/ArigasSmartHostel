<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Student Login' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <i class="fas fa-user-graduate text-5xl text-indigo-600 mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Student Login</h1>
            <p class="text-gray-600">Access your hostel account</p>
        </div>

        <!-- Login Form -->
        <form action="index.php?url=student/authenticate" method="POST" class="space-y-6">
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline"><?= $_SESSION['login_error'] ?></span>
                </div>
                <?php unset($_SESSION['login_error']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['register_success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline"><?= $_SESSION['register_success'] ?></span>
                </div>
                <?php unset($_SESSION['register_success']); ?>
            <?php endif; ?>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-2"></i>Email Address
                </label>
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                       placeholder="Enter your email">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2"></i>Password
                </label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                       placeholder="Enter your password">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Remember me
                    </label>
                </div>
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">
                    Forgot password?
                </a>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>
        </form>

        <!-- Registration Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account? 
                <a href="index.php?url=student/register" class="text-indigo-600 hover:text-indigo-800 font-medium">
                    Register here
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div class="mt-4 text-center">
            <a href="../" class="text-sm text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left mr-1"></i>Back to Home
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <div id="message" class="fixed top-4 right-4 hidden">
        <!-- Messages will be shown here -->
    </div>
</body>
</html>