<?php
// models/User.php
require_once 'Database.php';

class User
{
    private $email;
    private $name;
    private $password;


    public function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    // Create a new user record
    public function create(): bool|int|string
    {
        $conn = Database::getInstance();
        $name = self::getName();
        $email = self::getEmail();
        $password = self::getPassword();

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed);
        $result = $stmt->execute();
        if ($result) {
            $userID = $conn->insert_id; // Retrieve the newly inserted user ID
        } else {
            $userID = false;
        }
        $stmt->close();
        return $userID;
    }

    public function verifyEmail()
    {
        $conn = Database::getInstance();
        $email = self::getEmail();

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $email = $result->fetch_assoc();
        $stmt->close();
        return $email;
    }

    // Authenticate user credentials
    public function authenticate()
    {
        $conn = Database::getInstance();
        $email = self::getEmail();
        $password = self::getPassword();

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();
        $stmt->close();
        if ($user_data && password_verify($password, $user_data['password'])) {
            return new User(
                $user_data['name'],
                $user_data['email'],
                $user_data['password']
            );
        }
        return false;
    }


    protected function getID()
    {
        $conn = Database::getInstance();
        $email = self::getEmail();

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $userID = false;
        if ($row = $result->fetch_assoc()) {
            $userID = $row['id'];
        }
        $stmt->close();
        return $userID;
    }

    public function getName(): mixed
    {
        return $this->name;
    }

    public function getEmail(): mixed
    {
        return $this->email;
    }

    public function getPassword(): mixed
    {
        return $this->password;
    }
}



?>