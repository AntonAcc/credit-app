<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use App\Entity\Credit;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\Cache\CacheItem;

readonly class CreditService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CacheInterface $cache,
        private NotificationService  $notificationService,
    ) {}

    public function save(Credit $credit): void
    {
        $this->entityManager->persist($credit);
        $this->entityManager->flush();
    }

    public function getRejectionReasons(Client $client): array
    {
        $reasons = [];
        if ($client->getCreditScore() <= 500) {
            $reasons[] = 'Credit score is too low.';
        }
        if ($client->getMonthlyIncome() < 1000) {
            $reasons[] = 'Monthly income is less than $1000.';
        }
        if ($client->getAge() < 18 || $client->getAge() > 60) {
            $reasons[] = 'Client age is not between 18 and 60.';
        }
        // todo: move to constants or enum
        if (!in_array($client->getState(), ['CA', 'NY', 'NV'])) {
            $reasons[] = 'Client does not live in CA, NY, or NV.';
        }

        // todo: use constant or enum
        if ($client->getState() === 'NY' && empty($reasons)) {
            $cacheKey = 'credit_decision_' . $client->getId();

            $decision = $this->cache->get($cacheKey, function (CacheItem $item) {
                $item->expiresAfter(60 * 5); // memorise decision for 5 minutes

                return random_int(0, 1) === 1;
            });

            if ($decision === 0) {
                $reasons[] = 'Random rejection for NY clients.';
            }
        }

        return $reasons;
    }

    public function isEligible(Client $client): bool
    {
        return count($this->getRejectionReasons($client)) === 0;
    }

    public function issue(Client $client): void
    {
        $product = $this->getProduct();

        $interestRate = $product->getInterestRate();
        // todo: use constant or enum
        if ($client->getState() === 'CA') {
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

        $cacheKey = 'credit_decision_' . $client->getId();
        $this->cache->delete($cacheKey);

        $this->notificationService->sendCreditNotification($credit);
    }

    private function getProduct(): Product
    {
        return new Product('Gold credit', 6, 12, 5000);
    }
}
