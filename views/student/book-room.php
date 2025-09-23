<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Book Room' ?></title>
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
                <a href="index.php?url=student/rooms" class="hover:text-indigo-200">
                    <i class="fas fa-arrow-left mr-1"></i>Back to Rooms
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
                    <i class="fas fa-calendar-plus text-indigo-600 mr-2"></i>Book Room <?= htmlspecialchars($room['room_number']) ?>
                </h2>
                <p class="text-gray-600">Complete the form below to book your room.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Room Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-bed text-indigo-600 mr-2"></i>Room Details
                    </h3>

                    <!-- Room Image Placeholder -->
                    <div class="h-48 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <div class="text-center">
                            <i class="fas fa-bed text-5xl text-indigo-400 mb-2"></i>
                            <p class="text-lg text-indigo-600 font-medium">Room <?= htmlspecialchars($room['room_number']) ?></p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Room Number:</span>
                            <span class="font-semibold"><?= htmlspecialchars($room['room_number']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Room Type:</span>
                            <span class="font-semibold capitalize"><?= htmlspecialchars($room['room_type']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Capacity:</span>
                            <span class="font-semibold"><?= htmlspecialchars($room['capacity']) ?> person<?= $room['capacity'] > 1 ? 's' : '' ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Floor:</span>
                            <span class="font-semibold">Floor <?= htmlspecialchars($room['floor']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Price per Month:</span>
                            <span class="font-bold text-indigo-600 text-lg">Ksh.<?= number_format($room['price']) ?></span>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-gray-50 rounded">
                        <h4 class="font-semibold text-gray-800 mb-2">Description:</h4>
                        <p class="text-gray-600 text-sm"><?= htmlspecialchars($room['description']) ?></p>
                    </div>
                </div>

                <!-- Booking Form -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-calendar text-indigo-600 mr-2"></i>Booking Information
                    </h3>

                    <?php if (isset($_SESSION['booking_error'])): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <span class="block sm:inline"><?= $_SESSION['booking_error'] ?></span>
                        </div>
                        <?php unset($_SESSION['booking_error']); ?>
                    <?php endif; ?>

                    <form action="index.php?url=student/book/store" method="POST" class="space-y-6">
                        <input type="hidden" name="room_id" value="<?= $room['id'] ?>">

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt mr-2"></i>Check-in Date
                            </label>
                            <input type="date" id="start_date" name="start_date" required
                                   min="<?= date('Y-m-d') ?>"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   onchange="calculateTotal()">
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-check mr-2"></i>Check-out Date
                            </label>
                            <input type="date" id="end_date" name="end_date" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   onchange="calculateTotal()">
                        </div>

                        <!-- Duration and Cost Calculation -->
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-indigo-800 mb-2">Booking Summary</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span>Duration:</span>
                                    <span id="duration">Select dates</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Monthly Rate:</span>
                                    <span>Ksh.<?= number_format($room['price']) ?></span>
                                </div>
                                <div class="flex justify-between font-bold text-lg border-t pt-2">
                                    <span>Total Amount:</span>
                                    <span id="total_amount">Ksh.0</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-yellow-600 mt-1 mr-2"></i>
                                <div class="text-sm text-yellow-800">
                                    <strong>Important:</strong>
                                    <ul class="mt-1 list-disc list-inside">
                                        <li>Payment is required within 24 hours of booking</li>
                                        <li>Cancellation is allowed up to 48 hours before check-in</li>
                                        <li>Room will be marked as occupied once booked</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="agree_terms" name="agree_terms" required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="agree_terms" class="ml-2 block text-sm text-gray-700">
                                I agree to the terms and conditions and booking policies
                            </label>
                        </div>

                        <button type="submit" 
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                            <i class="fas fa-calendar-plus mr-2"></i>Confirm Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateTotal() {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            const pricePerMonth = <?= $room['price'] ?>;

            if (startDate && endDate && endDate > startDate) {
                const timeDiff = endDate.getTime() - startDate.getTime();
                const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                const months = Math.ceil(daysDiff / 30);

                document.getElementById('duration').textContent = daysDiff + ' days (' + months + ' month' + (months !== 1 ? 's' : '') + ')';
                document.getElementById('total_amount').textContent = 'Ksh.' + (pricePerMonth * months).toLocaleString();
            } else {
                document.getElementById('duration').textContent = 'Select dates';
                document.getElementById('total_amount').textContent = 'Ksh.0';
            }
        }

        // Set minimum end date when start date changes
        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = this.value;
            document.getElementById('end_date').min = startDate;
        });
    </script>
</body>
</html>