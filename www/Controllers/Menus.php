<?php

namespace App\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Core\View;

class Menus
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

        $activeTab = 'menus';
        $menuModel = Menu::createInstance();
        $menus = $menuModel->getAllMenus();
        $view = new View("Dashboard/menus", "back");
        $view->assign("menus", $menus);
        $view->assign("role", $role);
        $view->assign("activeTab", $activeTab);
    }

    public function create()
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

        $activeTab = 'menus';
        $view = new View("Menus/add", "back");
        $view->assign("role", $role);
        $view->assign("activeTab", $activeTab);
    }

    public function store()
    {
        // Validate and sanitize input
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);
        $order = filter_input(INPUT_POST, 'order', FILTER_SANITIZE_NUMBER_INT);

        // Create a new menu item
        $menuItem = Menu::createInstance();
        $menuItem->setName($name);
        $menuItem->setUrl($url);
        $menuItem->setOrder($order);

        if ($menuItem->createMenu()) {
            header("Location: /dashboard/menus?success=menu_created");
        } else {
            header("Location: /dashboard/menus/create?error=menu_not_created");
        }
        exit();
    }

    public function edit($params)
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

        $id = $params['id'];
        $menuItem = Menu::createInstance();
        $menuItem->loadById($id);

        $activeTab = 'menus';
        $view = new View("Menus/edit", "back");
        $view->assign("menuItem", $menuItem);
        $view->assign("role", $role);
        $view->assign("activeTab", $activeTab);
    }

    public function update($params)
    {
        $id = $params['id'];

        // Validate and sanitize input
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);
        $order = filter_input(INPUT_POST, 'order', FILTER_SANITIZE_NUMBER_INT);

        // Update the menu item
        $menuItem = Menu::createInstance();
        $menuItem->setId($id);
        $menuItem->setName($name);
        $menuItem->setUrl($url);
        $menuItem->setOrder($order);

        if ($menuItem->updateMenu()) {
            header("Location: /dashboard/menus?success=menu_updated");
        } else {
            header("Location: /dashboard/menus/edit/$id?error=menu_not_updated");
        }
        exit();
    }

    public function delete($params)
    {
        $id = $params['id'];

        $menuItem = Menu::createInstance();
        $menuItem->setId($id);

        if ($menuItem->delete()) {
            header("Location: /dashboard/menus?success=menu_deleted");
        } else {
            header("Location: /dashboard/menus?error=menu_not_deleted");
        }
        exit();
    }
}
