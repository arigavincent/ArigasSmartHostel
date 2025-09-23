<?php
require_once 'models/Room.php';
require_once 'models/Booking.php';

class AdminRoomController extends Controller {
    private $roomModel;
    private $bookingModel;

    public function __construct() {
        $this->roomModel = new Room();
        $this->bookingModel = new Booking();
    }

    public function index() {
        $this->requireLogin('admin');
        
        $rooms = $this->roomModel->findAll();
        
        $this->view('admin/rooms', [
            'title' => 'Manage Rooms - ' . APP_NAME,
            'rooms' => $rooms,
            'admin' => $_SESSION['admin_data']
        ]);
    }

    public function create() {
        $this->requireLogin('admin');
        
        $this->view('admin/add-room', [
            'title' => 'Add New Room - ' . APP_NAME,
            'admin' => $_SESSION['admin_data']
        ]);
    }

    public function store() {
        $this->requireLogin('admin');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'room_number' => trim($_POST['room_number']),
                'room_type' => $_POST['room_type'],
                'capacity' => intval($_POST['capacity']),
                'price' => floatval($_POST['price']),
                'floor' => intval($_POST['floor']),
                'description' => trim($_POST['description']),
                'status' => $_POST['status'] ?? 'available'
            ];
            
            // Check if room number already exists
            $existing = $this->roomModel->findByRoomNumber($data['room_number']);
            if ($existing) {
                $_SESSION['error'] = 'Room number already exists';
                $this->redirect('admin/rooms/create');
                return;
            }
            
            if ($this->roomModel->create($data)) {
                $_SESSION['success'] = 'Room added successfully';
                $this->redirect('admin/rooms');
            } else {
                $_SESSION['error'] = 'Failed to add room';
                $this->redirect('admin/rooms/create');
            }
        } else {
            $this->redirect('admin/rooms');
        }
    }

    public function edit() {
        $this->requireLogin('admin');
        
        $room_id = $_GET['id'] ?? 0;
        $room = $this->roomModel->find($room_id);
        
        if (!$room) {
            $_SESSION['error'] = 'Room not found';
            $this->redirect('admin/rooms');
            return;
        }
        
        $this->view('admin/edit-room', [
            'title' => 'Edit Room ' . $room['room_number'] . ' - ' . APP_NAME,
            'room' => $room,
            'admin' => $_SESSION['admin_data']
        ]);
    }

    public function update() {
        $this->requireLogin('admin');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $room_id = $_POST['room_id'];
            $data = [
                'room_number' => trim($_POST['room_number']),
                'room_type' => $_POST['room_type'],
                'capacity' => intval($_POST['capacity']),
                'price' => floatval($_POST['price']),
                'floor' => intval($_POST['floor']),
                'description' => trim($_POST['description']),
                'status' => $_POST['status']
            ];
            
            if ($this->roomModel->update($room_id, $data)) {
                $_SESSION['success'] = 'Room updated successfully';
                $this->redirect('admin/rooms');
            } else {
                $_SESSION['error'] = 'Failed to update room';
                $this->redirect('admin/rooms/edit&id=' . $room_id);
            }
        } else {
            $this->redirect('admin/rooms');
        }
    }

    public function delete() {
        $this->requireLogin('admin');
        
        $room_id = $_GET['id'] ?? 0;
        $room = $this->roomModel->find($room_id);
        
        if (!$room) {
            $_SESSION['error'] = 'Room not found';
            $this->redirect('admin/rooms');
            return;
        }
        
        // Check if room has active bookings
        $active_bookings = $this->bookingModel->hasActiveBookings($room_id);
        if ($active_bookings) {
            $_SESSION['error'] = 'Cannot delete room with active bookings';
            $this->redirect('admin/rooms');
            return;
        }
        
        if ($this->roomModel->delete($room_id)) {
            $_SESSION['success'] = 'Room deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete room';
        }
        
        $this->redirect('admin/rooms');
    }

    public function bookings() {
        $this->requireLogin('admin');
        
        $bookings = $this->bookingModel->getAllBookings();
        
        $this->view('admin/bookings', [
            'title' => 'All Bookings - ' . APP_NAME,
            'bookings' => $bookings,
            'admin' => $_SESSION['admin_data']
        ]);
    }

    public function updatePayment() {
        $this->requireLogin('admin');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $booking_id = $_POST['booking_id'];
            $payment_status = $_POST['payment_status'];

            // Get current paid and total amount
            $booking = $this->bookingModel->getBookingWithRoom($booking_id);
            if ($booking['paid_amount'] >= $booking['total_amount']) {
                $payment_status = 'paid';
            }

            if ($this->bookingModel->update($booking_id, ['payment_status' => $payment_status])) {
                $_SESSION['success'] = 'Payment status updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update payment status';
            }
        }
        
        $this->redirect('admin/bookings');
    }
}
?>