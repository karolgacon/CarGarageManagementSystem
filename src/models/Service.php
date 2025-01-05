<?php


class Service {
    private int $id;
    private int $vehicleId;
    private string $description;
    private string $status;
    private string $date;
    private float $cost;

    public function __construct(int $id, int $vehicleId, string $description, string $status, string $date, float $cost) {
        $this->id = $id;
        $this->vehicleId = $vehicleId;
        $this->description = $description;
        $this->status = $status;
        $this->date = $date;
        $this->cost = $cost;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function getVehicleId(): int {
        return $this->vehicleId;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function getCost(): float {
        return $this->cost;
    }
}

