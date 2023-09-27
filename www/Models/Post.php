<?php

namespace App\Models;

use App\Core\Sql;

class Post extends Sql
{
    protected int $id = 0;
    protected string $title;
    protected string $content;
    protected int $user_id;
    protected int $category_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = trim($title);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = trim($content);
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    public function loadById(int $id): void
    {
        $query = "SELECT * FROM esgi_posts WHERE id = :id LIMIT 1";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':id', $id, \PDO::PARAM_INT);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(\PDO::FETCH_ASSOC);

        if ($result) {
            $this->id = $result['id'];
            $this->title = $result['title'];
            $this->content = $result['content'];
            $this->user_id = $result['user_id'];
            $this->category_id = $result['category_id'];
        } else {
            throw new \Exception("Post with ID $id not found.");
        }
    }

    public function getAllPosts()
    {
        $query = "SELECT p.*, c.name, u.firstname, u.lastname, u.email, u.role FROM esgi_posts p 
              INNER JOIN esgi_categories c ON p.category_id = c.id
              INNER JOIN esgi_user u ON p.user_id = u.id";  // Added u.role here
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPostById($id)
    {
        $query = "SELECT * FROM esgi_posts WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':id', $id, \PDO::PARAM_INT);
        $queryPrepared->execute();
        return $queryPrepared->fetch(\PDO::FETCH_ASSOC);
    }

    public function getPostsByCategory($categoryId)
    {
        $query = "SELECT p.*, c.name, u.firstname, u.lastname, u.email FROM esgi_posts p 
          INNER JOIN esgi_categories c ON p.category_id = c.id
          INNER JOIN esgi_user u ON p.user_id = u.id
          WHERE p.category_id = :categoryId";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':categoryId', $categoryId, \PDO::PARAM_INT);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPostsByCategoryName($categoryName)
    {
        $query = "SELECT p.*, c.name, u.firstname, u.lastname, u.email, u.role FROM esgi_posts p 
      INNER JOIN esgi_categories c ON p.category_id = c.id
      INNER JOIN esgi_user u ON p.user_id = u.id
      WHERE LOWER(c.name) = LOWER(:categoryName)";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':categoryName', $categoryName, \PDO::PARAM_STR);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createPost($title, $content, $user_id, $category_id)
    {
        $query = "INSERT INTO esgi_posts (title, content, user_id, category_id) VALUES (:title, :content, :user_id, :category_id)";
        $queryPrepared = $this->pdo->prepare($query);

        $queryPrepared->bindParam(':title', $title, \PDO::PARAM_STR);
        $queryPrepared->bindParam(':content', $content, \PDO::PARAM_STR);
        $queryPrepared->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $queryPrepared->bindParam(':category_id', $category_id, \PDO::PARAM_INT);

        return $queryPrepared->execute();
    }

    public function updatePost($id, $title, $content, $user_id, $category_id)
    {
        $query = "UPDATE esgi_posts SET title = :title, content = :content, user_id = :user_id, category_id = :category_id WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($query);

        $queryPrepared->bindParam(':id', $id, \PDO::PARAM_INT);
        $queryPrepared->bindParam(':title', $title, \PDO::PARAM_STR);
        $queryPrepared->bindParam(':content', $content, \PDO::PARAM_STR);
        $queryPrepared->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $queryPrepared->bindParam(':category_id', $category_id, \PDO::PARAM_INT);

        return $queryPrepared->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM esgi_posts WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($query);

        $queryPrepared->bindParam(':id', $this->id, \PDO::PARAM_INT);

        return $queryPrepared->execute();
    }


    public static function createInstance()
    {
        return new self();
    }
}
