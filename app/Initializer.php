<?php

namespace App;

use App\Auth\PassthroughUser;
use App\Providers\TwigConfigProvider;
use App\Strategies\CachePolicy;
use App\Strategies\CurrentContextResolverStrategy;
use App\Strategies\PathResolver;
use PHPNomad\Auth\Interfaces\User;
use PHPNomad\Cache\Interfaces\CachePolicy as CachePolicyInterface;
use PHPNomad\Cache\Interfaces\CacheStrategy;
use PHPNomad\Config\Interfaces\ConfigStrategy;
use PHPNomad\Di\Interfaces\CanSetContainer;
use PHPNomad\Di\Traits\HasSettableContainer;
use PHPNomad\FastRoute\Component\Registries\WebRoutesRegistry;
use PHPNomad\Loader\Interfaces\HasClassDefinitions;
use PHPNomad\Loader\Interfaces\Loadable;
use PHPNomad\Symfony\Component\CacheIntegration\Strategies\SymfonyFileCache;
use PHPNomad\Template\Interfaces\CanRender;
use PHPNomad\Template\Interfaces\CanResolvePaths;
use PHPNomad\Twig\Integration\Strategies\TwigEngine;
use PHPNomad\Utils\Helpers\Arr;

class Initializer implements HasClassDefinitions, CanSetContainer, Loadable
{
    use HasSettableContainer;

    public function getClassDefinitions() : array
    {
        return [
          SymfonyFileCache::class => CacheStrategy::class,
          CachePolicy::class => CachePolicyInterface::class,
          PassthroughUser::class => User::class,
          CurrentContextResolverStrategy::class => \PHPNomad\Auth\Interfaces\CurrentContextResolverStrategy::class,
          TwigEngine::class => CanRender::class,
          TwigConfigProvider::class => \PHPNomad\Twig\Integration\Interfaces\TwigConfigProvider::class,
          PathResolver::class => CanResolvePaths::class
        ];
    }

    public function load() : void
    {
        /**
         * Load routes
         */
        Arr::each($this->container->get(ConfigStrategy::class)->get('app.routes'), function (array $route) {
            $this->container->get(WebRoutesRegistry::class)->set(
              Arr::get($route, 'endpoint'),
              Arr::get($route, 'controller')
            );
        });
    }
}