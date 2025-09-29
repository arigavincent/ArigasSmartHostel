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
    
    public function getFinancialStats() {
        // Total revenue (sum of paid bookings)
        $queryRevenue = "SELECT SUM(total_amount) as total_revenue, AVG(total_amount) as average_booking_value FROM bookings WHERE payment_status = 'paid'";
        $stmtRevenue = $this->db->prepare($queryRevenue);
        $stmtRevenue->execute();
        $revenueRow = $stmtRevenue->fetch(PDO::FETCH_ASSOC);

        // Pending revenue (sum of unpaid bookings)
        $queryPending = "SELECT SUM(total_amount) as pending_revenue FROM bookings WHERE payment_status = 'pending'";
        $stmtPending = $this->db->prepare($queryPending);
        $stmtPending->execute();
        $pendingRow = $stmtPending->fetch(PDO::FETCH_ASSOC);

        return [
            'total_revenue' => (int)($revenueRow['total_revenue'] ?? 0),
            'average_booking_value' => (int)($revenueRow['average_booking_value'] ?? 0),
            'pending_revenue' => (int)($pendingRow['pending_revenue'] ?? 0)
        ];
    }
    
    public function getBookingStats() {
        // Total bookings
        $queryTotal = "SELECT COUNT(*) as total FROM bookings";
        $stmtTotal = $this->db->prepare($queryTotal);
        $stmtTotal->execute();
        $totalRow = $stmtTotal->fetch(PDO::FETCH_ASSOC);

        // Active bookings
        $queryActive = "SELECT COUNT(*) as active FROM bookings WHERE booking_status = 'active'";
        $stmtActive = $this->db->prepare($queryActive);
        $stmtActive->execute();
        $activeRow = $stmtActive->fetch(PDO::FETCH_ASSOC);

        // Cancelled bookings
        $queryCancelled = "SELECT COUNT(*) as cancelled FROM bookings WHERE booking_status = 'cancelled'";
        $stmtCancelled = $this->db->prepare($queryCancelled);
        $stmtCancelled->execute();
        $cancelledRow = $stmtCancelled->fetch(PDO::FETCH_ASSOC);

        // Cancellation rate
        $cancellation_rate = ($totalRow['total'] > 0) ? round(($cancelledRow['cancelled'] / $totalRow['total']) * 100, 1) : 0;

        return [
            'total' => (int)($totalRow['total'] ?? 0),
            'active' => (int)($activeRow['active'] ?? 0),
            'cancelled' => (int)($cancelledRow['cancelled'] ?? 0),
            'cancellation_rate' => $cancellation_rate
        ];
    }
    
    public function getMonthlyBookings() {
        // Group bookings by month and year
        $query = "
            SELECT 
                DATE_FORMAT(start_date, '%Y-%m') AS month,
                COUNT(*) AS bookings
            FROM bookings
            GROUP BY month
            ORDER BY month ASC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getDetailedBookings() {
        $query = "
            SELECT 
                b.booking_id AS id,
                s.name AS student_name,
                r.room_number,
                r.room_type,
                b.start_date AS check_in,
                b.end_date AS check_out,
                b.total_amount AS amount,
                b.booking_status AS status,
                b.payment_status
            FROM bookings b
            LEFT JOIN students s ON b.student_id = s.id
            LEFT JOIN rooms r ON b.room_id = r.id
            ORDER BY b.created_at DESC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}