<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Student Dashboard' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            background-image: radial-gradient(at 20% 80%, #dbeafe, transparent), 
                              radial-gradient(at 80% 20%, #bfdbfe, transparent);
            animation: pan-background 30s infinite alternate ease-in-out;
        }

        .glass-card {
            background-color: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .glow-icon {
            text-shadow: 0 0 5px rgba(59, 130, 246, 0.8);
            transition: text-shadow 0.3s ease;
        }
        .glow-icon:hover {
            text-shadow: 0 0 15px rgba(59, 130, 246, 1);
        }

        /* Keyframe Animations */
        @keyframes pan-background {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }

        .animate-pulse-subtle {
            animation: subtle-pulse 2.5s infinite ease-in-out;
        }
        
        @keyframes subtle-pulse {
            0%, 100% { transform: scale(1); opacity: 0.95; }
            50% { transform: scale(1.03); opacity: 1; }
        }

        /* Fade-in and slide-up animation */
        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        
        .fade-in-up.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="p-8 text-gray-800 min-h-screen">
    <!-- Navigation -->
    <nav class="glass-card p-4 mb-8">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-building text-2xl mr-3 text-blue-600"></i>
                <h1 class="text-xl font-bold">Ariga's Smart Hostel</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Welcome, <?= htmlspecialchars($student['name']) ?></span>
                <a href="index.php?url=student/logout" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-300">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto p-6 space-y-8">
        <!-- Welcome Section -->
        <div class="glass-card p-6 mb-6 fade-in-up">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                <i class="fas fa-tachometer-alt text-blue-600 mr-2"></i>Dashboard
            </h2>
            <p class="text-gray-600">Welcome to your hostel management dashboard. Here you can view and manage your bookings.</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="glass-card p-6 fade-in-up" data-delay="100">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-bed text-blue-600 text-xl glow-icon"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Current Booking</h3>
                        <?php if (!empty($current_booking)): ?>
                            <p class="text-gray-600">
                                Room <?= htmlspecialchars($current_booking['room_number']) ?> (<?= htmlspecialchars($current_booking['room_type']) ?>)<br>
                                Duration: <?= htmlspecialchars($current_booking['start_date']) ?> - <?= htmlspecialchars($current_booking['end_date']) ?><br>
                                Status: <?= htmlspecialchars($current_booking['payment_status']) ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-600">No active booking</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 fade-in-up" data-delay="300">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-credit-card text-blue-600 text-xl glow-icon"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Payment Status</h3>
                        <?php if (!empty($current_booking)): ?>
                            <?php if ($current_booking['payment_status'] === 'paid'): ?>
                                <p class="text-blue-600 font-semibold">Paid in full</p>
                            <?php elseif ($current_booking['payment_status'] === 'partial'): ?>
                                <p class="text-yellow-600 font-semibold">
                                    Partial (Paid: Ksh <?= number_format($current_booking['paid_amount']) ?> Balance <?= number_format($current_booking['total_amount']-$current_booking['paid_amount']) ?>)
                                </p>
                            <?php else: ?>
                                <p class="text-red-600 font-semibold">Unpaid</p>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-gray-600">No active booking</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 fade-in-up" data-delay="500">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-calendar text-yellow-600 text-xl glow-icon"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Next Due Date</h3>
                        <?php if (!empty($current_booking)): ?>
                            <p class="text-gray-600">
                                <?= htmlspecialchars($current_booking['end_date']) ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-600">N/A</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <a href="index.php?url=student/rooms" class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-lg text-center transition duration-300 fade-in-up" data-delay="700">
                <i class="fas fa-search text-2xl mb-2"></i>
                <p class="font-semibold">Browse Rooms</p>
            </a>

            <a href="index.php?url=student/bookings" class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-lg text-center transition duration-300 fade-in-up" data-delay="800">
                <i class="fas fa-calendar-check text-2xl mb-2"></i>
                <p class="font-semibold">My Bookings</p>
            </a>

            <a href="index.php?url=student/payments" class="bg-sky-600 hover:bg-sky-700 text-white p-4 rounded-lg text-center transition duration-300 fade-in-up" data-delay="900">
                <i class="fas fa-receipt text-2xl mb-2"></i>
                <p class="font-semibold">Payments</p>
            </a>

            <a href="index.php?url=student/profile" class="bg-gray-600 hover:bg-gray-700 text-white p-4 rounded-lg text-center transition duration-300 fade-in-up" data-delay="1000">
                <i class="fas fa-user text-2xl mb-2"></i>
                <p class="font-semibold">Profile</p>
            </a>
        </div>

        <!-- Student Information -->
        <div class="glass-card p-6 mb-6 fade-in-up" data-delay="1100">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-user-circle text-blue-600 mr-2"></i>Your Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Student ID</label>
                    <p class="text-gray-900"><?= htmlspecialchars($student['student_id']) ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <p class="text-gray-900"><?= htmlspecialchars($student['name']) ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <p class="text-gray-900"><?= htmlspecialchars($student['email']) ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <p class="text-gray-900"><?= htmlspecialchars($student['phone'] ?? 'Not provided') ?></p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <p class="text-gray-900"><?= htmlspecialchars($student['address'] ?? 'Not provided') ?></p>
                </div>
            </div>
        </div>

        <!-- My Bookings Section -->
        <div class="glass-card p-6 fade-in-up" data-delay="1200">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>My Bookings
            </h3>
            <div class="ml-4">
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <div class="mb-4 p-3 border rounded-lg bg-gray-50">
                            <strong>Room:</strong> <?= htmlspecialchars($booking['room_number']) ?> (<?= htmlspecialchars($booking['room_type']) ?>)<br>
                            <strong>Duration:</strong> <?= htmlspecialchars($booking['start_date']) ?> - <?= htmlspecialchars($booking['end_date']) ?><br>
                            <strong>Status:</strong> <?= htmlspecialchars($booking['payment_status']) ?><br>
                            <strong>Paid:</strong> Ksh <?= number_format($booking['paid_amount']) ?> / <?= number_format($booking['total_amount']) ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-600">No bookings found</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Clearance Section -->
        <div class="glass-card p-6 fade-in-up" data-delay="1300">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-check-circle text-blue-600 mr-2"></i>Clearance
            </h3>
            <p class="text-gray-600 mb-4">
                To proceed with your clearance, please ensure all dues are cleared and fill out the clearance form.
            </p>
            <a href="index.php?url=student/clearance" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                Request Clearance
            </a>
        </div>
    </div>

    <!-- JavaScript for scroll-triggered animations -->
    <script>
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const delay = parseInt(target.dataset.delay) || 0;
                    setTimeout(() => {
                        target.classList.add('is-visible');
                    }, delay);
                    observer.unobserve(target);
                }
            });
        }, {
            threshold: 0.1
        });

        // Observe all elements with the 'fade-in-up' class
        document.querySelectorAll('.fade-in-up').forEach(element => {
            observer.observe(element);
        });
    </script>
</body>
</html>
