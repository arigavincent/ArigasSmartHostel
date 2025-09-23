<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Room Details' ?></title>
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
            <!-- Room Header -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <!-- Room Image/Banner -->
                <div class="h-64 bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center">
                    <div class="text-center">
                        <i class="fas fa-bed text-8xl text-indigo-400 mb-4"></i>
                        <h1 class="text-3xl font-bold text-indigo-600">Room <?= htmlspecialchars($room['room_number']) ?></h1>
                        <p class="text-lg text-indigo-500 capitalize"><?= htmlspecialchars($room['room_type']) ?> Room</p>
                    </div>
                </div>

                <!-- Room Basic Info -->
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <div class="flex items-center mb-2">
                                <h2 class="text-2xl font-bold text-gray-800 mr-4">Room <?= htmlspecialchars($room['room_number']) ?></h2>
                                <?php
                                $status_classes = [
                                    'available' => 'bg-green-100 text-green-800',
                                    'occupied' => 'bg-red-100 text-red-800',
                                    'maintenance' => 'bg-yellow-100 text-yellow-800'
                                ];
                                $status_class = $status_classes[$room['status']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="<?= $status_class ?> px-3 py-1 rounded-full text-sm font-medium">
                                    <?= ucfirst($room['status']) ?>
                                </span>
                            </div>
                            <p class="text-gray-600 mb-4"><?= htmlspecialchars($room['description']) ?></p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-indigo-600 mb-2">Ksh.<?= number_format($room['price']) ?></div>
                            <div class="text-gray-600">per month</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Room Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Room Specifications -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-info-circle text-indigo-600 mr-2"></i>Room Specifications
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-door-open text-indigo-600 text-xl mr-3"></i>
                                <div>
                                    <div class="text-sm text-gray-600">Room Number</div>
                                    <div class="font-semibold"><?= htmlspecialchars($room['room_number']) ?></div>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-bed text-indigo-600 text-xl mr-3"></i>
                                <div>
                                    <div class="text-sm text-gray-600">Room Type</div>
                                    <div class="font-semibold capitalize"><?= htmlspecialchars($room['room_type']) ?></div>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-users text-indigo-600 text-xl mr-3"></i>
                                <div>
                                    <div class="text-sm text-gray-600">Capacity</div>
                                    <div class="font-semibold"><?= $room['capacity'] ?> person<?= $room['capacity'] > 1 ? 's' : '' ?></div>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-building text-indigo-600 text-xl mr-3"></i>
                                <div>
                                    <div class="text-sm text-gray-600">Floor</div>
                                    <div class="font-semibold">Floor <?= $room['floor'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Room Features -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-star text-indigo-600 mr-2"></i>Room Features
                        </h3>
                        <div class="grid grid-cols-2 gap-3">
                            <?php
                            // Standard features based on room type
                            $features = [
                                'single' => [
                                    'Single bed with mattress',
                                    'Study desk and chair',
                                    'Wardrobe/closet',
                                    'Window with natural light',
                                    'Power outlets',
                                    'WiFi access'
                                ],
                'double' => [
                                    'Two beds with mattresses',
                                    'Two study desks and chairs',
                                    'Shared wardrobe space',
                                    'Window with natural light',
                                    'Power outlets',
                                    'WiFi access',
                                    'Shared bathroom access'
                                ],
                                'triple' => [
                                    'Three beds with mattresses',
                                    'Three study desks',
                                    'Ample storage space',
                                    'Large windows',
                                    'Multiple power outlets',
                                    'WiFi access',
                                    'Shared bathroom'
                                ],
                                'quad' => [
                                    'Four beds with mattresses',
                                    'Four study stations',
                                    'Individual storage units',
                                    'Spacious layout',
                                    'Multiple power outlets',
                                    'WiFi access',
                                    'Shared bathroom',
                                    'Common study area'
                                ]
                            ];
                            
                            $room_features = $features[$room['room_type']] ?? ['Basic room amenities'];
                            ?>
                            <?php foreach ($room_features as $feature): ?>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-600 mr-2"></i>
                                    <span class="text-gray-700"><?= $feature ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Floor Plan/Layout -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-map text-indigo-600 mr-2"></i>Room Layout
                        </h3>
                        <div class="bg-gray-50 rounded-lg p-6 text-center">
                            <i class="fas fa-home text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-600">Floor plan and room layout visualization</p>
                            <p class="text-sm text-gray-500 mt-2">Contact admin for detailed floor plans</p>
                        </div>
                    </div>
                </div>

                <!-- Booking Panel -->
                <div class="space-y-6">
                    <!-- Quick Booking -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-calendar-plus text-indigo-600 mr-2"></i>Book This Room
                        </h3>
                        
                        <?php if ($room['status'] === 'available'): ?>
                            <div class="space-y-4">
                                <div class="bg-indigo-50 p-4 rounded-lg">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-indigo-600">Ksh.<?= number_format($room['price']) ?></div>
                                        <div class="text-sm text-indigo-500">per month</div>
                                    </div>
                                </div>
                                
                                <a href="index.php?url=student/book&room_id=<?= $room['id'] ?>" 
                                   class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 block text-center">
                                    <i class="fas fa-calendar-plus mr-2"></i>Book Now
                                </a>
                                
                                <div class="text-xs text-gray-500 text-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Free cancellation up to 48 hours before check-in
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="text-center">
                                <i class="fas fa-times-circle text-red-400 text-3xl mb-3"></i>
                                <p class="text-red-600 font-medium">Room Not Available</p>
                                <p class="text-sm text-gray-500 mt-2">
                                    This room is currently <?= $room['status'] === 'occupied' ? 'occupied' : 'under maintenance' ?>
                                </p>
                                <a href="index.php?url=student/rooms" 
                                   class="mt-4 inline-block bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-300">
                                    <i class="fas fa-search mr-2"></i>Find Other Rooms
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Room Status Info -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">
                            <i class="fas fa-info text-indigo-600 mr-2"></i>Important Information
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start">
                                <i class="fas fa-clock text-blue-600 mt-1 mr-2"></i>
                                <div>
                                    <div class="font-medium">Check-in Time</div>
                                    <div class="text-gray-600">Flexible, coordinate with admin</div>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-credit-card text-green-600 mt-1 mr-2"></i>
                                <div>
                                    <div class="font-medium">Payment</div>
                                    <div class="text-gray-600">Monthly in advance</div>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-shield-alt text-purple-600 mt-1 mr-2"></i>
                                <div>
                                    <div class="font-medium">Security</div>
                                    <div class="text-gray-600">24/7 security available</div>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-wifi text-indigo-600 mt-1 mr-2"></i>
                                <div>
                                    <div class="font-medium">Internet</div>
                                    <div class="text-gray-600">High-speed WiFi included</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">
                            <i class="fas fa-phone text-indigo-600 mr-2"></i>Need Help?
                        </h3>
                        <div class="space-y-2 text-sm">
                            <p class="text-gray-600">Have questions about this room?</p>
                            <div class="bg-gray-50 p-3 rounded">
                                <div class="font-medium">Hostel Administration</div>
                                <div class="text-gray-600">Email: admin@hostel.com</div>
                                <div class="text-gray-600">Available 24/7</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>