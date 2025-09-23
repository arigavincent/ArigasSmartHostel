<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Add New Room' ?></title>
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
                <a href="index.php?url=admin/rooms" class="hover:text-gray-300">
                    <i class="fas fa-arrow-left mr-1"></i>Back to Rooms
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
        <div class="max-w-2xl mx-auto">
            <!-- Page Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-plus text-blue-600 mr-2"></i>Add New Room
                </h2>
                <p class="text-gray-600">Fill in the details to add a new room to the system.</p>
            </div>

            <!-- Messages -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <span class="block sm:inline"><?= $_SESSION['error'] ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Add Room Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="index.php?url=admin/rooms/store" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="room_number" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-door-open mr-2"></i>Room Number *
                            </label>
                            <input type="text" id="room_number" name="room_number" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="e.g. 104">
                        </div>

                        <div>
                            <label for="room_type" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-bed mr-2"></i>Room Type *
                            </label>
                            <select id="room_type" name="room_type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    onchange="updateCapacity()">
                                <option value="">Select room type</option>
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                                <option value="triple">Triple</option>
                                <option value="quad">Quad</option>
                            </select>
                        </div>

                        <div>
                            <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-users mr-2"></i>Capacity *
                            </label>
                            <input type="number" id="capacity" name="capacity" required min="1" max="6"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Number of people">
                        </div>

                        <div>
                            <label for="floor" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-building mr-2"></i>Floor *
                            </label>
                            <select id="floor" name="floor" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select floor</option>
                                <option value="1">1st Floor</option>
                                <option value="2">2nd Floor</option>
                                <option value="3">3rd Floor</option>
                                <option value="4">4th Floor</option>
                            </select>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag mr-2"></i>Price per Month (₦) *
                            </label>
                            <input type="number" id="price" name="price" required min="0" step="0.01"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="5000.00">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-info-circle mr-2"></i>Status
                            </label>
                            <select id="status" name="status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="available">Available</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left mr-2"></i>Description
                        </label>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Describe the room features, amenities, etc."></textarea>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-blue-800 mb-2">Room Preview</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Room:</span>
                                <span id="preview_room" class="font-medium">-</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Type:</span>
                                <span id="preview_type" class="font-medium">-</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Capacity:</span>
                                <span id="preview_capacity" class="font-medium">-</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Price:</span>
                                <span id="preview_price" class="font-medium">₦-</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                            <i class="fas fa-save mr-2"></i>Add Room
                        </button>
                        <a href="index.php?url=admin/rooms"
                           class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 text-center">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateCapacity() {
            const roomType = document.getElementById('room_type').value;
            const capacityInput = document.getElementById('capacity');
            
            const capacities = {
                'single': 1,
                'double': 2,
                'triple': 3,
                'quad': 4
            };
            
            if (capacities[roomType]) {
                capacityInput.value = capacities[roomType];
            }
            
            updatePreview();
        }

        function updatePreview() {
            document.getElementById('preview_room').textContent = 
                document.getElementById('room_number').value || '-';
            document.getElementById('preview_type').textContent = 
                document.getElementById('room_type').value || '-';
            document.getElementById('preview_capacity').textContent = 
                document.getElementById('capacity').value || '-';
            document.getElementById('preview_price').textContent = 
                '₦' + (document.getElementById('price').value || '-');
        }

        // Add event listeners for real-time preview
        document.getElementById('room_number').addEventListener('input', updatePreview);
        document.getElementById('room_type').addEventListener('change', updatePreview);
        document.getElementById('capacity').addEventListener('input', updatePreview);
        document.getElementById('price').addEventListener('input', updatePreview);
    </script>
</body>
</html>