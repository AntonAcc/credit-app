<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CreditRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
#[Table(name: 'client_credit')]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $productName;

    #[ORM\Column]
    private int $term;

    #[ORM\Column]
    private float $interestRate;

    #[ORM\Column]
    private float $amount;

    #[ORM\ManyToOne(inversedBy: 'clientCredits')]
    #[ORM\JoinColumn(nullable: false)]
    private Client $client;

    /**
     * @param string $productName
     * @param int $term
     * @param float $interestRate
     * @param float $amount
     * @param Client $client
     */
    public function __construct(string $productName, int $term, float $interestRate, float $amount, Client $client)
    {
        $this->productName = $productName;
        $this->term = $term;
        $this->interestRate = $interestRate;
        $this->amount = $amount;
        $this->client = $client;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getTerm(): int
    {
        return $this->term;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
