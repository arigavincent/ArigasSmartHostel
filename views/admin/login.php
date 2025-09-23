<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Login' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-900 to-gray-700 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <i class="fas fa-user-shield text-5xl text-gray-700 mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Admin Login</h1>
            <p class="text-gray-600">Access the management system</p>
        </div>

        <!-- Login Form -->
        <form action="index.php?url=admin/authenticate" method="POST" class="space-y-6">
            <?php if (isset($_SESSION['admin_login_error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline"><?= $_SESSION['admin_login_error'] ?></span>
                </div>
                <?php unset($_SESSION['admin_login_error']); ?>
            <?php endif; ?>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-2"></i>Email Address
                </label>
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent transition duration-200"
                       placeholder="Enter admin email">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2"></i>Password
                </label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent transition duration-200"
                       placeholder="Enter admin password">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-gray-600 focus:ring-gray-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Remember me
                    </label>
                </div>
                <a href="#" class="text-sm text-gray-600 hover:text-gray-800">
                    Forgot password?
                </a>
            </div>

            <button type="submit"
                    class="w-full bg-gray-700 hover:bg-gray-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                <i class="fas fa-sign-in-alt mr-2"></i>Login as Admin
            </button>
        </form>

        <!-- Back to Home -->
        <div class="mt-6 text-center">
            <a href="index.php" class="text-sm text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left mr-1"></i>Back to Home
            </a>
        </div>

        <!-- Test Credentials Info -->
        <div class="mt-4 p-3 bg-gray-100 rounded text-sm text-gray-600">
            <strong>Test Admin:</strong><br>
            Email: admin@hostel.com<br>
            Password: password
        </div>
    </div>
</body>
</html>