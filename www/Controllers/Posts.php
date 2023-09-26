<?php

namespace App\Controllers;

// session_start();

use App\Models\User;
use App\Core\View;

class Posts
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role === 'guest' || $role === null) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $activeTab = 'posts';
        $view = new View("Dashboard/posts", "back");
        $view->assign("role", $role);
        $view->assign("activeTab", $activeTab);
    }
}
