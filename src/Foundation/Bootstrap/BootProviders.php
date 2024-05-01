<?php

namespace Quagga\Quagga\Foundation\Bootstrap;

use Quagga\Contracts\Foundation\Application;

class BootProviders
{
    public function bootstrap(Application $app)
    {
        $app->boot();
    }
}
