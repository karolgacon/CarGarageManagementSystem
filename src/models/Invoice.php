<?php


class Invoice
{
    private $id;
    private $amount;
    private $status;
    private $issueDate;

    public function __construct(int $id, float $amount, string $status, string $issueDate)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->status = $status;
        $this->issueDate = $issueDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getIssueDate(): string
    {
        return $this->issueDate;
    }
}
