<?php
require_once 'models/Booking.php';
require_once 'models/Room.php';

class BookingController extends Controller {
    private $bookingModel;
    private $roomModel;

    public function __construct() {
        $this->bookingModel = new Booking();
        $this->roomModel = new Room();
    }

    public function create() {
        $this->requireLogin('student');
        
        $room_id = $_GET['room_id'] ?? 0;
        $room = $this->roomModel->getRoomById($room_id);
        
        if (!$room || $room['status'] !== 'available') {
            $_SESSION['error'] = 'Room not available for booking';
            $this->redirect('student/rooms');
            return;
        }
        
        $this->view('student/book-room', [
            'title' => 'Book Room ' . $room['room_number'] . ' - ' . APP_NAME,
            'room' => $room,
            'student' => $_SESSION['student_data']
        ]);
    }

    public function store() {
        $this->requireLogin('student');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $room_id = $_POST['room_id'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $student_id = $_SESSION['student_id'];
            
            // Validate dates
            if (strtotime($start_date) < strtotime(date('Y-m-d'))) {
                $_SESSION['booking_error'] = 'Start date cannot be in the past';
                $this->redirect('student/book?room_id=' . $room_id);
                return;
            }
            
            if (strtotime($end_date) <= strtotime($start_date)) {
                $_SESSION['booking_error'] = 'End date must be after start date';
                $this->redirect('student/book?room_id=' . $room_id);
                return;
            }
            
            // Check for conflicts
            if ($this->bookingModel->hasConflict($room_id, $start_date, $end_date)) {
                $_SESSION['booking_error'] = 'Room is already booked for selected dates';
                $this->redirect('student/book?room_id=' . $room_id);
                return;
            }
            
            // Calculate total amount
            $room = $this->roomModel->getRoomById($room_id);
            $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);
            $months = ceil($days / 30); // Round up to nearest month
            $total_amount = $room['price'] * $months;
            
            // Create booking
            $booking_id = 'BK' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            
            $booking_data = [
                'booking_id' => $booking_id,
                'student_id' => $student_id,
                'room_id' => $room_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_amount' => $total_amount,
                'payment_status' => 'unpaid',
                'booking_status' => 'active'
            ];
            
            if ($this->bookingModel->create($booking_data)) {
                // Update room status to occupied
                $this->roomModel->update($room_id, ['status' => 'occupied']);
                
                $_SESSION['booking_success'] = 'Booking created successfully! Booking ID: ' . $booking_id;
                $this->redirect('student/bookings');
            } else {
                $_SESSION['booking_error'] = 'Failed to create booking. Please try again.';
                $this->redirect('student/book?room_id=' . $room_id);
            }
        } else {
            $this->redirect('student/rooms');
        }
    }

    public function index() {
        $this->requireLogin('student');
        
        $student_id = $_SESSION['student_id'];
        $bookings = $this->bookingModel->getStudentBookings($student_id);
        
        $this->view('student/bookings', [
            'title' => 'My Bookings - ' . APP_NAME,
            'bookings' => $bookings,
            'student' => $_SESSION['student_data']
        ]);
    }

    public function cancel() {
        $this->requireLogin('student');
        
        $booking_id = $_GET['id'] ?? 0;
        $booking = $this->bookingModel->find($booking_id);
        
        if (!$booking || $booking['student_id'] != $_SESSION['student_id']) {
            $_SESSION['error'] = 'Booking not found';
            $this->redirect('student/bookings');
            return;
        }
        
        if ($booking['booking_status'] === 'cancelled') {
            $_SESSION['error'] = 'Booking is already cancelled';
            $this->redirect('student/bookings');
            return;
        }
        
        // Cancel booking and free up room
        $this->bookingModel->update($booking_id, [
            'booking_status' => 'cancelled'
        ]);
        
        $this->roomModel->update($booking['room_id'], [
            'status' => 'available'
        ]);
        
        $_SESSION['success'] = 'Booking cancelled successfully';
        $this->redirect('student/bookings');
    }
}
?>