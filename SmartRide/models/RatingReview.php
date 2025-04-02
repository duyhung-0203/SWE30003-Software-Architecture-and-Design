<?php
// models/RatingReview.php
require_once 'Database.php';

class RatingReview {
    public $id;
    public $ride_id;
    public $passenger_id;
    public $driver_id;
    public $rating;
    public $comment;
    
    public function __construct($id, $ride_id, $passenger_id, $driver_id, $rating, $comment) {
        $this->id = $id;
        $this->ride_id = $ride_id;
        $this->passenger_id = $passenger_id;
        $this->driver_id = $driver_id;
        $this->rating = $rating;
        $this->comment = $comment;
    }
    
    // Create a new rating/review record
    public static function create($ride_id, $passenger_id, $driver_id, $rating, $comment) {
        $conn = Database::getInstance();
        $stmt = $conn->prepare("INSERT INTO ratings (ride_id, passenger_id, driver_id, rating, comment) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiids", $ride_id, $passenger_id, $driver_id, $rating, $comment);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }
}
?>
