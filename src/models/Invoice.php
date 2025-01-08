<?php
class Invoice {
    private int $id;
    private int $serviceId;
    private string $invoiceNumber;
    private float $amount;
    private string $status;
    private string $createdAt;

    private float $vat;
    private string $statusUpdatedAt;

    public function getStatusUpdatedAt(): string
    {
        return $this->statusUpdatedAt;
    }

    public function setStatusUpdatedAt(string $statusUpdatedAt): void
    {
        $this->statusUpdatedAt = $statusUpdatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getVat(): float
    {
        return $this->vat;
    }

    public function setVat(float $vat): void
    {
        $this->vat = $vat;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    public function setServiceId(int $serviceId): void
    {
        $this->serviceId = $serviceId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    // Gettery i settery...

    public function getInvoiceNumber(): string {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(string $invoiceNumber): void {
        $this->invoiceNumber = $invoiceNumber;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void {
        $this->createdAt = $createdAt;
    }
}

