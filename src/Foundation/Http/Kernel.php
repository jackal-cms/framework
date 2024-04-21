<?php

namespace Quagga\Quagga\Foundation\Http;

use Exception;
use Quagga\Contracts\Debug\ExceptionHandler;
use Quagga\Contracts\Foundation\ApplicationContract;
use Quagga\Contracts\Http\Kernel as HttpKernel;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Throwable;

class Kernel implements HttpKernel
{
    /**
     * The application implementation.
     *
     * @var \Quagga\Contracts\Foundation\ApplicationContract
     */
    protected $app;

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

        $this->app = $app;

        $this->app->booted(function () {
            // $this->defineConsoleSchedule();
        });
    }


    /**
     * Handle an incoming HTTP request.
     *
     * @param  \Quagga\Quagga\Http\Request  $request
     * @return \Quagga\Quagga\Http\Response
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
            $this->reportException($e = new FatalThrowableError($e));

            $response = $this->renderException($request, $e);
        }

        $this->app['events']->dispatch(
            new Events\RequestHandled($request, $response)
        );

        return $response;
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderException($request, Exception $e)
    {
        return $this->app[ExceptionHandler::class]->render($request, $e);
    }
}
