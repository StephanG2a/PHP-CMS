<?php

namespace App\Controllers;

// session_start();

use App\Models\User;
use App\Models\Comment;
use App\Core\View;

class Comments
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

        // Fetch all comments from the database
        $commentModel = Comment::createInstance();
        $comments = $commentModel->getAllComments();

        $activeTab = 'comments';
        $view = new View("Dashboard/comments", "back");
        $view->assign("role", $role);
        $view->assign("activeTab", $activeTab);
        $view->assign("comments", $comments);  // Pass the comments to the view
    }


    public function store()
    {
        // Get the user ID and post ID from the session and form
        $userId = $_SESSION['user_id'];
        $postId = $_POST['post_id'];
        $comment = $_POST['comment'];

        // Create a new comment
        $commentModel = Comment::createInstance();
        $commentModel->createComment($userId, $postId, $comment);

        // Redirect back to the post
        header("Location: /post/" . $postId);
    }

    public function updateCommentStatus()
    {
        $commentId = $_POST['comment_id'];
        $isPublished = isset($_POST['is_published']) ? 1 : 0;  // Check if checkbox is checked

        $commentModel = Comment::createInstance();
        $commentModel->updateCommentStatus($commentId, $isPublished);

        // Redirect back to the dashboard or wherever you want
        header('Location: /dashboard/comments');
    }
}
