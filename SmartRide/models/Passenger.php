    <?php
    // models/Passenger.php
    require_once 'User.php';
    require_once 'Database.php';

    class Passenger extends User
    {
        private $passengerID;

        public function createPassenger(): int
        {
            $conn = Database::getInstance();
            $userID = self::getID();

            $stmt = $conn->prepare("INSERT INTO passenger (user_id) VALUES (?)");
            $stmt->bind_param("i", $userID);
            $result = $stmt->execute();
            if ($result) {
                $passengerID = $stmt->insert_id;
            } else {
                $passengerID = false;
            }
            $stmt->close();
            return $passengerID;
        }

        public function isPassenger()
        {
            $conn = Database::getInstance();
            $userID = self::getID();

            $stmt = $conn->prepare("SELECT id FROM passenger WHERE user_id = ?");
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $stmt->store_result();
            $isPassenger = ($stmt->num_rows > 0);
            $stmt->close();
            return $isPassenger;
        }

        public function getPassengerID(): ?int
        {
            $conn = Database::getInstance();
            $userID = self::getID();

            $stmt = $conn->prepare("SELECT id FROM passenger WHERE user_id = ?");
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row ? (int) $row['id'] : null;
        }

        public function authenticatePassenger(): Passenger|null
        {
            $user = self::authenticate();
            if ($user && self::isPassenger()) {
                $passengerID = self::getPassengerID();
                if ($passengerID !== null) {
                    return new Passenger(
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