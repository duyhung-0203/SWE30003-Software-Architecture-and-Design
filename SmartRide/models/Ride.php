<?php
// models/Ride.php
require_once __DIR__ . '/Database.php';

class Ride
{
    private $driverID;
    private $rideID;
    private $status;

    public function __construct($driverID, $rideID, $status)
    {
        $this->driverID = $driverID;
        $this->rideID = $rideID;
        $this->status = $status;
    }

    public static function getPendingRides(): array
    {
        $conn = Database::getInstance();
        $query = "
            SELECT 
                rr.id AS ride_id,
                u.name AS passenger_name,
                l.pickup_address,
                l.dropoff_address,
                l.distance,
                rr.fare
            FROM ride_requests rr
            JOIN location l ON rr.location_id = l.id
            JOIN passenger p ON rr.passenger_id = p.id
            JOIN users u ON p.user_id = u.id
            WHERE rr.status = 'pending' 
            AND rr.driver_id IS NULL
        ";

        $result = $conn->query($query);
        $rides = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rides[] = $row;
            }
        }
        return $rides;
    }


    public function startRide(): bool
    {
        $conn = Database::getInstance();
        $ride_id = self::getRideID();
        $driver_id = self::getDriverID();
        $status = self::getStatus();

        $stmt = $conn->prepare("UPDATE ride_requests SET status = ?, driver_id = ? WHERE id = ? AND status = 'pending'");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sii", $status, $driver_id, $ride_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function completeRide(): bool
    {
        $conn = Database::getInstance();
        $ride_id = self::getRideID();
        $status = self::getStatus();

        $stmt = $conn->prepare(("UPDATE ride_requests SET status = ? WHERE id = ? AND status = 'in_progress'"));
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("si", $status, $ride_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getDriverID(): mixed
    {
        return $this->driverID;
    }

    public function getRideID(): mixed
    {
        return $this->rideID;
    }

    public function getStatus(): mixed
    {
        return $this->status;
    }
}

?>