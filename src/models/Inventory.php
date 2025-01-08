<?php

class Inventory {
    private int $id;
    private string $name;
    private string $category;
    private int $quantity;
    private float $price;
    private ?string $description;

    public function __construct(
        int $id,
        string $name,
        string $category,
        int $quantity,
        float $price,
        ?string $description = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->description = $description;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getDescription(): ?string {
        return $this->description;
    }
}
