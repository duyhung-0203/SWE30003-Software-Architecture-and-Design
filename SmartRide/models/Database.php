<?php

class Database {
    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new mysqli("localhost", "root", "", "smartride");
            if (self::$instance->connect_error) {
                die("Connection failed: " . self::$instance->connect_error);
            }
        }
        return self::$instance;
    }
}
?>
