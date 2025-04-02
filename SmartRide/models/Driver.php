<?php
// models/Driver.php
require_once 'User.php';
require_once 'Database.php';

class Driver extends User
{
    private $driverID;

    public function createDriver(): int
    {
        $conn = Database::getInstance();
        $userID = self::getID();

        $stmt = $conn->prepare("INSERT INTO driver (user_id) VALUES (?)");
        $stmt->bind_param("i", $userID);
        $result = $stmt->execute();
        if ($result) {
            $driverID = $stmt->insert_id;
        } else {
            $driverID = false;
        }
        $stmt->close();
        return $driverID;
    }

    public function isDriver()
    {
        $conn = Database::getInstance();
        $userID = self::getID();

        $stmt = $conn->prepare("SELECT id FROM driver WHERE user_id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->store_result();
        $isDriver = ($stmt->num_rows > 0);
        $stmt->close();
        return $isDriver;
    }

    public function getDriverID(): ?int
    {
        $conn = Database::getInstance();
        $userID = self::getID();

        $stmt = $conn->prepare("SELECT id FROM driver WHERE user_id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row ? (int) $row['id'] : null;
    }


    public function authenticateDriver(): Driver|null
    {
        $user = self::authenticate();
        if ($user && self::isDriver()) {
            $driverID = self::getDriverID();
            if ($driverID !== null) {
                return new Driver(
                    $user->getName(),
                    $user->getEmail(),
                    $user->getPassword()
                );  
            }
        }
        return null;
    }

}
?>