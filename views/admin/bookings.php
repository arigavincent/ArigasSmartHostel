<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'All Bookings' ?></title>
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
                <i class="fas fa-calendar-alt text-gray-600 mr-2"></i>All Bookings
            </h2>
            <p class="text-gray-600">Manage all student bookings and payment status.</p>
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

        <!-- Booking Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <?php
            $total_bookings = count($bookings);
            $active_bookings = count(array_filter($bookings, fn($b) => $b['booking_status'] === 'active'));
            $unpaid_bookings = count(array_filter($bookings, fn($b) => $b['payment_status'] === 'unpaid'));
            $total_revenue = array_sum(array_column(array_filter($bookings, fn($b) => $b['payment_status'] === 'paid'), 'total_amount'));
            ?>
            
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-calendar text-blue-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Total Bookings</p>
                        <p class="text-xl font-bold text-gray-800"><?= $total_bookings ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Active</p>
                        <p class="text-xl font-bold text-green-600"><?= $active_bookings ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="fas fa-exclamation text-red-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Unpaid</p>
                        <p class="text-xl font-bold text-red-600"><?= $unpaid_bookings ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-dollar-sign text-yellow-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Revenue</p>
                        <p class="text-xl font-bold text-yellow-600">₦<?= number_format($total_revenue) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Table -->
        <?php if (empty($bookings)): ?>
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Bookings Found</h3>
                <p class="text-gray-500">No students have made any bookings yet.</p>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($bookings as $booking): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($booking['booking_id']) ?></div>
                                        <div class="text-sm text-gray-500"><?= date('M j, Y', strtotime($booking['created_at'])) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($booking['student_name']) ?></div>
                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($booking['student_number']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($booking['room_number']) ?></div>
                                        <div class="text-sm text-gray-500 capitalize"><?= htmlspecialchars($booking['room_type']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div><?= date('M j', strtotime($booking['start_date'])) ?> - <?= date('M j, Y', strtotime($booking['end_date'])) ?></div>
                                        <?php
                                        $days = (strtotime($booking['end_date']) - strtotime($booking['start_date'])) / (60 * 60 * 24);
                                        ?>
                                        <div class="text-xs text-gray-500"><?= $days ?> days</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ₦<?= number_format($booking['total_amount']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="space-y-1">
                                            <?php
                                            $booking_status_classes = [
                                                'active' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                'completed' => 'bg-blue-100 text-blue-800'
                                            ];
                                            $booking_status_class = $booking_status_classes[$booking['booking_status']] ?? 'bg-gray-100 text-gray-800';
                                            
                                            $payment_status_classes = [
                                                'paid' => 'bg-green-100 text-green-800',
                                                'unpaid' => 'bg-red-100 text-red-800',
                                                'partial' => 'bg-yellow-100 text-yellow-800'
                                            ];
                                            $payment_status_class = $payment_status_classes[$booking['payment_status']] ?? 'bg-gray-100 text-gray-800';
                                            ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $booking_status_class ?>">
                                                <?= ucfirst($booking['booking_status']) ?>
                                            </span>
                                            <br>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $payment_status_class ?>">
                                                <?= ucfirst($booking['payment_status']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <?php if ($booking['booking_status'] === 'active'): ?>
                                            <form method="POST" action="index.php?url=admin/update-payment" class="inline">
                                                <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                                <select name="payment_status" onchange="this.form.submit()" 
                                                        class="text-xs border border-gray-300 rounded px-2 py-1">
                                                    <option value="unpaid" <?= $booking['payment_status'] === 'unpaid' ? 'selected' : '' ?>>Unpaid</option>
                                                    <option value="partial" <?= $booking['payment_status'] === 'partial' ? 'selected' : '' ?>>Partial</option>
                                                    <option value="paid" <?= $booking['payment_status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                                                </select>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-gray-400 text-xs">No actions</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>