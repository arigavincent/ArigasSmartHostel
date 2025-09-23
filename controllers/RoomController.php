<?php
require_once 'models/Room.php';

class RoomController extends Controller {
    private $roomModel;

    public function __construct() {
        $this->roomModel = new Room();
    }

    public function index() {
        $this->requireLogin('student');
        
        // Get filter parameters
        $filters = [
            'room_type' => $_GET['room_type'] ?? '',
            'min_price' => $_GET['min_price'] ?? '',
            'max_price' => $_GET['max_price'] ?? '',
            'floor' => $_GET['floor'] ?? ''
        ];
        
        // Get filtered rooms
        if (array_filter($filters)) {
            $rooms = $this->roomModel->filterRooms($filters);
        } else {
            $rooms = $this->roomModel->getAvailableRooms();
        }
        
        $this->view('student/rooms', [
            'title' => 'Browse Rooms - ' . APP_NAME,
            'rooms' => $rooms,
            'filters' => $filters,
            'student' => $_SESSION['student_data']
        ]);
    }

    public function show() {
        $this->requireLogin('student');
        
        $room_id = $_GET['id'] ?? 0;
        $room = $this->roomModel->getRoomById($room_id);
        
        if (!$room) {
            $_SESSION['error'] = 'Room not found';
            $this->redirect('student/rooms');
            return;
        }
        
        $this->view('student/room-details', [
            'title' => 'Room ' . $room['room_number'] . ' - ' . APP_NAME,
            'room' => $room,
            'student' => $_SESSION['student_data']
        ]);
    }
}
?>