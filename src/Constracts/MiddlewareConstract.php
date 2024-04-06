<?php

namespace Quagga\Quagga\Constracts;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareConstract extends MiddlewareInterface
{
    public function getPriority(): int;
}
