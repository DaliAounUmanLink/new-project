<?php

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function getAllUsers() {
        $sql = "SELECT * FROM users"; // Your query to select all users
        $stmt = $this->db->prepare($sql); // Prepare the statement
        $stmt->execute(); // Execute the statement
        var_dump($stmt);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all users as an associative array
    }
    // Create a new user
    public function createUser($email, $hashedPassword, $username = null) {
        // Prepare the SQL statement
        $stmt = $this->db->prepare("INSERT INTO users (email, password, username, role) VALUES (?, ?, ?, 'user')");
        
        // Execute the statement with the provided values
        return $stmt->execute([$email, $hashedPassword, $username]);
    }

    // Retrieve a user by email
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the user as an associative array
    }
    // Method to fetch all users

}
