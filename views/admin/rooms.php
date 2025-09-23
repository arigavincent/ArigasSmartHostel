<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Manage Rooms' ?></title>
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
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-bed text-gray-600 mr-2"></i>Manage Rooms
                    </h2>
                    <p class="text-gray-600">Add, edit, and manage all hostel rooms.</p>
                </div>
                <a href="index.php?url=admin/rooms/create" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-300">
                    <i class="fas fa-plus mr-2"></i>Add New Room
                </a>
            </div>
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

        <!-- Room Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <?php
            $total_rooms = count($rooms);
            $available_rooms = count(array_filter($rooms, fn($r) => $r['status'] === 'available'));
            $occupied_rooms = count(array_filter($rooms, fn($r) => $r['status'] === 'occupied'));
            $maintenance_rooms = count(array_filter($rooms, fn($r) => $r['status'] === 'maintenance'));
            ?>
            
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-bed text-blue-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Total Rooms</p>
                        <p class="text-xl font-bold text-gray-800"><?= $total_rooms ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Available</p>
                        <p class="text-xl font-bold text-green-600"><?= $available_rooms ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="fas fa-user text-red-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Occupied</p>
                        <p class="text-xl font-bold text-red-600"><?= $occupied_rooms ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-wrench text-yellow-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600">Maintenance</p>
                        <p class="text-xl font-bold text-yellow-600"><?= $maintenance_rooms ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rooms Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type & Capacity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Floor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($rooms as $room): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($room['room_number']) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 capitalize"><?= htmlspecialchars($room['room_type']) ?></div>
                                    <div class="text-sm text-gray-500"><?= htmlspecialchars($room['capacity']) ?> person<?= $room['capacity'] > 1 ? 's' : '' ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Floor <?= htmlspecialchars($room['floor']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ₦<?= number_format($room['price']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $status_classes = [
                                        'available' => 'bg-green-100 text-green-800',
                                        'occupied' => 'bg-red-100 text-red-800',
                                        'maintenance' => 'bg-yellow-100 text-yellow-800'
                                    ];
                                    $status_class = $status_classes[$room['status']] ?? 'bg-gray-100 text-gray-800';
                                    ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $status_class ?>">
                                        <?= ucfirst($room['status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="index.php?url=admin/rooms/edit&id=<?= $room['id'] ?>" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <a href="index.php?url=admin/rooms/delete&id=<?= $room['id'] ?>" 
                                       class="text-red-600 hover:text-red-900"
                                       onclick="return confirm('Are you sure you want to delete this room?')">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>