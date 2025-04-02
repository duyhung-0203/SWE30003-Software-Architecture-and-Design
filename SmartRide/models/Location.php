<?php
// models/Location.php
require_once __DIR__ . '/Database.php';

class Location
{
    private $pickup_address;
    private $dropoff_address;
    private $distance;
    private $pickup_lat;
    private $pickup_long;
    private $dropoff_lat;
    private $dropoff_long;

    public function __construct($pickup_address, $dropoff_address, $distance, $pickup_lat, $pickup_long, $dropoff_lat, $dropoff_long)
    {
        $this->pickup_address = $pickup_address;
        $this->dropoff_address = $dropoff_address;
        $this->distance = $distance;
        $this->pickup_lat = $pickup_lat;
        $this->pickup_long = $pickup_long;
        $this->dropoff_lat = $dropoff_lat;
        $this->dropoff_long = $dropoff_long;
    }

    public function createLocation(): int|string
    {
        $conn = Database::getInstance();
        $pickup_location = self::getPickupAddress();
        $dropoff_location = self::getDropoffAddress();
        $distance = self::getDistance();
        $startLat = self::getPickupLat();
        $startLon = self::getPickupLong();
        $endLat = self::getDropoffLat();
        $endLon = self::getDropoffLong();


        // Round coordinates to 6 decimal places
        $pickup_lat = round($startLat, 6);
        $pickup_long = round($startLon, 6);
        $dropoff_lat = round($endLat, 6);
        $dropoff_lon = round($endLon, 6);

        // Check if the location already exists
        $stmt = $conn->prepare("SELECT * FROM `location` WHERE pickup_lat = ? AND pickup_long = ? AND dropoff_lat = ? AND dropoff_long = ?");
        $stmt->bind_param("dddd", $pickup_lat, $pickup_long, $dropoff_lat, $dropoff_lon);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // No matching record found: insert new location
            $stmt->close(); // close previous statement
            $stmt = $conn->prepare("INSERT INTO `location` (pickup_address, dropoff_address, distance, pickup_lat, pickup_long, dropoff_lat, dropoff_long) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("ssddddd", $pickup_location, $dropoff_location, $distance, $pickup_lat, $pickup_long, $dropoff_lat, $dropoff_lon);
            $stmt->execute();
            $id = $stmt->insert_id;
            $stmt->close();
            return $id;
        } else {
            // A matching record exists
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['id'];
        }
    }

    public function getPickupAddress()
    {
        return $this->pickup_address;
    }
    public function getDropoffAddress()
    {
        return $this->dropoff_address;
    }

    public function getDistance() {
        return $this->distance;
    }
    public function getPickupLat()
    {
        return $this->pickup_lat;
    }
    public function getPickupLong()
    {
        return $this->pickup_long;
    }
    public function getDropoffLat()
    {
        return $this->dropoff_lat;
    }
    public function getDropoffLong()
    {
        return $this->dropoff_long;
    }
}
?>