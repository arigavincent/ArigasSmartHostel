<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Welcome' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8">
        <div class="text-center mb-8">
            <i class="fas fa-building text-5xl text-indigo-600 mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Ariga's Smart Hostel</h1>
            <p class="text-gray-600">Management System</p>
        </div>
        
        <div class="space-y-4">
            <a href="index.php?url=student/login" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                <i class="fas fa-user-graduate mr-2"></i>
                Student Login
            </a>
            
            <a href="index.php?url=admin/login" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                <i class="fas fa-user-shield mr-2"></i>
                Admin Login
            </a>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">New student? 
                <a href="student/register" class="text-indigo-600 hover:text-indigo-800 font-medium">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>