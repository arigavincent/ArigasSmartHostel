<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Manage Admins' ?></title>
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
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-users-cog text-purple-600 mr-2"></i>Manage Admins
                    </h2>
                    <p class="text-gray-600">Manage administrator accounts and pending requests.</p>
                </div>
                <a href="index.php?url=admin/add-admin" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition duration-300">
                    <i class="fas fa-user-plus mr-2"></i>Add New Admin
                </a>
            </div>
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

        <!-- Admin Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <?php
            $total_admins = count($admins);
            $super_admins = count(array_filter($admins, fn($a) => $a['role'] === 'super_admin'));
            $regular_admins = count(array_filter($admins, fn($a) => $a['role'] === 'admin'));
            ?>
            
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Total Admins</p>
                        <p class="text-xl font-bold text-gray-800"><?= $total_admins ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-crown text-purple-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Super Admins</p>
                        <p class="text-xl font-bold text-purple-600"><?= $super_admins ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-user-tie text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Regular Admins</p>
                        <p class="text-xl font-bold text-green-600"><?= $regular_admins ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Admins Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-shield-alt text-green-600 mr-2"></i>Active Administrators
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($admins as $admin_user): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full <?= $admin_user['role'] === 'super_admin' ? 'bg-purple-100' : 'bg-blue-100' ?> flex items-center justify-center">
                                                <i class="fas <?= $admin_user['role'] === 'super_admin' ? 'fa-crown text-purple-600' : 'fa-user-shield text-blue-600' ?>"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($admin_user['username']) ?></div>
                                            <?php if ($admin_user['id'] == $_SESSION['admin_id']): ?>
                                                <div class="text-sm text-green-600 font-medium">(You)</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= htmlspecialchars($admin_user['email']) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($admin_user['role'] === 'super_admin'): ?>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            <i class="fas fa-crown mr-1"></i>Super Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <i class="fas fa-user-shield mr-1"></i>Admin
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= date('M j, Y', strtotime($admin_user['created_at'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <?php if ($admin_user['id'] != $_SESSION['admin_id']): ?>
                                        <button onclick="confirmDelete(<?= $admin_user['id'] ?>, '<?= htmlspecialchars($admin_user['username']) ?>')" 
                                                class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm">Current User</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="bg-blue-50 border border-blue-200 p-6 rounded-lg">
            <div class="flex items-start">
                <i class="fas fa-shield-alt text-blue-600 text-xl mt-1 mr-3"></i>
                <div>
                    <h4 class="text-lg font-semibold text-blue-800 mb-2">Security Guidelines</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• New admin requests require approval from existing super admins</li>
                        <li>• Only super admins can manage other administrator accounts</li>
                        <li>• Admin accounts should use strong, unique passwords</li>
                        <li>• Regular admins can manage students, rooms, and bookings</li>
                        <li>• Super admins have full system access including admin management</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex items-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl mr-3"></i>
                <h3 class="text-lg font-bold text-gray-900">Confirm Admin Deletion</h3>
            </div>
            <p class="text-gray-600 mb-6">
                Are you sure you want to delete admin <span id="deleteAdminName" class="font-semibold"></span>? 
                This action cannot be undone and will immediately revoke all admin privileges.
            </p>
            <div class="flex space-x-3">
                <a id="confirmDeleteBtn" href="#" 
                   class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-center transition duration-300">
                    Delete Admin
                </a>
                <button onclick="closeDeleteModal()" 
                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(adminId, adminName) {
            document.getElementById('deleteAdminName').textContent = adminName;
            document.getElementById('confirmDeleteBtn').href = 'index.php?url=admin/delete-admin&id=' + adminId;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }
    </script>
</body>
</html>