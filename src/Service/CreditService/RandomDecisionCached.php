<?php

/**
 * @author Anton Acc <me@anton-a.cc>
 */
declare(strict_types=1);

namespace App\Service\CreditService;

use App\Entity\Client;
use Symfony\Component\Cache\CacheItem;
use Symfony\Contracts\Cache\CacheInterface;

readonly class RandomDecisionCached
{
    private const string RANDOM_DECISION_KEY_PREFIX = 'random_decision_';

    public function __construct(
        private CacheInterface $cache,
    ) {}

    public function getByClient(Client $client): bool
    {
        $cacheKey = $this->getCacheKey($client);

        return $this->cache->get($cacheKey, function (CacheItem $item) {
            $item->expiresAfter(60 * 5); // memorise decision for 5 minutes

            return random_int(0, 1) === 1;
        });
    }

    public function deleteByClient(Client $client): void
    {
        $cacheKey = $this->getCacheKey($client);
        $this->cache->delete($cacheKey);
    }

    private function getCacheKey($client): string
    {
        return self::RANDOM_DECISION_KEY_PREFIX . $client->getId();
    }
}
