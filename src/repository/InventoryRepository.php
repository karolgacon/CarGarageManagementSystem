<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Inventory.php';

class InventoryRepository extends Repository {

    public function getAllItems(): array {
        $stmt = $this->database->connect()->query('SELECT * FROM inventory');
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Inventory(
                $row['id'],
                $row['name'],
                $row['category'],
                $row['quantity'],
                $row['price'],
                $row['description']
            );
        }
        return $items;
    }

    public function addItem(array $data): void {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO inventory (name, category, quantity, price, description)
            VALUES (:name, :category, :quantity, :price, :description)
        ');
        $stmt->execute($data);
    }

    public function getItemById(int $id): ?Inventory {
        $stmt = $this->database->connect()->prepare('SELECT * FROM inventory WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new Inventory(
            $row['id'],
            $row['name'],
            $row['category'],
            $row['quantity'],
            $row['price'],
            $row['description']
        ) : null;
    }


    public function updateItem(int $id, array $data): void {
        $stmt = $this->database->connect()->prepare('
        UPDATE inventory
        SET name = :name, category = :category, quantity = :quantity, price = :price, description = :description
        WHERE id = :id
    ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':quantity', $data['quantity'], PDO::PARAM_INT);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->execute();
    }


    public function deleteItem(int $id): void {
        $stmt = $this->database->connect()->prepare('DELETE FROM inventory WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

}
