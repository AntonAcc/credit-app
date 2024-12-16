<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;

readonly class ClientService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function save(Client $client): void
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }
}
