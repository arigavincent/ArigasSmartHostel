<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
                <a href="index.php?url=admin/bookings" class="hover:text-gray-300">
                    <i class="fas fa-calendar mr-1"></i>Bookings
                </a>
                <a href="index.php?url=admin/students" class="hover:text-gray-300">
                    <i class="fas fa-users mr-1"></i>Students
                </a>
                <span class="text-gray-300">Welcome, Admin User</span>
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
                <i class="fas fa-chart-bar text-purple-600 mr-2"></i>Reports & Analytics
            </h2>
            <p class="text-gray-600">Comprehensive hostel management analytics and insights.</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Room Occupancy -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Room Occupancy</p>
                        <p class="text-3xl font-bold" id="occupancy-rate">
                            <?= htmlspecialchars($room_stats['occupancy_rate']) ?>%
                        </p>
                        <p class="text-blue-100 text-sm">
                            <span id="occupied-rooms"><?= htmlspecialchars($room_stats['occupied']) ?></span>
                            of
                            <span id="total-rooms"><?= htmlspecialchars($room_stats['total']) ?></span> rooms
                        </p>
                    </div>
                    <i class="fas fa-bed text-4xl text-blue-200"></i>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Total Revenue</p>
                        <p class="text-3xl font-bold" id="total-revenue">
                            Ksh.<?= number_format($financial_stats['total_revenue']) ?>
                        </p>
                        <p class="text-green-100 text-sm">
                            Avg: <span id="avg-booking">Ksh.<?= number_format($financial_stats['average_booking_value']) ?></span>
                        </p>
                    </div>
                    <i class="fas fa-money-bill-wave text-4xl text-green-200"></i>
                </div>
            </div>

            <!-- Active Students -->
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm">Total Students</p>
                        <p class="text-3xl font-bold" id="total-students">
                            <?= htmlspecialchars($student_stats['total']) ?>
                        </p>
                        <p class="text-yellow-100 text-sm">
                            <span id="students-with-bookings"><?= htmlspecialchars($student_stats['with_bookings']) ?></span> with bookings
                        </p>
                    </div>
                    <i class="fas fa-users text-4xl text-yellow-200"></i>
                </div>
            </div>

            <!-- Pending Revenue -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm">Pending Revenue</p>
                        <p class="text-3xl font-bold" id="pending-revenue">
                            Ksh.<?= number_format($financial_stats['pending_revenue']) ?>
                        </p>
                        <p class="text-red-100 text-sm">Unpaid bookings</p>
                                            </div>
                    <i class="fas fa-exclamation-triangle text-4xl text-red-200"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Monthly Bookings Chart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-chart-line text-blue-600 mr-2"></i>Monthly Bookings Trend
                </h3>
                <canvas id="monthlyBookingsChart" width="400" height="200"></canvas>
            </div>

            <!-- Room Type Distribution -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-chart-pie text-green-600 mr-2"></i>Room Type Distribution
                </h3>
                <canvas id="roomTypeChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Detailed Statistics Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Room Statistics -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-building text-indigo-600 mr-2"></i>Room Statistics
                </h3>
                <div class="space-y-3" id="room-stats-table">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <span class="text-gray-700">Total Rooms</span>
                        <span class="font-bold text-gray-900"><?= htmlspecialchars($room_stats['total']) ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-green-50 rounded">
                        <span class="text-gray-700">Available Rooms</span>
                        <span class="font-bold text-green-600"><?= htmlspecialchars($room_stats['available']) ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-red-50 rounded">
                        <span class="text-gray-700">Occupied Rooms</span>
                        <span class="font-bold text-red-600"><?= htmlspecialchars($room_stats['occupied']) ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-blue-50 rounded">
                        <span class="text-gray-700">Occupancy Rate</span>
                        <span class="font-bold text-blue-600"><?= htmlspecialchars($room_stats['occupancy_rate']) ?>%</span>
                    </div>
                </div>
            </div>

            <!-- Booking Statistics -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-calendar-alt text-purple-600 mr-2"></i>Booking Statistics
                </h3>
                <div class="space-y-3" id="booking-stats-table">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <span class="text-gray-700">Total Bookings</span>
                        <span class="font-bold text-gray-900"><?= htmlspecialchars($booking_stats['total']) ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-green-50 rounded">
                        <span class="text-gray-700">Active Bookings</span>
                        <span class="font-bold text-green-600"><?= htmlspecialchars($booking_stats['active']) ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-red-50 rounded">
                        <span class="text-gray-700">Cancelled Bookings</span>
                        <span class="font-bold text-red-600"><?= htmlspecialchars($booking_stats['cancelled']) ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-yellow-50 rounded">
                        <span class="text-gray-700">Cancellation Rate</span>
                        <span class="font-bold text-yellow-600"><?= htmlspecialchars($booking_stats['cancellation_rate']) ?>%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Options -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-download text-gray-600 mr-2"></i>Export Reports
            </h3>
            <div class="flex space-x-4 flex-wrap gap-2">
                <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-300">
                    <i class="fas fa-print mr-2"></i>Print Report
                </button>
                <button onclick="exportToPDF()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition duration-300">
                    <i class="fas fa-file-pdf mr-2"></i>Export as PDF
                </button>
                <button onclick="exportToCSV()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition duration-300">
                    <i class="fas fa-file-csv mr-2"></i>Export as CSV
                </button>
                <button onclick="exportDetailedCSV()" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition duration-300">
                    <i class="fas fa-table mr-2"></i>Detailed CSV
                </button>
            </div>
            
            <!-- Export Status -->
            <div id="export-status" class="mt-4 hidden">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span id="export-message">Export completed successfully!</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Pass PHP data to JS
        const reportsData = {
            room_stats: <?= json_encode($room_stats) ?>,
            financial_stats: <?= json_encode($financial_stats) ?>,
            student_stats: <?= json_encode($student_stats) ?>,
            booking_stats: <?= json_encode($booking_stats) ?>,
            monthly_bookings: <?= json_encode($monthly_bookings) ?>,
            room_types: <?= json_encode($room_types) ?>,
        };
        const detailedBookings = <?= json_encode($detailed_bookings) ?>;

        
        

        // Chart initialization
        const monthlyLabels = reportsData.monthly_bookings.map(item => {
            const date = new Date(item.month + '-01');
            return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
        });
        const monthlyBookings = reportsData.monthly_bookings.map(item => item.bookings);

        new Chart(document.getElementById('monthlyBookingsChart'), {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Bookings',
                    data: monthlyBookings,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const roomTypeLabels = reportsData.room_types.map(item => item.room_type);
        const roomTypeCounts = reportsData.room_types.map(item => item.count);

        new Chart(document.getElementById('roomTypeChart'), {
            type: 'doughnut',
            data: {
                labels: roomTypeLabels,
                datasets: [{
                    data: roomTypeCounts,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Utility functions
        function showExportStatus(message, isSuccess = true) {
            const statusDiv = document.getElementById('export-status');
            const messageSpan = document.getElementById('export-message');
            
            messageSpan.textContent = message;
            statusDiv.className = isSuccess 
                ? 'mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded'
                : 'mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
            
            statusDiv.classList.remove('hidden');
            
            setTimeout(() => {
                statusDiv.classList.add('hidden');
            }, 3000);
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('en-KE', {
                style: 'currency',
                currency: 'KES',
                minimumFractionDigits: 0
            }).format(amount);
        }

        // PDF Export Function
        function exportToPDF() {
            try {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF();
                
                // Set up the document
                const pageWidth = pdf.internal.pageSize.width;
                const margin = 20;
                let yPosition = margin;
                
                // Header
                pdf.setFontSize(20);
                pdf.setTextColor(75, 85, 99);
                pdf.text('Hostel Management Reports & Analytics', margin, yPosition);
                yPosition += 15;
                
                // Date
                pdf.setFontSize(12);
                pdf.setTextColor(107, 114, 128);
                pdf.text(`Generated on: ${new Date().toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                })}`, margin, yPosition);
                yPosition += 20;
                
                // Summary Statistics
                pdf.setFontSize(16);
                pdf.setTextColor(55, 65, 81);
                pdf.text('Summary Statistics', margin, yPosition);
                yPosition += 10;
                
                pdf.setFontSize(12);
                pdf.setTextColor(75, 85, 99);
                
                const summaryStats = [
                    [`Room Occupancy Rate: ${reportsData.room_stats.occupancy_rate}%`],
                    [`Total Revenue: ${formatCurrency(reportsData.financial_stats.total_revenue)}`],
                    [`Total Students: ${reportsData.student_stats.total}`],
                    [`Pending Revenue: ${formatCurrency(reportsData.financial_stats.pending_revenue)}`],
                    [`Active Bookings: ${reportsData.booking_stats.active}`],
                    [`Cancellation Rate: ${reportsData.booking_stats.cancellation_rate}%`]
                ];
                
                summaryStats.forEach(stat => {
                    pdf.text(stat[0], margin, yPosition);
                    yPosition += 8;
                });
                
                yPosition += 10;
                
                // Room Statistics Table
                pdf.setFontSize(14);
                pdf.setTextColor(55, 65, 81);
                pdf.text('Room Statistics', margin, yPosition);
                yPosition += 10;
                
                const roomStatsTable = [
                    ['Metric', 'Value'],
                    ['Total Rooms', reportsData.room_stats.total.toString()],
                    ['Occupied Rooms', reportsData.room_stats.occupied.toString()],
                    ['Available Rooms', reportsData.room_stats.available.toString()],
                    ['Occupancy Rate', `${reportsData.room_stats.occupancy_rate}%`]
                ];
                
                // Simple table rendering
                pdf.setFontSize(10);
                const cellHeight = 8;
                const colWidth = (pageWidth - 2 * margin) / 2;
                
                roomStatsTable.forEach((row, index) => {
                    const x = margin;
                    const y = yPosition + (index * cellHeight);
                    
                    if (index === 0) {
                        pdf.setFont(undefined, 'bold');
                        pdf.setFillColor(240, 240, 240);
                        pdf.rect(x, y - 2, colWidth * 2, cellHeight, 'F');
                    } else {
                        pdf.setFont(undefined, 'normal');
                        if (index % 2 === 0) {
                            pdf.setFillColor(250, 250, 250);
                            pdf.rect(x, y - 2, colWidth * 2, cellHeight, 'F');
                        }
                    }
                    
                    pdf.text(row[0], x + 2, y + 4);
                    pdf.text(row[1], x + colWidth + 2, y + 4);
                });
                
                yPosition += (roomStatsTable.length * cellHeight) + 15;
                
                // Monthly Bookings Data
                pdf.setFontSize(14);
                pdf.setTextColor(55, 65, 81);
                pdf.text('Monthly Bookings', margin, yPosition);
                yPosition += 10;
                
                const monthlyData = [
                    ['Month', 'Bookings'],
                    ...reportsData.monthly_bookings.map(item => [
                        new Date(item.month + '-01').toLocaleDateString('en-US', { month: 'short', year: 'numeric' }),
                        item.bookings.toString()
                    ])
                ];
                
                pdf.setFontSize(10);
                monthlyData.forEach((row, index) => {
                    const x = margin;
                    const y = yPosition + (index * cellHeight);
                    
                    if (index === 0) {
                        pdf.setFont(undefined, 'bold');
                        pdf.setFillColor(240, 240, 240);
                        pdf.rect(x, y - 2, colWidth * 2, cellHeight, 'F');
                    } else {
                        pdf.setFont(undefined, 'normal');
                        if (index % 2 === 0) {
                            pdf.setFillColor(250, 250, 250);
                            pdf.rect(x, y - 2, colWidth * 2, cellHeight, 'F');
                        }
                    }
                    
                    pdf.text(row[0], x + 2, y + 4);
                    pdf.text(row[1], x + colWidth + 2, y + 4);
                });
                
                // Save the PDF
                const fileName = `hostel_report_${new Date().toISOString().split('T')[0]}.pdf`;
                pdf.save(fileName);
                
                showExportStatus(`PDF report exported successfully as ${fileName}`);
                
            } catch (error) {
                console.error('PDF export error:', error);
                showExportStatus('Failed to export PDF. Please try again.', false);
            }
        }

        // CSV Export Function - Summary Data
        function exportToCSV() {
            try {
                const csvData = [];
                const currentDate = new Date().toISOString().split('T')[0];
                
                // Add header information
                csvData.push(['Hostel Management Report']);
                csvData.push([`Generated on: ${new Date().toLocaleString()}`]);
                csvData.push(['']);
                
                // Summary Statistics
                csvData.push(['Summary Statistics']);
                csvData.push(['Metric', 'Value']);
                csvData.push(['Room Occupancy Rate', `${reportsData.room_stats.occupancy_rate}%`]);
                csvData.push(['Total Rooms', reportsData.room_stats.total]);
                csvData.push(['Occupied Rooms', reportsData.room_stats.occupied]);
                csvData.push(['Available Rooms', reportsData.room_stats.available]);
                csvData.push(['Total Revenue', `KES ${reportsData.financial_stats.total_revenue.toLocaleString()}`]);
                csvData.push(['Average Booking Value', `KES ${reportsData.financial_stats.average_booking_value.toLocaleString()}`]);
                csvData.push(['Pending Revenue', `KES ${reportsData.financial_stats.pending_revenue.toLocaleString()}`]);
                csvData.push(['Total Students', reportsData.student_stats.total]);
                csvData.push(['Students with Bookings', reportsData.student_stats.with_bookings]);
                csvData.push(['Total Bookings', reportsData.booking_stats.total]);
                csvData.push(['Active Bookings', reportsData.booking_stats.active]);
                csvData.push(['Cancelled Bookings', reportsData.booking_stats.cancelled]);
                csvData.push(['Cancellation Rate', `${reportsData.booking_stats.cancellation_rate}%`]);
                csvData.push(['']);
                
                // Monthly Bookings
                csvData.push(['Monthly Bookings']);
                csvData.push(['Month', 'Bookings']);
                reportsData.monthly_bookings.forEach(item => {
                    const monthName = new Date(item.month + '-01').toLocaleDateString('en-US', { 
                        month: 'long', 
                        year: 'numeric' 
                    });
                    csvData.push([monthName, item.bookings]);
                });
                csvData.push(['']);
                
                // Room Types
                csvData.push(['Room Type Distribution']);
                csvData.push(['Room Type', 'Count']);
                reportsData.room_types.forEach(item => {
                    csvData.push([item.room_type, item.count]);
                });
                
                // Convert to CSV string
                const csvString = csvData.map(row => 
                    row.map(cell => {
                        // Escape quotes and wrap in quotes if contains comma or quote
                        const cellStr = String(cell);
                        if (cellStr.includes(',') || cellStr.includes('"') || cellStr.includes('\n')) {
                            return `"${cellStr.replace(/"/g, '""')}"`;
                        }
                        return cellStr;
                    }).join(',')
                ).join('\n');
                
                // Create and download file
                const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const fileName = `hostel_report_${currentDate}.csv`;
                
                if (link.download !== undefined) {
                    const url = URL.createObjectURL(blob);
                    link.setAttribute('href', url);
                    link.setAttribute('download', fileName);
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(url);
                }
                
                showExportStatus(`CSV report exported successfully as ${fileName}`);
                
            } catch (error) {
                console.error('CSV export error:', error);
                showExportStatus('Failed to export CSV. Please try again.', false);
            }
        }

        // CSV Export Function - Detailed Bookings Data
        function exportDetailedCSV() {
    try {
        const csvData = [];
        const currentDate = new Date().toISOString().split('T')[0];

        // Header
        csvData.push(['Detailed Hostel Bookings Report']);
        csvData.push([`Generated on: ${new Date().toLocaleString()}`]);
        csvData.push(['']);

        // Booking details header
        csvData.push([
            'Booking ID',
            'Student Name', 
            'Room Number',
            'Room Type',
            'Check-in Date',
            'Check-out Date',
            'Amount (KES)',
            'Booking Status',
            'Payment Status'
        ]);

        // Add booking data from PHP
        detailedBookings.forEach(booking => {
            csvData.push([
                booking.id,
                booking.student_name,
                booking.room_number,
                booking.room_type,
                booking.check_in,
                booking.check_out,
                booking.amount.toLocaleString(),
                booking.status,
                booking.payment_status
            ]);
        });

        csvData.push(['']);
        csvData.push(['Summary']);
        csvData.push(['Total Bookings', detailedBookings.length]);
        csvData.push(['Total Revenue', `KES ${detailedBookings.reduce((sum, booking) => sum + booking.amount, 0).toLocaleString()}`]);
        csvData.push(['Active Bookings', detailedBookings.filter(b => b.status === 'Active').length]);
        csvData.push(['Pending Payments', detailedBookings.filter(b => b.payment_status === 'Pending').length]);

        // Convert to CSV string
        const csvString = csvData.map(row => 
            row.map(cell => {
                const cellStr = String(cell);
                if (cellStr.includes(',') || cellStr.includes('"') || cellStr.includes('\n')) {
                    return `"${cellStr.replace(/"/g, '""')}"`;
                }
                return cellStr;
            }).join(',')
        ).join('\n');

        // Create and download file
        const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const fileName = `hostel_detailed_report_${currentDate}.csv`;

        if (link.download !== undefined) {
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', fileName);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }

        showExportStatus(`Detailed CSV report exported successfully as ${fileName}`);

    } catch (error) {
        console.error('Detailed CSV export error:', error);
        showExportStatus('Failed to export detailed CSV. Please try again.', false);
    }
}
    </script>
</body>
</html>