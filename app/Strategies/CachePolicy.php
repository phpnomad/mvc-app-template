<?php

namespace App\Strategies;

use PHPNomad\Cache\Enums\Operation;
use PHPNomad\Cache\Factories\HashedCacheKeyFactory;
use PHPNomad\Cache\Interfaces\CachePolicy as CoreCachePolicy;
use PHPNomad\Cache\Interfaces\HasDefaultTtl;
use PHPNomad\Config\Interfaces\ConfigStrategy;

class CachePolicy implements CoreCachePolicy, HasDefaultTtl
{
    protected HashedCacheKeyFactory $cacheKeyFactory;
    protected HasDefaultTtl         $defaultTtlProvider;
    protected ConfigStrategy          $configStrategy;

    public function __construct(
      HashedCacheKeyFactory $cacheKeyFactory,
      ConfigStrategy $configStrategy,
    )
    {
        $this->configStrategy = $configStrategy;
        $this->cacheKeyFactory = $cacheKeyFactory;
    }

    /** @inheritDoc */
    public function shouldCache(string $operation, array $context = []): bool
    {
        /**
         * @TODO
         *
         * This makes it possible to enable/disable the cache from config.
         * If you would like to have more granular control over cache, you'll need to implement this method.
         */
        return $this->configStrategy->get('cache.shouldCache');
    }

    /** @inheritDoc */
    public function getCacheKey(array $context): string
    {
        return $this->cacheKeyFactory->getCacheKey($context);
    }

    /** @inheritDoc */
    public function getTtl(array $context = []): ?int
    {
        return $this->defaultTtlProvider->getDefaultTtl();
    }

    /** @inheritDoc */
    public function shouldInvalidate(string $operation, array $context = []): bool
    {
        return Operation::isInvalidatingOperation($operation);
    }

    public function getDefaultTtl(): ?int
    {
        return $this->configStrategy->get('cache.defaultTtl');
    }
}