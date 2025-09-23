<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Make Payment' ?></title>
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
                <a href="index.php?url=student/payments" class="hover:text-indigo-200">
                    <i class="fas fa-arrow-left mr-1"></i>Back to Payments
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
        <div class="max-w-2xl mx-auto">
            <!-- Page Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-credit-card text-indigo-600 mr-2"></i>Make Payment
                </h2>
                <p class="text-gray-600">Complete your booking payment securely.</p>
            </div>

            <!-- Booking Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-receipt text-gray-600 mr-2"></i>Booking Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Booking ID</label>
                        <p class="font-mono text-gray-900"><?= htmlspecialchars($booking['booking_id']) ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Room</label>
                        <p class="text-gray-900">Room <?= htmlspecialchars($booking['room_number']) ?> (<?= ucfirst($booking['room_type']) ?>)</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Duration</label>
                        <p class="text-gray-900"><?= date('M j, Y', strtotime($booking['start_date'])) ?> - <?= date('M j, Y', strtotime($booking['end_date'])) ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Total Amount</label>
                        <p class="text-xl font-bold text-indigo-600">Ksh.<?= number_format($booking['total_amount']) ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Amount Paid</label>
                        <p class="text-lg font-bold text-green-600">Ksh.<?= number_format($booking['paid_amount'] ?? 0) ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Remaining Balance</label>
                        <p class="text-xl font-bold text-red-600">Ksh.<?= number_format($booking['remaining_balance'] ?? $booking['total_amount']) ?></p>
                    </div>
                </div>
                
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-yellow-600 mt-1 mr-2"></i>
                        <div class="text-sm text-yellow-800">
                            <strong>Payment Status:</strong> <?= ucfirst($booking['payment_status']) ?>
                            <?php $remaining = $booking['remaining_balance'] ?? ($booking['total_amount'] - ($booking['paid_amount'] ?? 0)); ?>
                            <?php if ($remaining > 0): ?>
                                <br><strong>Outstanding Balance:</strong> Ksh.<?= number_format($remaining) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-money-check-alt text-green-600 mr-2"></i>Payment Information
                </h3>
                
                <form action="index.php?url=student/process-payment" method="POST" class="space-y-6">
                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                    
                    <div>
                        <label for="payment_amount" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-dollar-sign mr-2"></i>Payment Amount (Ksh.) *
                        </label>
                        <?php $remaining = $booking['remaining_balance'] ?? ($booking['total_amount'] - ($booking['paid_amount'] ?? 0)); ?>
                        <input type="number" id="payment_amount" name="payment_amount" required 
                               min="100" max="<?= $remaining ?>" step="0.01"
                               value="<?= $remaining ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-lg"
                               placeholder="Enter amount to pay">
                        <p class="text-sm text-gray-500 mt-1">Remaining balance: Ksh.<?= number_format($remaining) ?></p>
                    </div>

                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-credit-card mr-2"></i>Payment Method *
                        </label>
                        <select id="payment_method" name="payment_method" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-lg">
                            <option value="">Select payment method</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Credit/Debit Card</option>
                            <option value="mobile_money">Mobile Money</option>
                            <option value="cash">Cash Payment</option>
                        </select>
                    </div>

                    <!-- Payment Summary -->
                    <div class="bg-green-50 p-6 rounded-lg">
                        <h4 class="font-semibold text-green-800 mb-4">Payment Summary</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span>Total Booking Amount:</span>
                                <span class="font-medium">Ksh.<?= number_format($booking['total_amount']) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Already Paid:</span>
                                <span class="font-medium text-green-600">Ksh.<?= number_format($booking['paid_amount'] ?? 0) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Remaining Balance:</span>
                                <span class="font-medium text-red-600">Ksh.<?= number_format($booking['remaining_balance'] ?? ($booking['total_amount'] - ($booking['paid_amount'] ?? 0))) ?></span>
                            </div>
                            <hr class="border-green-200">
                            <div class="flex justify-between">
                                <span>Current Payment:</span>
                                <span id="display_amount" class="font-medium">Ksh.<?= number_format($booking['remaining_balance'] ?? $booking['total_amount']) ?></span>
                            </div>
                            <div class="flex justify-between font-bold text-lg">
                                <span>Status After Payment:</span>
                                <span id="payment_status" class="text-green-600">Paid</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-600 mt-1 mr-2"></i>
                            <div class="text-sm text-blue-800">
                                <strong>Payment Instructions:</strong>
                                <ul class="mt-2 list-disc list-inside space-y-1">
                                    <li>You can make partial payments if needed</li>
                                    <li>Full payment marks your booking as "Paid"</li>
                                    <li>Payment confirmation will be sent to your email</li>
                                    <li>Contact admin if you face any issues</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        <button type="submit"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg transition duration-300 text-lg">
                            <i class="fas fa-check mr-2"></i>Process Payment
                        </button>
                        <a href="index.php?url=student/payments"
                           class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-4 px-6 rounded-lg transition duration-300 text-center text-lg">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updatePaymentSummary() {
            const amount = parseFloat(document.getElementById('payment_amount').value) || 0;
            const totalAmount = <?= $booking['total_amount'] ?>;
            
            document.getElementById('display_amount').textContent = 'Ksh.' + amount.toLocaleString();
            
            const statusElement = document.getElementById('payment_status');
            if (amount >= totalAmount) {
                statusElement.textContent = 'Paid';
                statusElement.className = 'text-green-600 font-bold';
            } else if (amount > 0) {
                statusElement.textContent = 'Partial';
                statusElement.className = 'text-yellow-600 font-bold';
            } else {
                statusElement.textContent = 'Unpaid';
                statusElement.className = 'text-red-600 font-bold';
            }
        }

        // Update summary when amount changes
        document.getElementById('payment_amount').addEventListener('input', updatePaymentSummary);
        
        // Initial update
        updatePaymentSummary();
    </script>
</body>
</html>