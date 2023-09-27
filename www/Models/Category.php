<?php

namespace App\Models;

use App\Core\Sql;

class Category extends Sql
{
    protected int $id = 0;
    protected string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = trim($name);
    }

    public function loadById(int $id): void
    {
        $query = "SELECT * FROM esgi_categories WHERE id = :id LIMIT 1";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':id', $id, \PDO::PARAM_INT);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(\PDO::FETCH_ASSOC);

        if ($result) {
            $this->id = $result['id'];
            $this->name = $result['name'];
        } else {
            throw new \Exception("Category with ID $id not found.");
        }
    }

    public function getAllCategories()
    {
        $query = "SELECT * FROM esgi_categories";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createCategory($name)
    {
        try {
            $query = "INSERT INTO esgi_categories (name) VALUES (:name)";
            $queryPrepared = $this->pdo->prepare($query);
            $queryPrepared->bindParam(':name', $name);
            return $queryPrepared->execute();
        } catch (\PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateCategory($id, $name)
    {
        $query = "UPDATE esgi_categories SET name = :name WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':id', $id);
        $queryPrepared->bindParam(':name', $name);
        return $queryPrepared->execute();
    }

    public function delete()
    {
        $queryPrepared = $this->pdo->prepare("DELETE FROM esgi_categories WHERE id = :id");
        $queryPrepared->bindParam(':id', $this->id, \PDO::PARAM_INT);
        return $queryPrepared->execute();
    }

    public function saveCategory()
    {
        try {
            $query = "INSERT INTO esgi_categories (name) VALUES (:name)";
            $queryPrepared = $this->pdo->prepare($query);
            $queryPrepared->bindParam(':name', $this->name);
            return $queryPrepared->execute();
        } catch (\PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }

    public static function createInstance()
    {
        return new self();
    }
}
