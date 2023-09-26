<?php

namespace App\Controllers;

// session_start();

use App\Models\User;
use App\Core\View;

class Main
{
    public function index()
    {
        $pseudo = "Prof";
        $view = new View("Main/index", "front");
        $view->assign("pseudo", $pseudo);
    }

    public function contact()
    {
        $view = new View("Main/contact", "front");
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user_id'])) {
            // Send a 404 error if the user is not logged in
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role === 'guest' || $role === null) {
            // Send a 404 error if the user is a guest or role is not set
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        try {
            $users = $user->getAllUsers();
        } catch (Exception $e) {
            // Handle the error (log it, show an error message, etc.)
            die("An error occurred: " . $e->getMessage());
        }

        $activeTab = 'dashboard';
        $view = new View("Dashboard/dashboard", "back");
        $view->assign("role", $role);
        $view->assign("users", $users);
        $view->assign("activeTab", $activeTab);
    }

    public function addUser()
    {
        // Your form validation and data collection here
        $user = User::getInstance();
        $result = $user->createUser($firstname, $lastname, $email, $password, $role);
        if ($result) {
            // Redirect to dashboard or show success message
        } else {
            // Show error message
        }
    }

    public function editUser($id)
    {
        // Your form validation and data collection here
        $user = User::getInstance();
        $result = $user->updateUser($id, $firstname, $lastname, $email, $role);
        if ($result) {
            // Redirect to dashboard or show success message
        } else {
            // Show error message
        }
    }

    public function deleteUser($id)
    {
        $user = User::getInstance();
        $result = $user->deleteUser($id);
        if ($result) {
            // Redirect to dashboard or show success message
        } else {
            // Show error message
        }
    }
}
