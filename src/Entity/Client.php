<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column(length: 100)]
    private string $lastName;

    #[ORM\Column]
    private int $age;

    #[ORM\Column(length: 9)]
    private string $ssn;

    #[ORM\Column]
    private string $address;

    #[ORM\Column(length: 2)]
    private string $state;

    #[ORM\Column(length: 100)]
    private string $email;

    #[ORM\Column(length: 15)]
    private string $phoneNumber;

    #[ORM\Column]
    private int $creditScore;

    #[ORM\Column]
    private float $monthlyIncome;

    /**
     * @var Collection<int, ClientCredit>
     */
    #[ORM\OneToMany(targetEntity: ClientCredit::class, mappedBy: 'client', orphanRemoval: true)]
    private Collection $clientCredits;

    public function __construct(string $name, string $lastName, int $age, string $ssn, string $address, string $state, string $email, string $phoneNumber, int $creditScore, float $monthlyIncome)
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->ssn = $ssn;
        $this->address = $address;
        $this->state = $state;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->creditScore = $creditScore;
        $this->monthlyIncome = $monthlyIncome;
        $this->clientCredits = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getSsn(): string
    {
        return $this->ssn;
    }

    public function setSsn(string $ssn): void
    {
        $this->ssn = $ssn;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getCreditScore(): int
    {
        return $this->creditScore;
    }

    public function setCreditScore(int $creditScore): void
    {
        $this->creditScore = $creditScore;
    }

    public function getMonthlyIncome(): float
    {
        return $this->monthlyIncome;
    }

    public function setMonthlyIncome(float $monthlyIncome): void
    {
        $this->monthlyIncome = $monthlyIncome;
    }

    /**
     * @return Collection<int, ClientCredit>
     */
    public function getClientCredits(): Collection
    {
        return $this->clientCredits;
    }
}
