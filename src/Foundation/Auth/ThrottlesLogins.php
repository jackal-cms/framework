<?php

namespace Quagga\Quagga\Foundation\Auth;

use Slim\Psr7\Request;

trait ThrottlesLogins
{
    protected function incrementLoginAttempts(Request $request)
    {
        // Now it's not supported
    }
}
