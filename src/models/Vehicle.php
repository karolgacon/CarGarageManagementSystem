<?php


class Vehicle {
    private int $id;
    private int $ownerId;
    private string $make;
    private string $model;
    private int $year;
    private string $vin;
    private string $engineCapacity;

    public function __construct(int $id, int $ownerId, string $make, string $model, int $year, string $vin, string $engineCapacity) {
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
        $this->vin = $vin;
        $this->engineCapacity = $engineCapacity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): void
    {
        $this->ownerId = $ownerId;
    }

    public function getMake(): string
    {
        return $this->make;
    }

    public function setMake(string $make): void
    {
        $this->make = $make;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getVin(): string
    {
        return $this->vin;
    }

    public function setVin(string $vin): void
    {
        $this->vin = $vin;
    }

    public function getEngineCapacity(): string
    {
        return $this->engineCapacity;
    }

    public function setEngineCapacity(string $engineCapacity): void
    {
        $this->engineCapacity = $engineCapacity;
    }

    // Getters and setters...
}

