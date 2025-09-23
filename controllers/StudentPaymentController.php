<?php
require_once 'models/Booking.php';
require_once 'models/Student.php';

class StudentPaymentController extends Controller {
    private $bookingModel;
    private $studentModel;

    public function __construct() {
        $this->bookingModel = new Booking();
        $this->studentModel = new Student();
    }

    public function index() {
        $this->requireLogin('student');
        
        $student_id = $_SESSION['student_id'];
        $bookings = $this->bookingModel->getStudentBookings($student_id);
        
        // Calculate payment summary using the new paid_amount field
        $total_amount = array_sum(array_column($bookings, 'total_amount'));
        $paid_amount = array_sum(array_column($bookings, 'paid_amount'));
        $pending_amount = $total_amount - $paid_amount;
        
        $this->view('student/payments', [
            'title' => 'My Payments - ' . APP_NAME,
            'bookings' => $bookings,
            'payment_summary' => [
                'total' => $total_amount,
                'paid' => $paid_amount,
                'pending' => $pending_amount
            ],
            'student' => $_SESSION['student_data']
        ]);
    }

    public function pay() {
        $this->requireLogin('student');
        
        $booking_id = $_GET['booking_id'] ?? 0;
        $booking = $this->bookingModel->getBookingWithRoom($booking_id);
        
        if (!$booking || $booking['student_id'] != $_SESSION['student_id']) {
            $_SESSION['error'] = 'Booking not found';
            $this->redirect('student/payments');
            return;
        }
        
        if ($booking['payment_status'] === 'paid') {
            $_SESSION['error'] = 'This booking is already paid';
            $this->redirect('student/payments');
            return;
        }
        
        $this->view('student/make-payment', [
            'title' => 'Make Payment - ' . APP_NAME,
            'booking' => $booking,
            'student' => $_SESSION['student_data']
        ]);
    }

    public function processPayment() {
        $this->requireLogin('student');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $booking_id = $_POST['booking_id'];
            $payment_amount = floatval($_POST['payment_amount']);
            $payment_method = $_POST['payment_method'];
            
            $booking = $this->bookingModel->getBookingWithRoom($booking_id);
            
            if (!$booking || $booking['student_id'] != $_SESSION['student_id']) {
                $_SESSION['error'] = 'Invalid booking';
                $this->redirect('student/payments');
                return;
            }
            
            // Calculate new paid_amount
$new_paid_amount = ($booking['paid_amount'] ?? 0) + $payment_amount;

// Determine payment status based on total paid so far
if ($new_paid_amount >= $booking['total_amount']) {
    $new_payment_status = 'paid';
    $new_paid_amount = $booking['total_amount']; // Prevent overpayment
} elseif ($new_paid_amount > 0) {
    $new_payment_status = 'partial';
} else {
    $new_payment_status = 'unpaid';
}

// Update booking payment status
if ($this->bookingModel->update($booking_id, [
    'payment_status' => $new_payment_status,
    'paid_amount' => $new_paid_amount
])) {
    $_SESSION['success'] = 'Payment of Ksh' . number_format($payment_amount) . ' processed successfully! Status: ' . ucfirst($new_payment_status);

    $this->sendPaymentConfirmation($booking, $payment_amount, $payment_method);

    $this->redirect('student/payments');
} else {
    die('Booking update failed!');
}
        } else {
            $this->redirect('student/payments');
        }
    }

    private function sendPaymentConfirmation($booking, $amount, $method) {
        // Simulate email confirmation
        // In real implementation, you would send actual email here
        $_SESSION['email_sent'] = 'Payment confirmation sent to ' . $_SESSION['student_data']['email'];
    }

    public function history() {
        $this->requireLogin('student');
        
        $student_id = $_SESSION['student_id'];
        $bookings = $this->bookingModel->getStudentBookings($student_id);
        
        // Filter only bookings with payments
        $paid_bookings = array_filter($bookings, fn($b) => in_array($b['payment_status'], ['paid', 'partial']));
        
        $this->view('student/payment-history', [
            'title' => 'Payment History - ' . APP_NAME,
            'bookings' => $paid_bookings,
            'student' => $_SESSION['student_data']
        ]);
    }
}
?>