<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'My Bookings' ?></title>
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
                <a href="index.php?url=student/rooms" class="hover:text-indigo-200">
                    <i class="fas fa-bed mr-1"></i>Browse Rooms
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
                <i class="fas fa-calendar-check text-indigo-600 mr-2"></i>My Bookings
            </h2>
            <p class="text-gray-600">View and manage all your room bookings.</p>
        </div>

        <!-- Messages -->
        <?php if (isset($_SESSION['booking_success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <span class="block sm:inline"><?= $_SESSION['booking_success'] ?></span>
            </div>
            <?php unset($_SESSION['booking_success']); ?>
        <?php endif; ?>

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

        <!-- Quick Actions -->
        <div class="mb-6">
            <a href="index.php?url=student/rooms" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition duration-300 inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>Book New Room
            </a>
        </div>

        <!-- Bookings List -->
        <?php if (empty($bookings)): ?>
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Bookings Found</h3>
                <p class="text-gray-500 mb-4">You haven't made any room bookings yet.</p>
                <a href="index.php?url=student/rooms" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition duration-300">
                    Browse Available Rooms
                </a>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($bookings as $booking): ?>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <!-- Booking Info -->
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <h3 class="text-xl font-bold text-gray-800 mr-3">
                                        Room <?= htmlspecialchars($booking['room_number']) ?>
                                    </h3>
                                    
                                    <!-- Status Badge -->
                                    <?php
                                    $status_classes = [
                                        'active' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'completed' => 'bg-blue-100 text-blue-800'
                                    ];
                                    $status_class = $status_classes[$booking['booking_status']] ?? 'bg-gray-100 text-gray-800';
                                    ?>
                                    <span class="<?= $status_class ?> text-xs px-2 py-1 rounded-full font-medium">
                                        <?= ucfirst($booking['booking_status']) ?>
                                    </span>

                                    <!-- Payment Status Badge -->
                                    <?php
                                    $payment_classes = [
                                        'paid' => 'bg-green-100 text-green-800',
                                        'unpaid' => 'bg-red-100 text-red-800',
                                        'partial' => 'bg-yellow-100 text-yellow-800'
                                    ];
                                    $payment_class = $payment_classes[$booking['payment_status']] ?? 'bg-gray-100 text-gray-800';
                                    ?>
                                    <span class="<?= $payment_class ?> text-xs px-2 py-1 rounded-full font-medium ml-2">
                                        Payment: <?= ucfirst($booking['payment_status']) ?>
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                    <div>
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-id-card w-4 mr-2"></i>
                                            <span class="font-medium">Booking ID:</span>
                                        </div>
                                        <span class="text-gray-800 font-mono"><?= htmlspecialchars($booking['booking_id']) ?></span>
                                    </div>

                                    <div>
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-calendar w-4 mr-2"></i>
                                            <span class="font-medium">Duration:</span>
                                        </div>
                                        <span class="text-gray-800">
                                            <?= date('M j, Y', strtotime($booking['start_date'])) ?> - 
                                            <?= date('M j, Y', strtotime($booking['end_date'])) ?>
                                        </span>
                                    </div>

                                    <div>
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-money-bill-wave w-4 mr-2 text-green-600 inline-block"></i>
                                            <span class="font-medium">Total Amount:</span>
                                        </div>
                                        <span class="text-gray-800 font-bold">Ksh.<?= number_format($booking['total_amount']) ?></span>
                                    </div>
                                </div>

                                <div class="mt-3 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <i class="fas fa-bed w-4 mr-2"></i>
                                        <span><?= ucfirst($booking['room_type']) ?> room • Ksh.<?= number_format($booking['price']) ?>/month</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="mt-4 lg:mt-0 lg:ml-6 flex space-x-2">
                                <?php if ($booking['booking_status'] === 'active'): ?>
                                    <a href="index.php?url=student/room-details&id=<?= $booking['room_id'] ?>" 
                                       class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-4 py-2 rounded text-sm transition duration-300">
                                        <i class="fas fa-eye mr-1"></i>View Room
                                    </a>
                                    
                                    <?php if (strtotime($booking['start_date']) > strtotime('+2 days')): ?>
                                        <a href="index.php?url=student/cancel-booking&id=<?= $booking['id'] ?>" 
                                           class="bg-red-100 hover:bg-red-200 text-red-800 px-4 py-2 rounded text-sm transition duration-300"
                                           onclick="return confirm('Are you sure you want to cancel this booking?')">
                                            <i class="fas fa-times mr-1"></i>Cancel
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="index.php?url=student/room-details&id=<?= $booking['room_id'] ?>" 
                                       class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded text-sm transition duration-300">
                                        <i class="fas fa-eye mr-1"></i>View Room
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>