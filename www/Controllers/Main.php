<?php

namespace App\Controllers;

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
        // echo "Mon tableau de bord";
        $view = new View("Main/contact", "back");

        $user = User::getInstance(); // Or however you get the logged-in user
        $role = $user->getRole();

        if ($role === 'admin') {
            // Redirect to admin dashboard
        } elseif ($role === 'blogger') {
            // Redirect to blogger dashboard
        } else {
            // Redirect to 404 or some other page
        }
    }
}
