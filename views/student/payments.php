<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'My Payments' ?></title>
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
                <a href="index.php?url=student/bookings" class="hover:text-indigo-200">
                    <i class="fas fa-calendar mr-1"></i>My Bookings
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
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-credit-card text-indigo-600 mr-2"></i>My Payments
            </h2>
            <p class="text-gray-600">Manage your booking payments and view payment history.</p>
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

        <?php if (isset($_SESSION['email_sent'])): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
                <span class="block sm:inline"><?= $_SESSION['email_sent'] ?></span>
            </div>
            <?php unset($_SESSION['email_sent']); ?>
        <?php endif; ?>

        <!-- Payment Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-receipt text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Total Amount</h3>
                        <p class="text-2xl font-bold text-blue-600">Ksh.<?= number_format($payment_summary['total']) ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Paid Amount</h3>
                        <p class="text-2xl font-bold text-green-600">Ksh.<?= number_format($payment_summary['paid']) ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Pending Amount</h3>
                        <p class="text-2xl font-bold text-red-600">Ksh.<?= number_format($payment_summary['pending']) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Outstanding Payments -->
        <?php 
        $unpaid_bookings = array_filter($bookings, fn($b) => in_array($b['payment_status'], ['unpaid', 'partial']));
        ?>
        <?php if (!empty($unpaid_bookings)): ?>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>Outstanding Payments
                </h3>
                <div class="space-y-4">
                    <?php foreach ($unpaid_bookings as $booking): ?>
                        <div class="border border-red-200 bg-red-50 rounded-lg p-4">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h4 class="font-semibold text-gray-800 mr-3">Room <?= htmlspecialchars($booking['room_number']) ?></h4>
                                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-medium">
                                            <?= ucfirst($booking['payment_status']) ?>
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                        <div>
                                            <span class="font-medium">Booking ID:</span>
                                            <span class="font-mono"><?= htmlspecialchars($booking['booking_id']) ?></span>
                                        </div>
                                        <div>
                                            <span class="font-medium">Duration:</span>
                                            <span><?= date('M j', strtotime($booking['start_date'])) ?> - <?= date('M j, Y', strtotime($booking['end_date'])) ?></span>
                                        </div>
                                        <div>
                                            <span class="font-medium">Amount Due:</span>
                                            <span class="font-bold text-red-600">Ksh.<?= number_format($booking['remaining_balance'] ?? ($booking['total_amount'] - ($booking['paid_amount'] ?? 0))) ?></span>
                                        </div>
                                    </div>
                                    
                                    <!-- Payment Progress Bar -->
                                    <div class="mt-3">
                                        <?php 
                                            $paid = $booking['paid_amount'] ?? 0;
                                            $total = $booking['total_amount'];
                                            $percentage = $total > 0 ? ($paid / $total) * 100 : 0;
                                            $barColor = ($percentage >= 100) ? 'bg-green-600' : 'bg-red-600';
                                        ?>
                                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                                            <span>Paid: Ksh.<?= number_format($paid) ?></span>
                                            <span>Total: Ksh.<?= number_format($total) ?></span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="<?= $barColor ?> h-2 rounded-full" style="width: <?= min($percentage, 100) ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 lg:mt-0 lg:ml-6">
                                    <a href="index.php?url=student/make-payment&booking_id=<?= $booking['id'] ?>" 
                                       class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition duration-300 inline-block">
                                        <i class="fas fa-credit-card mr-2"></i>Pay Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- All Bookings Payment Status -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-list text-indigo-600 mr-2"></i>All Bookings & Payment Status
            </h3>

            <?php if (empty($bookings)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-receipt text-6xl text-gray-300 mb-4"></i>
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">No Bookings Found</h4>
                    <p class="text-gray-500 mb-4">You haven't made any bookings yet.</p>
                    <a href="index.php?url=student/rooms" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition duration-300">
                        Browse Rooms
                    </a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
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
                                        <div class="text-sm font-medium text-gray-900">Room <?= htmlspecialchars($booking['room_number']) ?></div>
                                        <div class="text-sm text-gray-500 capitalize"><?= htmlspecialchars($booking['room_type']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= date('M j', strtotime($booking['start_date'])) ?> - <?= date('M j, Y', strtotime($booking['end_date'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="space-y-1">
                                            <div>Total: Ksh.<?= number_format($booking['total_amount']) ?></div>
                                            <div class="text-green-600">Paid: Ksh.<?= number_format($booking['paid_amount'] ?? 0) ?></div>
                                            <div class="text-red-600 font-bold">Due: Ksh.<?= number_format($booking['remaining_balance'] ?? ($booking['total_amount'] - ($booking['paid_amount'] ?? 0))) ?></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                        $payment_classes = [
                                            'paid' => 'bg-green-100 text-green-800',
                                            'unpaid' => 'bg-red-100 text-red-800',
                                            'partial' => 'bg-yellow-100 text-yellow-800'
                                        ];
                                        $payment_class = $payment_classes[$booking['payment_status']] ?? 'bg-gray-100 text-gray-800';
                                        ?>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $payment_class ?>">
                                            <?= ucfirst($booking['payment_status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <?php $remaining = $booking['remaining_balance'] ?? ($booking['total_amount'] - ($booking['paid_amount'] ?? 0)); ?>
                                        <?php if ($remaining > 0 && $booking['booking_status'] === 'active'): ?>
                                            <a href="index.php?url=student/make-payment&booking_id=<?= $booking['id'] ?>" 
                                               class="text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-credit-card mr-1"></i>Pay Ksh.<?= number_format($remaining) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-gray-400">
                                                <?= $booking['payment_status'] === 'paid' ? 'Fully Paid' : 'N/A' ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>