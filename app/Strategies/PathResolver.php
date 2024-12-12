<?php

namespace App\Strategies;

use PHPNomad\Template\Interfaces\CanResolvePaths;
use PHPNomad\Utils\Helpers\Arr;

class PathResolver implements CanResolvePaths
{
    /**
     * Get the path to an asset relative to the index.php entrypoint.
     *
     * @param string $assetName
     * @return string
     */
    public function getPath(string $assetName = ''): string
    {
        $baseDir = dirname(Arr::get($_SERVER, 'SCRIPT_FILENAME'));

        return $baseDir . DIRECTORY_SEPARATOR . ltrim($assetName, DIRECTORY_SEPARATOR);
    }
}