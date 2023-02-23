<?php

namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class Globals implements RuntimeExtensionInterface
{
    private $globals;

    public function __construct(array $globals)
    {
        $this->globals = $globals;
    }

    public function getGlobals(): array
    {
        return $this->globals;
    }
}
