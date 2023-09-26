<?php

namespace App\Controllers;

// session_start();

use App\Models\User;
use App\Core\View;

class Users
{
    public function index()
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

        $activeTab = 'users';
        $view = new View("Dashboard/users", "back");
        $view->assign("role", $role);
        $view->assign("users", $users);
        $view->assign("activeTab", $activeTab);
    }

    public function create()
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

        $activeTab = 'users';
        $view = new View("Users/add", "back");
        $view->assign("role", $role);
        $view->assign("users", $users);
        $view->assign("activeTab", $activeTab);
    }

    public function store()
    {
        // Check if the user is logged in and has the role of 'admin'
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role !== 'admin') {
            header("Location: /dashboard");
            exit();
        }

        // Server-side validation
        if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['role'])) {
            header("Location: /dashboard/users/create?error=missing_fields");
            exit();
        }

        // Check for duplicate email
        $existingUser = $user->checkDuplicateEmail($_POST['email']);

        if ($existingUser) {
            header("Location: /dashboard/users/create?error=email_exists");
            exit();
        }

        // Set user properties and save
        $user->setFirstname($_POST['firstname']);
        $user->setLastname($_POST['lastname']);
        $user->setEmail($_POST['email']);
        $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
        $user->setStatus(true);  // true because email verification is not required
        $user->setRole($_POST['role']);

        $result = $user->save();

        if ($result) {
            header("Location: /dashboard/users?success=user_created");
        } else {
            header("Location: /dashboard/users/create?error=user_not_created");
        }
        exit();
    }


    public function edit($id)
    {
        $user = User::getInstance();
        $user->loadById($id);
        $view = new View("Dashboard/user_edit", "back");
        $view->assign("user", $user);
    }

    public function update($id)
    {
        $user = User::getInstance();
        $result = $user->updateUser($id, $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['role']);
        if ($result) {
            header("Location: /dashboard/users");
        } else {
            // Handle error
        }
    }

    public function delete($id)
    {
        $user = User::getInstance();
        $result = $user->deleteUser($id);
        if ($result) {
            header("Location: /dashboard/users");
        } else {
            // Handle error
        }
    }
}
