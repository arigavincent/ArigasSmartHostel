<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-user-shield text-2xl mr-3"></i>
                <h1 class="text-xl font-bold">Admin Dashboard</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="index.php?url=admin/profile" class="hover:text-gray-300">
                    <i class="fas fa-user-cog mr-1"></i>Profile
                </a>
                <span class="text-gray-300">Welcome, <?= htmlspecialchars($admin['username']) ?></span>
                <a href="index.php?url=admin/logout" class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded transition duration-300">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                <i class="fas fa-tachometer-alt text-gray-600 mr-2"></i>Admin Dashboard
            </h2>
            <p class="text-gray-600">Welcome to the hostel management system. Manage rooms, bookings, and students from here.</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-bed text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Total Rooms</h3>
                        <p class="text-2xl font-bold text-blue-600">8</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Active Bookings</h3>
                        <p class="text-2xl font-bold text-green-600">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-users text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Total Students</h3>
                        <p class="text-2xl font-bold text-yellow-600">1</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-full">
                        <span class="fas text-red-600 text-l ">Ksh</span>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Revenue</h3>
                        <p class="text-2xl font-bold text-red-600">Ksh.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Options -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <a href="index.php?url=admin/rooms" class="bg-blue-600 hover:bg-blue-700 text-white p-6 rounded-lg text-center transition duration-300 transform hover:scale-105">
                <i class="fas fa-bed text-3xl mb-3"></i>
                <h3 class="font-semibold text-lg">Manage Rooms</h3>
                <p class="text-sm mt-2">Add, edit, delete rooms</p>
            </a>

            <a href="index.php?url=admin/bookings" class="bg-green-600 hover:bg-green-700 text-white p-6 rounded-lg text-center transition duration-300 transform hover:scale-105">
                <i class="fas fa-calendar-alt text-3xl mb-3"></i>
                <h3 class="font-semibold text-lg">View Bookings</h3>
                <p class="text-sm mt-2">Manage all bookings</p>
            </a>

            <a href="index.php?url=admin/students" class="bg-yellow-600 hover:bg-yellow-700 text-white p-6 rounded-lg text-center transition duration-300 transform hover:scale-105">
                <i class="fas fa-users text-3xl mb-3"></i>
                <h3 class="font-semibold text-lg">Manage Students</h3>
                <p class="text-sm mt-2">View student details</p>
            </a>

            <a href="index.php?url=admin/reports" class="bg-purple-600 hover:bg-purple-700 text-white p-6 rounded-lg text-center transition duration-300 transform hover:scale-105">
                <i class="fas fa-chart-bar text-3xl mb-3"></i>
                <h3 class="font-semibold text-lg">Reports</h3>
                <p class="text-sm mt-2">Occupancy & financial reports</p>
            </a>
        </div>

        <!-- Admin Management Section (Only for Super Admins) -->
        <?php if ($admin['role'] === 'super_admin'): ?>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-users-cog text-purple-600 mr-2"></i>Administrator Management
                    <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full ml-2">Super Admin Only</span>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="index.php?url=admin/manage-admins" class="bg-purple-600 hover:bg-purple-700 text-white p-4 rounded-lg text-center transition duration-300">
                        <i class="fas fa-users-cog text-2xl mb-2"></i>
                        <p class="font-semibold">Manage Admins</p>
                        <p class="text-sm mt-1">View and manage administrators</p>
                    </a>
                    <a href="index.php?url=admin/add-admin" class="bg-green-600 hover:bg-green-700 text-white p-4 rounded-lg text-center transition duration-300">
                        <i class="fas fa-user-plus text-2xl mb-2"></i>
                        <p class="font-semibold">Add New Admin</p>
                        <p class="text-sm mt-1">Create new administrator account</p>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-clock text-gray-600 mr-2"></i>Recent Activity
            </h3>
            <div class="text-gray-600">
                <p class="mb-2">• System initialized</p>
                <p class="mb-2">• 8 rooms added to system</p>
                <p class="mb-2">• 1 test student registered</p>
                <p class="text-sm text-gray-500 mt-4">No recent bookings or activities</p>
            </div>
        </div>
    </div>
</body>
</html>