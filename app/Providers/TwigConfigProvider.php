<?php

namespace App\Providers;

use PHPNomad\Template\Interfaces\CanResolvePaths;

class TwigConfigProvider implements \PHPNomad\Twig\Integration\Interfaces\TwigConfigProvider
{
    public function __construct(protected CanResolvePaths $pathResolver)
    {

    }

    public function getTemplateDirectory(): string
    {
        return $this->pathResolver->getPath('/public');
    }
}