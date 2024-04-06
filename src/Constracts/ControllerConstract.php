<?php

namespace Quagga\Quagga\Constracts;

use Psr\Http\Message\ResponseInterface;

interface ControllerConstract
{
    public function getExtensionName(): string;

    public function isDashboardController(): bool;

    public function view(
        $template,
        $data = [],
        ResponseInterface $response = null,
        $extensionName = null
    ): ResponseInterface;
}
