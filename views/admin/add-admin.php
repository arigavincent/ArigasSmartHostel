<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Add New Admin' ?></title>
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
                <a href="index.php?url=admin/manage-admins" class="hover:text-gray-300">
                    <i class="fas fa-arrow-left mr-1"></i>Back to Admins
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
        <div class="max-w-2xl mx-auto">
            <!-- Page Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-user-plus text-green-600 mr-2"></i>Add New Administrator
                </h2>
                <p class="text-gray-600">Create a new administrator account with appropriate permissions.</p>
            </div>

            <!-- Messages -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <span class="block sm:inline"><?= $_SESSION['error'] ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Security Notice -->
            <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-lg mb-6">
                <div class="flex items-start">
                    <i class="fas fa-shield-alt text-yellow-600 text-xl mt-1 mr-3"></i>
                    <div>
                        <h4 class="text-lg font-semibold text-yellow-800 mb-2">Security Protocol</h4>
                        <p class="text-sm text-yellow-700 mb-3">
                            As a security measure, this new admin account will be created immediately but requires 
                            verification before first login. The new admin will receive login credentials via email.
                        </p>
                        <div class="text-sm text-yellow-700">
                            <strong>Important:</strong> Only create accounts for trusted individuals who need administrative access.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Admin Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-user-cog text-gray-600 mr-2"></i>Administrator Details
                </h3>
                
                <form action="index.php?url=admin/store-admin" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2"></i>Username *
                            </label>
                            <input type="text" id="username" name="username" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Enter username">
                            <p class="text-xs text-gray-500 mt-1">Must be unique across all administrators</p>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2"></i>Email Address *
                            </label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Enter email address">
                            <p class="text-xs text-gray-500 mt-1">Login credentials will be sent to this email</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2"></i>Initial Password *
                            </label>
                            <input type="password" id="password" name="password" required minlength="8"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Create secure password">
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters (admin will be required to change on first login)</p>
                        </div>

                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-check-circle mr-2"></i>Confirm Password *
                            </label>
                            <input type="password" id="confirm_password" name="confirm_password" required minlength="8"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Confirm password">
                        </div>
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-shield-alt mr-2"></i>Administrator Role *
                        </label>
                        <select id="role" name="role" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Select role</option>
                            <option value="admin">Regular Admin</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                        <div class="mt-2 text-sm text-gray-600">
                            <div class="bg-gray-50 p-3 rounded">
                                <p class="font-medium mb-2">Role Permissions:</p>
                                <div class="space-y-1 text-xs">
                                    <p><strong>Regular Admin:</strong> Manage students, rooms, bookings, and reports</p>
                                    <p><strong>Super Admin:</strong> All regular permissions + manage other administrators</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Approval Section -->
                    <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                        <h4 class="font-semibold text-blue-800 mb-2">
                            <i class="fas fa-user-check text-blue-600 mr-2"></i>Administrative Approval
                        </h4>
                        <div class="text-sm text-blue-700 space-y-2">
                            <p><strong>Created by:</strong> <?= htmlspecialchars($admin['username']) ?> (<?= ucfirst(str_replace('_', ' ', $admin['role'])) ?>)</p>
                            <p><strong>Date:</strong> <?= date('F j, Y \a\t g:i A') ?></p>
                            <p><strong>Status:</strong> This account will be active immediately upon creation</p>
                        </div>
                    </div>

                    <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-red-600 mt-1 mr-2"></i>
                            <div class="text-sm text-red-800">
                                <strong>Security Checklist:</strong>
                                <ul class="mt-1 list-disc list-inside space-y-1">
                                    <li>Verify the identity of the person before creating their account</li>
                                    <li>Ensure they understand their role and responsibilities</li>
                                    <li>Confirm their email address is correct and accessible</li>
                                    <li>Use a strong initial password (they must change it on first login)</li>
                                    <li>Only assign Super Admin role to fully trusted individuals</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="security_confirmation" name="security_confirmation" required 
                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                        <label for="security_confirmation" class="ml-2 block text-sm text-gray-700">
                            I confirm that I have verified the identity and trustworthiness of this new administrator, 
                            and I take responsibility for creating this account.
                        </label>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                            <i class="fas fa-user-plus mr-2"></i>Create Administrator Account
                        </button>
                        <a href="index.php?url=admin/manage-admins"
                           class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 text-center">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        // Role selection explanation
        document.getElementById('role').addEventListener('change', function() {
            const roleInfo = document.querySelector('.role-info');
            if (this.value === 'super_admin') {
                if (!roleInfo) {
                    const info = document.createElement('div');
                    info.className = 'role-info mt-2 p-3 bg-purple-50 border border-purple-200 rounded text-sm text-purple-800';
                    info.innerHTML = '<strong>Warning:</strong> Super Admins have full system access including the ability to manage other administrators. Only assign this role to fully trusted individuals.';
                    this.parentNode.appendChild(info);
                }
            } else {
                if (roleInfo) {
                    roleInfo.remove();
                }
            }
        });
    </script>
</body>
</html>