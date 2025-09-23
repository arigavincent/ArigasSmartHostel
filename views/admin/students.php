<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Manage Students' ?></title>
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
                <a href="index.php?url=admin/rooms" class="hover:text-gray-300">
                    <i class="fas fa-bed mr-1"></i>Rooms
                </a>
                <a href="index.php?url=admin/bookings" class="hover:text-gray-300">
                    <i class="fas fa-calendar mr-1"></i>Bookings
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
            <h2 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-users text-gray-600 mr-2"></i>Manage Students
            </h2>
            <p class="text-gray-600">View and manage all registered students.</p>
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

        <!-- Student Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <?php
            $total_students = count($students);
            $students_with_bookings = count(array_filter($students, fn($s) => $s['total_bookings'] > 0));
            $students_with_active_bookings = count(array_filter($students, fn($s) => $s['active_bookings'] > 0));
            $students_with_unpaid = count(array_filter($students, fn($s) => $s['unpaid_bookings'] > 0));
            ?>
            
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Total Students</p>
                        <p class="text-xl font-bold text-gray-800"><?= $total_students ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-calendar text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">With Bookings</p>
                        <p class="text-xl font-bold text-green-600"><?= $students_with_bookings ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-bed text-yellow-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Currently Staying</p>
                        <p class="text-xl font-bold text-yellow-600"><?= $students_with_active_bookings ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="fas fa-exclamation text-red-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Unpaid Bills</p>
                        <p class="text-xl font-bold text-red-600"><?= $students_with_unpaid ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <?php if (empty($students)): ?>
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-user-times text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Students Found</h3>
                <p class="text-gray-500">No students have registered yet.</p>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bookings</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($students as $student): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-indigo-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($student['name']) ?></div>
                                                <div class="text-sm text-gray-500"><?= htmlspecialchars($student['student_id']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= htmlspecialchars($student['email']) ?></div>
                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($student['phone'] ?? 'No phone') ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex space-x-1">
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                                <?= $student['total_bookings'] ?> total
                                            </span>
                                            <?php if ($student['active_bookings'] > 0): ?>
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                                                    <?= $student['active_bookings'] ?> active
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($student['unpaid_bookings'] > 0): ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Unpaid Bills
                                            </span>
                                        <?php elseif ($student['active_bookings'] > 0): ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                No Bookings
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('M j, Y', strtotime($student['created_at'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="index.php?url=admin/student-details&id=<?= $student['id'] ?>" 
                                           class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                        <button onclick="openResetPasswordModal(<?= $student['id'] ?>, '<?= htmlspecialchars($student['name']) ?>')" 
                                                class="text-yellow-600 hover:text-yellow-900">
                                            <i class="fas fa-key mr-1"></i>Reset Password
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Reset Password Modal -->
    <div id="resetPasswordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Reset Student Password</h3>
            <form action="index.php?url=admin/reset-password" method="POST">
                <input type="hidden" name="student_id" id="modalStudentId">
                <p class="text-gray-600 mb-4">Reset password for: <span id="modalStudentName" class="font-medium"></span></p>
                
                <div class="mb-4">
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input type="text" name="new_password" id="new_password" value="student123"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg">
                        Reset Password
                    </button>
                    <button type="button" onclick="closeResetPasswordModal()" 
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openResetPasswordModal(studentId, studentName) {
            document.getElementById('modalStudentId').value = studentId;
            document.getElementById('modalStudentName').textContent = studentName;
            document.getElementById('resetPasswordModal').classList.remove('hidden');
            document.getElementById('resetPasswordModal').classList.add('flex');
        }

        function closeResetPasswordModal() {
            document.getElementById('resetPasswordModal').classList.add('hidden');
            document.getElementById('resetPasswordModal').classList.remove('flex');
        }
    </script>
</body>
</html>