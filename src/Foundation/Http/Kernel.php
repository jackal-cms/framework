<?php

namespace Quagga\Quagga\Foundation\Http;

use Exception;
use Quagga\Contracts\Debug\ExceptionHandler;
use Quagga\Contracts\Foundation\Application as ApplicationContract;
use Quagga\Contracts\Http\Kernel as HttpKernel;
use Quagga\Quagga\Http\Response;
use Quagga\Quagga\Pipeline\Pipeline;
use Quagga\Quagga\Support\Facades\Facade;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Throwable;

class Kernel implements HttpKernel
{
    /**
     * The application implementation.
     *
     * @var \Quagga\Contracts\Foundation\Application|null
     */
    protected $app;

    /**
     * The router instance.
     *
     * @var \Slim\Interfaces\MiddlewareDispatcherInterface;
     *
     */
    protected $slimDispatcher;

    /**
     * The application's middleware stack.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [];

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

    /**
     * Create a new console kernel instance.
     *
     * @param  \Quagga\Contracts\Foundation\Application  $app
     *
     * @return void
     */
    public function __construct(ApplicationContract $app)
    {
        if (! defined('ARTISAN_BINARY')) {
            define('ARTISAN_BINARY', 'artisan');
        }

        $this->app            = $app;
        // $this->slimDispatcher = $middlewareDispatcher;

        $this->app->booted(function () {
            // $this->defineConsoleSchedule();
        });
    }


    /**
     * Handle an incoming HTTP request.
     *
     * @param  \Quagga\Quagga\Http\Request  $request
     * @return \Quagga\Quagga\Http\Response|\Quagga\Quagga\Http\JsonResponse
     */
    public function handle($request)
    {
        try {
            $request->enableHttpMethodParameterOverride();

            $response = $this->sendRequestThroughRouter($request);
        } catch (Exception $e) {
            $this->reportException($e);

            $response = $this->renderException($request, $e);
        } catch (Throwable $e) {
            var_dump($e);
            die('haha');
            $this->reportException($e = new FatalThrowableError($e));

            $response = $this->renderException($request, $e);
        }

        $this->app['events']->dispatch(
            new Events\RequestHandled($request, $response)
        );

        return $response;
    }

    /**
     * Send the given request through the middleware / router.
     *
     * @param  \Quagga\Quagga\Http\Request  $request
     * @return \Quagga\Quagga\Http\Response
     */
    protected function sendRequestThroughRouter($request)
    {
        $this->app->instance('request', $request);

        Facade::clearResolvedInstance('request');

        $this->bootstrap();

        return (new Pipeline($this->app))
                    ->send($request)
                    ->through($this->app->shouldSkipMiddleware() ? [] : $this->middleware)
                    ->then($this->dispatchToRouter());
    }

    /**
     * Get the route dispatcher callback.
     *
     * @return \Closure
     */
    protected function dispatchToRouter()
    {
        return function ($request) {
            $this->app->instance('request', $request);

            return new Response('test');

            return $this->slimDispatcher->handle($request);
        };
    }

    /**
     * Bootstrap the application for HTTP requests.
     *
     * @return void
     */
    public function bootstrap()
    {
        if (! $this->app->hasBeenBootstrapped()) {
            $this->app->bootstrapWith($this->bootstrappers());
        }
    }

    /**
     * Get the bootstrap classes for the application.
     *
     * @return array
     */
    protected function bootstrappers()
    {
        return $this->bootstrappers;
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Exception  $e
     * @return void
     */
    protected function reportException(Exception $e)
    {
        $this->app[ExceptionHandler::class]->report($e);
    }

    /**
     * Render the exception to a response.
     *
     * @param  \Quagga\Quagga\Http\Request  $request
     * @param  \Exception  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderException($request, Exception $e)
    {
        return $this->app[ExceptionHandler::class]->render($request, $e);
    }
}
