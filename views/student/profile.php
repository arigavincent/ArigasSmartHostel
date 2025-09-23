<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'My Profile' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-indigo-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-building text-2xl mr-3"></i>
                <h1 class="text-xl font-bold">Ariga's Smart Hostel</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="index.php?url=student/dashboard" class="hover:text-indigo-200">
                    <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                </a>
                <span class="text-indigo-200">Welcome, <?= htmlspecialchars($student['name']) ?></span>
                <a href="index.php?url=student/logout" class="bg-indigo-700 hover:bg-indigo-800 px-4 py-2 rounded transition duration-300">
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
                    <i class="fas fa-user text-indigo-600 mr-2"></i>My Profile
                </h2>
                <p class="text-gray-600">Manage your personal information and account settings.</p>
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
                <!-- Profile Info -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-edit text-indigo-600 mr-2"></i>Personal Information
                        </h3>
                        
                        <form action="index.php?url=student/update-profile" method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-id-card mr-2"></i>Student ID
                                    </label>
                                    <input type="text" id="student_id" value="<?= htmlspecialchars($student['student_id']) ?>" 
                                           disabled class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-500">
                                    <p class="text-xs text-gray-500 mt-1">Student ID cannot be changed</p>
                                </div>

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user mr-2"></i>Full Name *
                                    </label>
                                    <input type="text" id="name" name="name" required
                                           value="<?= htmlspecialchars($student['name']) ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2"></i>Email Address *
                                </label>
                                <input type="email" id="email" name="email" required
                                       value="<?= htmlspecialchars($student['email']) ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-2"></i>Phone Number
                                </label>
                                <input type="tel" id="phone" name="phone"
                                       value="<?= htmlspecialchars($student['phone'] ?? '') ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                       placeholder="Enter your phone number">
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-home mr-2"></i>Address
                                </label>
                                <textarea id="address" name="address" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                          placeholder="Enter your address"><?= htmlspecialchars($student['address'] ?? '') ?></textarea>
                            </div>

                            <button type="submit"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300">
                                <i class="fas fa-save mr-2"></i>Update Profile
                            </button>
                        </form>
                    </div>

                    <!-- Change Password -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-lock text-red-600 mr-2"></i>Change Password
                        </h3>
                        
                        <form action="index.php?url=student/change-password" method="POST" class="space-y-6">
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

                            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-2"></i>
                                    <div class="text-sm text-yellow-800">
                                        <strong>Password Requirements:</strong>
                                        <ul class="mt-1 list-disc list-inside">
                                            <li>Minimum 6 characters long</li>
                                            <li>Make sure both passwords match</li>
                                            <li>You'll need to login again after changing password</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300">
                                <i class="fas fa-key mr-2"></i>Change Password
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Profile Summary -->
                <div>
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                            <i class="fas fa-info-circle text-indigo-600 mr-2"></i>Account Summary
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="text-center">
                                <div class="h-20 w-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-user text-indigo-600 text-2xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-800"><?= htmlspecialchars($student['name']) ?></h4>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($student['student_id']) ?></p>
                            </div>

                            <div class="border-t pt-4">
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Email:</span>
                                        <span class="text-gray-800"><?= htmlspecialchars($student['email']) ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Phone:</span>
                                        <span class="text-gray-800"><?= htmlspecialchars($student['phone'] ?? 'Not set') ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Member Since:</span>
                                        <span class="text-gray-800"><?= date('M Y', strtotime($student['created_at'])) ?></span>
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
                            <a href="index.php?url=student/bookings" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300 text-center block">
                                <i class="fas fa-calendar mr-2"></i>View My Bookings
                            </a>
                            <a href="index.php?url=student/payments" 
                               class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-300 text-center block">
                                <i class="fas fa-receipt mr-2"></i>My Payments
                            </a>
                            <a href="index.php?url=student/rooms" 
                               class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition duration-300 text-center block">
                                <i class="fas fa-bed mr-2"></i>Browse Rooms
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>