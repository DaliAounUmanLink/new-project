<?php

// Include necessary files
require_once '../../config/Database.php';
require_once '../models/User.php'; // Adjust this path to your User model

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    // Manage Users: Fetch all users and display them
    public function manageUsers() {
        $users = $this->userModel->getAllUsers(); // Fetch all users
        include '../views/admin/manage_users.php'; // Include the view to display users
    }

    // Register a new user
    public function register($username, $password, $email) {
        // Check if the email already exists
        if ($this->userModel->getUserByEmail($email)) {
            echo "Email already exists. Please choose a different one.";
            return;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Create the user
        if ($this->userModel->createUser($email, $hashedPassword, $username)) {
            echo "Registration successful! You can now log in.";
        } else {
            echo "Failed to register user. Please try again.";
        }
    }

    // Log in an existing user
    public function login() {
        session_start(); // Start the session
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect and sanitize form inputs
            $email = htmlspecialchars(trim($_POST['email']));
            $password = htmlspecialchars(trim($_POST['password']));

            // Retrieve the user by email
            $user = $this->userModel->getUserByEmail($email);

            // Check if the user was found
            if (!$user) {
                echo "No user found with that email.";
                return; // Early return if no user was found
            }

            // Check if the password matches
            if (password_verify($password, $user['password'])) {
                // Login successful
                echo "Login successful!";
                // Set session variables for the user
                $_SESSION['user_id'] = $user['id']; // Assuming you have an ID field
                $_SESSION['username'] = $user['username']; // Save username
                $_SESSION['role'] = $user['role']; // Save role

                // Redirect to a different page (e.g., dashboard)
                header("Location: /dashboard.php");
                exit();
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "Invalid request method.";
        }
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a database connection
    $database = new Database();
    $db = $database->getConnection();
    // Create an instance of UserController
    $userController = new UserController($db);

    // Check for registration
    if (isset($_GET['action']) && $_GET['action'] === 'register') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $userController->register($username, $password, $email);
    }

    // Check for login
    if (isset($_GET['action']) && $_GET['action'] === 'login') {
        $userController->login();
    }
} else {
    // Handle requests to manage users
    $database = new Database();
    $db = $database->getConnection();
    $userController = new UserController($db);
    $userController->manageUsers(); // Call the manageUsers method to fetch and display users
}
