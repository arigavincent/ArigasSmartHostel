<?php
class Booking extends Model {
    protected $table = 'bookings';
    
    public function hasConflict($room_id, $start_date, $end_date) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " 
                  WHERE room_id = ? 
                  AND booking_status = 'active'
                  AND (
                      (start_date <= ? AND end_date >= ?) OR
                      (start_date <= ? AND end_date >= ?) OR
                      (start_date >= ? AND end_date <= ?)
                  )";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$room_id, $start_date, $start_date, $end_date, $end_date, $start_date, $end_date]);
        
        return $stmt->fetchColumn() > 0;
    }
    
    public function getStudentBookings($student_id) {
        $query = "SELECT b.*, r.room_number, r.room_type, r.price 
                  FROM " . $this->table . " b
                  JOIN rooms r ON b.room_id = r.id
                  WHERE b.student_id = ?
                  ORDER BY b.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllBookings() {
        $query = "SELECT b.*, r.room_number, r.room_type, s.name as student_name, s.student_id as student_number
                  FROM " . $this->table . " b
                  JOIN rooms r ON b.room_id = r.id
                  JOIN students s ON b.student_id = s.id
                  ORDER BY b.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function hasActiveBookings($room_id) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " 
                  WHERE room_id = ? AND booking_status = 'active'";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$room_id]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function getBookingWithRoom($booking_id) {
        $query = "SELECT b.*, r.room_number, r.room_type, r.price as room_price
                  FROM " . $this->table . " b
                  JOIN rooms r ON b.room_id = r.id
                  WHERE b.id = ? LIMIT 1";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$booking_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function update($booking_id, $data) {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        $values[] = $booking_id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }
}