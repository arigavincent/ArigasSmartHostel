<?php
require_once 'models/Clearance.php';
require_once 'models/Booking.php';
require_once 'models/Student.php';

class StudentClearanceController extends Controller {
    private $clearanceModel;
    private $bookingModel;
    private $studentModel;

    public function __construct() {
        $this->clearanceModel = new Clearance();
        $this->bookingModel = new Booking();
        $this->studentModel = new Student();
    }

    // STEP 1: List all clearance requests for the logged-in student
    public function index() {
        $student_id = $_SESSION['student_id'];
        $requests = $this->clearanceModel->getStudentClearances($student_id);
        $this->view('student/clearance', ['requests' => $requests]);
    }

    // STEP 2: Show clearance request form (if eligible)
    public function requestForm() {
        $student_id = $_SESSION['student_id'];
        $activeBooking = $this->bookingModel->getActiveBookingByStudent($student_id);
        $eligible = $activeBooking && $activeBooking['payment_status'] === 'paid';
        $this->view('student/request-clearance', [
            'booking' => $activeBooking,
            'eligible' => $eligible
        ]);
    }

    // STEP 3: Submit clearance request
    public function submitRequest() {
        $student_id = $_SESSION['student_id'];
        $booking = $this->bookingModel->getActiveBookingByStudent($student_id);

        // Business rule: Only allow if paid and no pending request
        if (!$booking || $booking['payment_status'] !== 'paid') {
            $msg = "You must settle all payments before requesting clearance.";
            header("Location: index.php?url=student/clearance&msg=" . urlencode($msg));
            exit;
        }
        if ($this->clearanceModel->hasPendingRequest($student_id)) {
            $msg = "You already have a pending clearance request.";
            header("Location: index.php?url=student/clearance&msg=" . urlencode($msg));
            exit;
        }

        // Create clearance request
        $this->clearanceModel->createRequest($student_id, $booking['id']);
        $msg = "Clearance request submitted!";
        header("Location: index.php?url=student/clearance&msg=" . urlencode($msg));
        exit;
    }

    // STEP 4: View clearance certificate (if approved)
    public function viewClearance($request_id) {
        $student_id = $_SESSION['student_id'];
        $clearance = $this->clearanceModel->getRequestById($request_id);

        // Security: Only allow if this student's request
        if (!$clearance || $clearance['student_id'] != $student_id) {
            header("Location: index.php?url=student/clearance&msg=Access denied");
            exit;
        }

        $this->view('student/clearance-certificate', ['clearance' => $clearance]);
    }
}
?>