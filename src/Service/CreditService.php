<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use App\Entity\Client\AddressState as AddressStateEnum;
use App\Entity\Credit;
use App\Entity\Product;
use App\Service\CreditService\RandomDecisionCached;
use App\Service\CreditService\EligibilityCheck\Chain as EligibilityCheckChain;
use App\Service\CreditService\EligibilityCheck\NyRandomDecision;
use Doctrine\ORM\EntityManagerInterface;

readonly class CreditService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RandomDecisionCached   $randomDecisionCached,
        private NotificationService    $notificationService,
    ) {}

    public function save(Credit $credit): void
    {
        $this->entityManager->persist($credit);
        $this->entityManager->flush();
    }

    public function getRejectionReasons(Client $client): array
    {
        return $this->getEligibilityCheckChain($client)->getRejectionReasons();
    }

    public function isEligible(Client $client): bool
    {
        return $this->getEligibilityCheckChain($client)->isEligible();
    }

    public function issue(Client $client): void
    {
        $product = $this->getProduct();

        $interestRate = $product->getInterestRate();
        if ($client->getState() === AddressStateEnum::CALIFORNIA->value) {
            $interestRate += 11.49;
        }

        $credit = new Credit(
            $product->getName(),
            $product->getTerm(),
            $interestRate,
            $product->getAmount(),
            $client
        );

        $this->save($credit);

        $this->randomDecisionCached->deleteByClient($client);

        $this->notificationService->sendCreditNotification($credit);
    }

    private function getEligibilityCheckChain(Client $client): EligibilityCheckChain
    {
        return new EligibilityCheckChain($client)
            ->with(new NyRandomDecision($client, $this->randomDecisionCached));
    }

    private function getProduct(): Product
    {
        return new Product('Gold credit', 6, 12, 5000);
    }
}
