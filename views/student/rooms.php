<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Browse Rooms' ?></title>
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
                <a href="index.php?url=student/dashboard" class="hover:text-blue-200 text-blue-600 font-semibold transition duration-300">
                    <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                </a>
                <span class="text-gray-600">Welcome, <?= htmlspecialchars($student['name']) ?></span>
                <a href="index.php?url=student/logout" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-300">
                    <i class="fas fa-sign-out-alt mr-3"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto p-6 space-y-8">
        <!-- Page Header -->
        <div class="glass-card rounded-lg p-6 mb-6 fade-in-up" data-delay="100">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-bed text-blue-600 mr-2"></i>Browse Available Rooms
            </h2>
            <p class="text-gray-600">Find the perfect room for your stay. All rooms are currently available for booking.</p>
        </div>

        <!-- Search and Filters -->
        <div class="glass-card rounded-lg p-6 mb-6 fade-in-up" data-delay="300">
            <form method="GET" action="index.php" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="hidden" name="url" value="student/rooms">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Room Type</label>
                    <select name="room_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Types</option>
                        <option value="single" <?= $filters['room_type'] === 'single' ? 'selected' : '' ?>>Single</option>
                        <option value="double" <?= $filters['room_type'] === 'double' ? 'selected' : '' ?>>Double</option>
                        <option value="triple" <?= $filters['room_type'] === 'triple' ? 'selected' : '' ?>>Triple</option>
                        <option value="quad" <?= $filters['room_type'] === 'quad' ? 'selected' : '' ?>>Quad</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min Price (Ksh.)</label>
                    <input type="number" name="min_price" value="<?= htmlspecialchars($filters['min_price']) ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                           placeholder="0">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Price (Ksh.)</label>
                    <input type="number" name="max_price" value="<?= htmlspecialchars($filters['max_price']) ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                           placeholder="50000">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Floor</label>
                    <select name="floor" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Floors</option>
                        <option value="1" <?= $filters['floor'] === '1' ? 'selected' : '' ?>>1st Floor</option>
                        <option value="2" <?= $filters['floor'] === '2' ? 'selected' : '' ?>>2nd Floor</option>
                        <option value="3" <?= $filters['floor'] === '3' ? 'selected' : '' ?>>3rd Floor</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                </div>
            </form>
            
            <?php if (array_filter($filters)): ?>
                <div class="mt-4">
                    <a href="index.php?url=student/rooms" class="text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-times mr-1"></i>Clear all filters
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Room Results -->
        <div class="mb-4">
            <p class="text-gray-600">
                <i class="fas fa-info-circle mr-2"></i>
                Showing <?= count($rooms) ?> available room<?= count($rooms) !== 1 ? 's' : '' ?>
            </p>
        </div>

        <!-- Room Grid -->
        <?php if (empty($rooms)): ?>
            <div class="glass-card p-12 text-center fade-in-up" data-delay="500">
                <i class="fas fa-bed text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Rooms Found</h3>
                <p class="text-gray-500 mb-4">Try adjusting your filters to find available rooms.</p>
                <a href="index.php?url=student/rooms" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-300">
                    View All Rooms
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($rooms as $room): ?>
                    <div class="glass-card overflow-hidden hover:shadow-lg transition duration-300 fade-in-up" data-delay="500">
                        <!-- Room Image Placeholder -->
                        <div class="h-48 bg-gradient-to-br from-blue-100 to-blue-100 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-bed text-4xl text-blue-400 mb-2"></i>
                                <p class="text-sm text-blue-600 font-medium">Room <?= htmlspecialchars($room['room_number']) ?></p>
                            </div>
                        </div>

                        <!-- Room Details -->
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-800">Room <?= htmlspecialchars($room['room_number']) ?></h3>
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Available</span>
                            </div>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-users w-4 mr-2"></i>
                                    <span class="capitalize"><?= htmlspecialchars($room['room_type']) ?></span>
                                    <span class="mx-2">•</span>
                                    <span><?= htmlspecialchars($room['capacity']) ?> person<?= $room['capacity'] > 1 ? 's' : '' ?></span>
                                </div>

                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-building w-4 mr-2"></i>
                                    <span>Floor <?= htmlspecialchars($room['floor']) ?></span>
                                </div>

                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-tag w-4 mr-2"></i>
                                    <span class="font-semibold text-blue-600">Ksh.<?= number_format($room['price']) ?>/month</span>
                                </div>
                            </div>

                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                <?= htmlspecialchars($room['description']) ?>
                            </p>

                            <div class="flex space-x-2">
                                <a href="index.php?url=student/room-details&id=<?= $room['id'] ?>" 
                                   class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-center text-sm transition duration-300">
                                    <i class="fas fa-eye mr-1"></i>View Details
                                </a>
                                <a href="index.php?url=student/book&room_id=<?= $room['id'] ?>" 
                                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-center text-sm transition duration-300">
                                    <i class="fas fa-calendar-plus mr-1"></i>Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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
