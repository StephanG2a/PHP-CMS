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
        $newUser = new User();
        $newUser->setId(0);  // Explicitly set ID to zero
        $newUser->setFirstname($_POST['firstname']);
        $newUser->setLastname($_POST['lastname']);
        $newUser->setEmail($_POST['email']);
        $newUser->setPassword($_POST['password']);  // This should hash the password
        $newUser->setStatus(true);
        $newUser->setRole($_POST['role']);

        $result = $newUser->save();

        if ($result) {
            header("Location: /dashboard/users?success=user_created");
        } else {
            header("Location: /dashboard/users/create?error=user_not_created");
        }
        exit();
    }


    public function edit($params)
    {
        $id = $params['id'];
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

        $userToUpdate = new User();
        $userToUpdate->loadById($id);

        $activeTab = 'users';
        $view = new View("Users/update", "back");
        $view->assign("role", $role);
        $view->assign("users", $users);
        $view->assign("activeTab", $activeTab);
        $view->assign("user", $userToUpdate);
    }

    public function update($params)
    {
        $id = $params['id'];
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
        if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['role'])) {
            header("Location: /dashboard/users/edit/$id?error=missing_fields");
            exit();
        }

        // Load the user to be updated
        $userToUpdate = new User();
        $userToUpdate->loadById($id);

        // Set new properties
        $userToUpdate->setFirstname($_POST['firstname']);
        $userToUpdate->setLastname($_POST['lastname']);
        $userToUpdate->setEmail($_POST['email']);
        $userToUpdate->setRole($_POST['role']);

        // Perform the update
        $result = $userToUpdate->save();

        if ($result) {
            header("Location: /dashboard/users?success=user_updated");
        } else {
            header("Location: /dashboard/users/edit/$id?error=user_not_updated");
        }
        exit();
    }


    public function delete($params)
    {
        $id = $params['id'];
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

        // Perform the deletion
        $userToDelete = new User();
        $userToDelete->loadById($id);
        $result = $userToDelete->delete();

        if ($result) {
            header("Location: /dashboard/users?success=user_deleted");
        } else {
            header("Location: /dashboard/users?error=user_not_deleted");
        }
        exit();
    }
}
