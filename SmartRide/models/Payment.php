<?php
// models/Payment.php
require_once 'Database.php';

class Payment {
    public $id;
    public $ride_id;
    public $passenger_id;
    public $status;
    
    public function __construct($id, $ride_id, $passenger_id, $status) {
        $this->id = $id;
        $this->ride_id = $ride_id;
        $this->passenger_id = $passenger_id;
        $this->status = $status;
    }
    
    // Create a payment record (simulate payment)
    public static function createPayment($ride_id, $passenger_id) {
        $conn = Database::getInstance();
        // We simulate a payment by marking it as 'paid'
        $status = 'paid';
        $stmt = $conn->prepare("INSERT INTO payments (ride_id, passenger_id, status) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $ride_id, $passenger_id, $status);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }
}
?>
