<?php
class Room extends Model {
    protected $table = 'rooms';
    
    public function getAvailableRooms() {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'available' ORDER BY room_number";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function filterRooms($filters = []) {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'available'";
        $params = [];
        
        if (!empty($filters['room_type'])) {
            $query .= " AND room_type = ?";
            $params[] = $filters['room_type'];
        }
        
        if (!empty($filters['min_price'])) {
            $query .= " AND price >= ?";
            $params[] = $filters['min_price'];
        }
        
        if (!empty($filters['max_price'])) {
            $query .= " AND price <= ?";
            $params[] = $filters['max_price'];
        }
        
        if (!empty($filters['floor'])) {
            $query .= " AND floor = ?";
            $params[] = $filters['floor'];
        }
        
        $query .= " ORDER BY room_number";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRoomById($id) {
        return $this->find($id);
    }
    
    public function findByRoomNumber($room_number) {
        $query = "SELECT * FROM " . $this->table . " WHERE room_number = ? LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$room_number]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getRoomStats() {
        $rooms = $this->findAll();
        $total = count($rooms);
        $available = count($this->getAvailableRooms());
        $occupied = $total - $available;
        $occupancy_rate = $total > 0 ? round(($occupied / $total) * 100, 1) : 0;

        return [
            'total' => $total,
            'available' => $available,
            'occupied' => $occupied,
            'occupancy_rate' => $occupancy_rate
        ];
    }
    
    public function getRoomTypeDistribution() {
        $query = "
            SELECT room_type, COUNT(*) AS count
            FROM rooms
            GROUP BY room_type
            ORDER BY room_type ASC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>