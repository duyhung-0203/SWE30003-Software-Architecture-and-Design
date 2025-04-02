<?php
// models/Admin.php
require_once 'User.php';
require_once 'Database.php';

class Admin extends User {
    // Example: Retrieve all users
    public static function getAllUsers() {
        $conn = Database::getInstance();
        $result = $conn->query("SELECT * FROM users");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = new User(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['password'],
                $row['role'],
                $row['has_license']
            );
        }
        return $users;
    }
}
?>
