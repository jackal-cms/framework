<?php

namespace Quagga\Quagga\Log;

use Quagga\Quagga\Helper;
use Quagga\Quagga\Settings\SettingsInterface;
use App\Http\Handlers\HttpErrorHandler;
use App\Http\Handlers\ShutdownHandler;
use Psr\Container\ContainerInterface;
use Quagga\Quagga\Support\ServiceProvider;
use ReflectionClass;
use Slim\Factory\ServerRequestCreatorFactory;

class LogServiceProvider extends ServiceProvider
{
}
