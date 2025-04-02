<?php
// models/RideRequest.php
require_once 'Database.php';

class RideRequest
{
    private Passenger $passenger;
    private $location_id;
    private $fare;
    private $status;


    public function __construct($passenger, $location_id, $fare, $status)
    {
        $this->passenger = $passenger;
        $this->location_id = $location_id;
        $this->fare = $fare;
        $this->status = $status;
    }

    // Create a new ride request
    public function createRideRequest(): int|string
    {
        $conn = Database::getInstance();
        $passenger_id = self::getPassenger()->getPassengerID();
        $location_id = self::getLocationID();
        $fare = self::getFare();
        $status = self::getStatus();

        $stmt = $conn->prepare("INSERT INTO ride_requests (passenger_id, location_id, fare, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iids", $passenger_id, $location_id, $fare, $status);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }

    public static function checkRideStatus($id)
    {
        $conn = Database::getInstance();
        $stmt = $conn->prepare("SELECT status FROM ride_requests WHERE id = ?");

        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }

        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            $stmt->close();
            throw new Exception("Query execution failed: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $status = $result->fetch_assoc();
        $stmt->close();

        return $status !== null ? $status['status'] : null;
    }


    public function getPassenger()
    {
        return $this->passenger;
    }
    public function getLocationID()
    {
        return $this->location_id;
    }

    public function getFare()
    {
        return $this->fare;
    }

    public function getStatus()
    {
        return $this->status;
    }

}
?>