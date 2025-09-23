<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Profile' ?></title>
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
                <a href="index.php?url=admin/dashboard" class="hover:text-gray-300">
                    <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                </a>
                <?php if ($admin['role'] === 'super_admin'): ?>
                    <a href="index.php?url=admin/manage-admins" class="hover:text-gray-300">
                        <i class="fas fa-users-cog mr-1"></i>Admins
                    </a>
                <?php endif; ?>
                <span class="text-gray-300">Welcome, <?= htmlspecialchars($admin['username']) ?></span>
                <a href="index.php?url=admin/logout" class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded transition duration-300">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-user-cog text-gray-600 mr-2"></i>Admin Profile
                </h2>
                <p class="text-gray-600">Manage your admin account settings and information.</p>
            </div>

            <!-- Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <span class="block sm:inline"><?= $_SESSION['success'] ?></span>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <span class="block sm:inline"><?= $_SESSION['error'] ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-edit text-gray-600 mr-2"></i>Profile Information
                        </h3>
                        
                        <form action="index.php?url=admin/update-profile" method="POST" class="space-y-6">
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2"></i>Username *
                                </label>
                                <input type="text" id="username" name="username" required
                                       value="<?= htmlspecialchars($admin['username']) ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2"></i>Email Address *
                                </label>
                                <input type="email" id="email" name="email" required
                                       value="<?= htmlspecialchars($admin['email']) ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-shield-alt mr-2"></i>Role
                                </label>
                                <input type="text" value="<?= ucfirst(str_replace('_', ' ', $admin['role'])) ?>" disabled
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-500">
                                <p class="text-xs text-gray-500 mt-1">Role cannot be changed</p>
                            </div>

                            <button type="submit"
                                    class="w-full bg-gray-700 hover:bg-gray-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-300">
                                <i class="fas fa-save mr-2"></i>Update Profile
                            </button>
                        </form>
                    </div>

                    <!-- Change Password -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-lock text-red-600 mr-2"></i>Change Password
                        </h3>
                        
                        <form action="index.php?url=admin/change-password" method="POST" class="space-y-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-unlock mr-2"></i>Current Password *
                                </label>
                                <input type="password" id="current_password" name="current_password" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                       placeholder="Enter current password">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-key mr-2"></i>New Password *
                                    </label>
                                    <input type="password" id="new_password" name="new_password" required minlength="6"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                           placeholder="Enter new password">
                                </div>

                                <div>
                                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-check-circle mr-2"></i>Confirm Password *
                                    </label>
                                    <input type="password" id="confirm_password" name="confirm_password" required minlength="6"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                           placeholder="Confirm new password">
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300">
                                <i class="fas fa-key mr-2"></i>Change Password
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Admin Summary -->
                <div>
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                            <i class="fas fa-info-circle text-gray-600 mr-2"></i>Account Summary
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="text-center">
                                <div class="h-20 w-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-user-shield text-gray-600 text-2xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-800"><?= htmlspecialchars($admin['username']) ?></h4>
                                <p class="text-sm text-gray-500"><?= ucfirst(str_replace('_', ' ', $admin['role'])) ?></p>
                            </div>

                            <div class="border-t pt-4">
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Email:</span>
                                        <span class="text-gray-800"><?= htmlspecialchars($admin['email']) ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Role:</span>
                                        <span class="text-gray-800"><?= ucfirst(str_replace('_', ' ', $admin['role'])) ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Member Since:</span>
                                        <span class="text-gray-800"><?= date('M Y', strtotime($admin['created_at'])) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                            <i class="fas fa-bolt text-yellow-600 mr-2"></i>Quick Actions
                        </h3>
                        
                        <div class="space-y-3">
                            <a href="index.php?url=admin/dashboard" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300 text-center block">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                            <?php if ($admin['role'] === 'super_admin'): ?>
                                <a href="index.php?url=admin/manage-admins" 
                                   class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition duration-300 text-center block">
                                    <i class="fas fa-users-cog mr-2"></i>Manage Admins
                                </a>
                                <a href="index.php?url=admin/add-admin" 
                                   class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-300 text-center block">
                                    <i class="fas fa-user-plus mr-2"></i>Add New Admin
                                </a>
                            <?php endif; ?>
                            <a href="index.php?url=admin/reports" 
                               class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-300 text-center block">
                                <i class="fas fa-chart-bar mr-2"></i>View Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>