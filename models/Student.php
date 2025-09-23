<?php
class Student extends Model {
    protected $table = 'students';
    
    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = ? LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function findByStudentId($student_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE student_id = ? LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $student_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAllStudentsWithBookings() {
        $query = "SELECT s.*, 
                         COUNT(b.id) as total_bookings,
                         COUNT(CASE WHEN b.booking_status = 'active' THEN 1 END) as active_bookings,
                         COUNT(CASE WHEN b.payment_status = 'unpaid' THEN 1 END) as unpaid_bookings
                  FROM " . $this->table . " s
                  LEFT JOIN bookings b ON s.id = b.student_id
                  GROUP BY s.id
                  ORDER BY s.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>