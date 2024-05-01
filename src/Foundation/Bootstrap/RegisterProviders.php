<?php

namespace Quagga\Quagga\Foundation\Bootstrap;

use Quagga\Contracts\Foundation\Application as ApplicationContract;

class RegisterProviders
{
    /**
     * Bootstrap the given application.
     *
     * @param \Quagga\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function bootstrap(ApplicationContract $app)
    {
        $app->registerConfiguredProviders();
    }
}
