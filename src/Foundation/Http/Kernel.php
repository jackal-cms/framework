<?php

namespace Quagga\Quagga\Foundation\Http;

use Quagga\Quagga\Contracts\Http\Kernel as KernelConstract;

class Kernel implements KernelConstract
{
    protected $bootstrappers = [
        \Quagga\Quagga\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \Quagga\Quagga\Foundation\Bootstrap\LoadConfiguration::class,
        \Quagga\Quagga\Foundation\Bootstrap\HandleExceptions::class,
        \Quagga\Quagga\Foundation\Bootstrap\RegisterFacades::class,
        \Quagga\Quagga\Foundation\Bootstrap\RegisterProviders::class,
        \Quagga\Quagga\Foundation\Bootstrap\BootProviders::class,
        \Quagga\Quagga\Foundation\Bootstrap\RegisterExtensions::class,
        \Quagga\Quagga\Foundation\Bootstrap\RegisterThemes::class,
        \Quagga\Quagga\Foundation\Bootstrap\BootExtensions::class,
        \Quagga\Quagga\Foundation\Bootstrap\BootTheme::class,
    ];
}
