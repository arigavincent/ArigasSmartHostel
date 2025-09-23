<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Student Details' ?></title>
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
                <a href="index.php?url=admin/students" class="hover:text-gray-300">
                    <i class="fas fa-arrow-left mr-1"></i>Back to Students
                </a>
                <a href="index.php?url=admin/dashboard" class="hover:text-gray-300">
                    <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
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
        <div class="max-w-6xl mx-auto">
            <!-- Student Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-indigo-600 text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($student['name']) ?></h2>
                            <p class="text-gray-600">Student ID: <?= htmlspecialchars($student['student_id']) ?></p>
                            <p class="text-sm text-gray-500">Member since <?= date('F j, Y', strtotime($student['created_at'])) ?></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <?php
                        $total_bookings = count($bookings);
                        $active_bookings = count(array_filter($bookings, fn($b) => $b['booking_status'] === 'active'));
                        $unpaid_bookings = count(array_filter($bookings, fn($b) => $b['payment_status'] === 'unpaid'));
                        ?>
                        <?php if ($active_bookings > 0): ?>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                Currently Staying
                            </span>
                        <?php elseif ($unpaid_bookings > 0): ?>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                Has Unpaid Bills
                            </span>
                        <?php else: ?>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                No Active Bookings
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Student Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                            <i class="fas fa-info-circle text-indigo-600 mr-2"></i>Student Information
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Full Name</label>
                                <p class="text-gray-900 font-medium"><?= htmlspecialchars($student['name']) ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Student ID</label>
                                <p class="text-gray-900 font-mono"><?= htmlspecialchars($student['student_id']) ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Email Address</label>
                                <p class="text-gray-900"><?= htmlspecialchars($student['email']) ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Phone Number</label>
                                <p class="text-gray-900"><?= htmlspecialchars($student['phone'] ?? 'Not provided') ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Address</label>
                                <p class="text-gray-900"><?= htmlspecialchars($student['address'] ?? 'Not provided') ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Registration Date</label>
                                <p class="text-gray-900"><?= date('F j, Y g:i A', strtotime($student['created_at'])) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                            <i class="fas fa-tools text-gray-600 mr-2"></i>Quick Actions
                        </h3>
                        <div class="space-y-3">
                            <button onclick="openResetPasswordModal(<?= $student['id'] ?>, '<?= htmlspecialchars($student['name']) ?>')" 
                                    class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition duration-300 text-left">
                                <i class="fas fa-key mr-2"></i>Reset Password
                            </button>
                            <a href="mailto:<?= htmlspecialchars($student['email']) ?>" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300 text-left block">
                                <i class="fas fa-envelope mr-2"></i>Send Email
                            </a>
                            <?php if ($student['phone']): ?>
                                <a href="tel:<?= htmlspecialchars($student['phone']) ?>" 
                                   class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-300 text-left block">
                                    <i class="fas fa-phone mr-2"></i>Call Student
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Booking History -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">
                                <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>Booking History
                            </h3>
                            <span class="text-sm text-gray-500"><?= count($bookings) ?> total booking<?= count($bookings) !== 1 ? 's' : '' ?></span>
                        </div>

                        <?php if (empty($bookings)): ?>
                            <div class="text-center py-8">
                                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                                <h4 class="text-lg font-semibold text-gray-700 mb-2">No Bookings Found</h4>
                                <p class="text-gray-500">This student hasn't made any room bookings yet.</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach ($bookings as $booking): ?>
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-150">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <h4 class="font-semibold text-gray-800 mr-3">Room <?= htmlspecialchars($booking['room_number']) ?></h4>
                                                
                                                <!-- Status Badges -->
                                                <?php
                                                $status_classes = [
                                                    'active' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                    'completed' => 'bg-blue-100 text-blue-800'
                                                ];
                                                $status_class = $status_classes[$booking['booking_status']] ?? 'bg-gray-100 text-gray-800';
                                                ?>
                                                <span class="<?= $status_class ?> text-xs px-2 py-1 rounded-full font-medium mr-2">
                                                    <?= ucfirst($booking['booking_status']) ?>
                                                </span>

                                                <?php
                                                $payment_classes = [
                                                    'paid' => 'bg-green-100 text-green-800',
                                                    'unpaid' => 'bg-red-100 text-red-800',
                                                    'partial' => 'bg-yellow-100 text-yellow-800'
                                                ];
                                                $payment_class = $payment_classes[$booking['payment_status']] ?? 'bg-gray-100 text-gray-800';
                                                ?>
                                                <span class="<?= $payment_class ?> text-xs px-2 py-1 rounded-full font-medium">
                                                    <?= ucfirst($booking['payment_status']) ?>
                                                </span>
                                            </div>
                                            <span class="text-sm text-gray-500">
                                                <?= date('M j, Y', strtotime($booking['created_at'])) ?>
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                            <div>
                                                <span class="text-gray-600">Booking ID:</span>
                                                <span class="font-mono text-gray-800"><?= htmlspecialchars($booking['booking_id']) ?></span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">Duration:</span>
                                                <span class="text-gray-800">
                                                    <?= date('M j', strtotime($booking['start_date'])) ?> - <?= date('M j, Y', strtotime($booking['end_date'])) ?>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">Amount:</span>
                                                <span class="font-semibold text-gray-800">₦<?= number_format($booking['total_amount']) ?></span>
                                            </div>
                                        </div>

                                        <div class="mt-2 text-sm text-gray-600">
                                            <span class="capitalize"><?= $booking['room_type'] ?> room • ₦<?= number_format($booking['price']) ?>/month</span>
                                        </div>

                                        <!-- Quick Actions for Booking -->
                                        <?php if ($booking['booking_status'] === 'active'): ?>
                                            <div class="mt-3 flex space-x-2">
                                                <form method="POST" action="index.php?url=admin/update-payment" class="inline">
                                                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                                    <select name="payment_status" onchange="this.form.submit()" 
                                                            class="text-xs border border-gray-300 rounded px-2 py-1">
                                                        <option value="unpaid" <?= $booking['payment_status'] === 'unpaid' ? 'selected' : '' ?>>Unpaid</option>
                                                        <option value="partial" <?= $booking['payment_status'] === 'partial' ? 'selected' : '' ?>>Partial</option>
                                                        <option value="paid" <?= $booking['payment_status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                                                    </select>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
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