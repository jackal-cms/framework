<?php

namespace Quagga\Quagga\Foundation\Bootstrap;

use Quagga\Contracts\Foundation\ApplicationContract as Application;

class RegisterProviders
{
    /**
     * Bootstrap the given application.
     *
     * @param \Quagga\Contracts\Foundation\ApplicationContract $app
     *
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $app->registerConfiguredProviders();
    }
}
