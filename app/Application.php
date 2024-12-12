<?php

namespace App;

use PHPNomad\Cache\Traits\WithInstanceCache;
use PHPNomad\Component\JsonConfigIntegration\ConfigInitializer;
use PHPNomad\Core\Bootstrap\CoreInitializer as PHPNomadCoreInitializer;
use PHPNomad\Di\Container;
use PHPNomad\FastRoute\Component\RestInitializer;
use PHPNomad\Loader\Bootstrapper;
use PHPNomad\Loader\Exceptions\LoaderException;
use PHPNomad\Symfony\Component\EventDispatcherIntegration\Initializer as SymfonyEventInitializer;

final class Application
{
    use WithInstanceCache;

    protected array $configs = [];

    /**
     * Gets a new container instance.
     *
     * @return Container
     */
    protected function getContainer(): Container
    {
        return $this->getFromInstanceCache(Container::class, fn() => new Container());
    }

    protected function initBaseDependencies()
    {
        (new Bootstrapper(
          $this->getContainer(),
          new ConfigInitializer($this->configs),
          new PHPNomadCoreInitializer(),
          new SymfonyEventInitializer(),
          new RestInitializer()
        ))->load();
    }

    public function setConfig($key, $path): static
    {
        $this->configs[$key] = $path;

        return $this;
    }

    /**
     * Sets up the application.
     *
     * @return void
     * @throws LoaderException
     */
    public function init(): void
    {
        $this->initBaseDependencies();

        (new Bootstrapper(
          $this->getContainer(),
          new Initializer()
        ))->load();
    }
}