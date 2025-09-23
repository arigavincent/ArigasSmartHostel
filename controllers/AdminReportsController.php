<?php
require_once 'models/Room.php';
require_once 'models/Student.php';
require_once 'models/Booking.php';

class AdminReportsController extends Controller {
    private $roomModel;
    private $studentModel;
    private $bookingModel;

    public function __construct() {
        $this->roomModel = new Room();
        $this->studentModel = new Student();
        $this->bookingModel = new Booking();
    }

    public function index() {
        $this->requireLogin('admin');
        
        // Get report data
        $reports = $this->generateReports();
        
        $this->view('admin/reports', [
            'title' => 'Reports & Analytics - ' . APP_NAME,
            'reports' => $reports,
            'admin' => $_SESSION['admin_data']
        ]);
    }

    private function generateReports() {
        // Room statistics
        $total_rooms = count($this->roomModel->findAll());
        $available_rooms = count($this->roomModel->getAvailableRooms());
        $occupancy_rate = $total_rooms > 0 ? (($total_rooms - $available_rooms) / $total_rooms) * 100 : 0;

        // Student statistics
        $total_students = count($this->studentModel->findAll());
        $students_with_bookings = count($this->studentModel->getAllStudentsWithBookings());

        // Booking statistics
        $all_bookings = $this->bookingModel->getAllBookings();
        $total_bookings = count($all_bookings);
        $active_bookings = count(array_filter($all_bookings, fn($b) => $b['booking_status'] === 'active'));
        $cancelled_bookings = count(array_filter($all_bookings, fn($b) => $b['booking_status'] === 'cancelled'));

        // Financial statistics
        $total_revenue = array_sum(array_column(array_filter($all_bookings, fn($b) => $b['payment_status'] === 'paid'), 'total_amount'));
        $pending_revenue = array_sum(array_column(array_filter($all_bookings, fn($b) => $b['payment_status'] === 'unpaid'), 'total_amount'));

        // Monthly bookings (last 6 months)
        $monthly_bookings = $this->getMonthlyBookings();
        
        // Room type distribution
        $room_types = $this->getRoomTypeDistribution();

        return [
            'room_stats' => [
                'total' => $total_rooms,
                'available' => $available_rooms,
                'occupied' => $total_rooms - $available_rooms,
                'occupancy_rate' => round($occupancy_rate, 1)
            ],
            'student_stats' => [
                'total' => $total_students,
                'with_bookings' => $students_with_bookings,
                'without_bookings' => $total_students - $students_with_bookings
            ],
            'booking_stats' => [
                'total' => $total_bookings,
                'active' => $active_bookings,
                'cancelled' => $cancelled_bookings,
                'cancellation_rate' => $total_bookings > 0 ? round(($cancelled_bookings / $total_bookings) * 100, 1) : 0
            ],
            'financial_stats' => [
                'total_revenue' => $total_revenue,
                'pending_revenue' => $pending_revenue,
                'average_booking_value' => $total_bookings > 0 ? round($total_revenue / $total_bookings, 2) : 0
            ],
            'monthly_bookings' => $monthly_bookings,
            'room_types' => $room_types
        ];
    }

    private function getMonthlyBookings() {
        // Simple approach - get basic monthly data from existing bookings
        $all_bookings = $this->bookingModel->getAllBookings();
        $monthly_data = [];
        
        foreach ($all_bookings as $booking) {
            $month = date('Y-m', strtotime($booking['created_at']));
            if (!isset($monthly_data[$month])) {
                $monthly_data[$month] = ['month' => $month, 'bookings' => 0, 'revenue' => 0];
            }
            $monthly_data[$month]['bookings']++;
            if ($booking['payment_status'] === 'paid') {
                $monthly_data[$month]['revenue'] += $booking['total_amount'];
            }
        }
        
        // Sort by month and return last 6 months
        ksort($monthly_data);
        return array_slice($monthly_data, -6, 6, true);
    }

    private function getRoomTypeDistribution() {
        $all_rooms = $this->roomModel->findAll();
        $distribution = [];
        
        foreach ($all_rooms as $room) {
            $type = $room['room_type'];
            if (!isset($distribution[$type])) {
                $distribution[$type] = ['room_type' => $type, 'count' => 0];
            }
            $distribution[$type]['count']++;
        }
        
        return array_values($distribution);
    }
}
?>