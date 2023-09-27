<?php

namespace App\Models;

use App\Core\Sql;

class Menu extends Sql
{
    protected int $id = 0;
    protected string $name;
    protected string $url;
    protected int $order;

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

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = trim($url);
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    public function loadById(int $id): void
    {
        $query = "SELECT * FROM esgi_menus WHERE id = :id LIMIT 1";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':id', $id, \PDO::PARAM_INT);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(\PDO::FETCH_ASSOC);

        if ($result) {
            $this->id = $result['id'];
            $this->name = $result['name'];
            $this->url = $result['url'];
            $this->order = $result['order'];
        } else {
            throw new \Exception("Menu item with ID $id not found.");
        }
    }

    public function getAllMenus()
    {
        $query = "SELECT * FROM esgi_menus ORDER BY \"order\" ASC";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createMenu()
    {
        try {
            $query = "INSERT INTO esgi_menus (name, url, \"order\") VALUES (:name, :url, :order)";
            $queryPrepared = $this->pdo->prepare($query);
            $queryPrepared->bindParam(':name', $this->name);
            $queryPrepared->bindParam(':url', $this->url);
            $queryPrepared->bindParam(':order', $this->order);
            return $queryPrepared->execute();
        } catch (\PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateMenu()
    {
        $query = "UPDATE esgi_menus SET name = :name, url = :url, \"order\" = :order WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':id', $this->id);
        $queryPrepared->bindParam(':name', $this->name);
        $queryPrepared->bindParam(':url', $this->url);
        $queryPrepared->bindParam(':order', $this->order);
        return $queryPrepared->execute();
    }

    public function delete()
    {
        $queryPrepared = $this->pdo->prepare("DELETE FROM esgi_menus WHERE id = :id");
        $queryPrepared->bindParam(':id', $this->id, \PDO::PARAM_INT);
        return $queryPrepared->execute();
    }

    public function getMenuCount()
    {
        $query = "SELECT COUNT(*) as count FROM esgi_menus";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(\PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public static function createInstance()
    {
        return new self();
    }
}
