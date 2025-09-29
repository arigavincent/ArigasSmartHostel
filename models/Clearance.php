<?php
class Clearance extends Model {
    protected $table = 'clearance_requests';
    
    public function getStudentClearances($student_id) {
        $query = "SELECT c.*, b.booking_id, r.room_number, r.room_type,
                         s.name as student_name, s.student_id as student_number,
                         a.username as admin_username
                  FROM " . $this->table . " c
                  JOIN bookings b ON c.booking_id = b.id
                  JOIN rooms r ON b.room_id = r.id
                  JOIN students s ON c.student_id = s.id
                  LEFT JOIN admins a ON c.admin_id = a.id
                  WHERE c.student_id = ?
                  ORDER BY c.request_date DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllClearanceRequests() {
        $query = "SELECT c.*, b.booking_id, b.start_date, b.end_date,
                         r.room_number, r.room_type,
                         s.name as student_name, s.student_id as student_number,
                         s.email as student_email,
                         a.username as admin_username
                  FROM " . $this->table . " c
                  JOIN bookings b ON c.booking_id = b.id
                  JOIN rooms r ON b.room_id = r.id
                  JOIN students s ON c.student_id = s.id
                  LEFT JOIN admins a ON c.admin_id = a.id
                  ORDER BY 
                    CASE c.status 
                        WHEN 'pending' THEN 1 
                        WHEN 'approved' THEN 2 
                        WHEN 'rejected' THEN 3 
                    END,
                    c.request_date DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getClearanceByBookingId($booking_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE booking_id = ? ORDER BY request_date DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$booking_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function hasPendingClearance($booking_id) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE booking_id = ? AND status = 'pending'";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$booking_id]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function getClearanceDetails($clearance_id) {
        $query = "SELECT c.*, b.booking_id, b.start_date, b.end_date, b.total_amount, b.paid_amount,
                         r.room_number, r.room_type, r.price,
                         s.name as student_name, s.student_id as student_number,
                         s.email as student_email, s.phone as student_phone,
                         a.username as admin_username
                  FROM " . $this->table . " c
                  JOIN bookings b ON c.booking_id = b.id
                  JOIN rooms r ON b.room_id = r.id
                  JOIN students s ON c.student_id = s.id
                  LEFT JOIN admins a ON c.admin_id = a.id
                  WHERE c.id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$clearance_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Create a new clearance request
    public function createRequest($student_id, $booking_id) {
        $query = "INSERT INTO " . $this->table . " (student_id, booking_id, status, request_date) VALUES (?, ?, 'pending', NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$student_id, $booking_id]);
    }

    // Check if student has a pending request (by booking)
    public function hasPendingRequest($student_id) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE student_id = ? AND status = 'pending'";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$student_id]);
        return $stmt->fetchColumn() > 0;
    }

    // Approve a clearance request
    public function approveRequest($clearance_id, $admin_id) {
        $query = "UPDATE " . $this->table . " SET status = 'approved', admin_id = ?, approval_date = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$admin_id, $clearance_id]);
    }

    // Reject a clearance request
    public function rejectRequest($clearance_id, $admin_id, $reason = null) {
        $query = "UPDATE " . $this->table . " SET status = 'rejected', admin_id = ?, rejection_reason = ?, approval_date = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$admin_id, $reason, $clearance_id]);
    }
}
?>