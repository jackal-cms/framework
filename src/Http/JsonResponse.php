<?php

namespace Quagga\Quagga\Http;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse as BaseJsonResponse;

class JsonResponse extends BaseJsonResponse implements ResponseInterface
{
    use PsrResponse;

    /**
     * Constructor.
     *
     * @param  mixed  $data
     * @param  int    $status
     * @param  array  $headers
     * @param  int    $options
     * @return void
     */
    public function __construct($data = null, $status = 200, $headers = [], $options = 0)
    {
        $this->encodingOptions = $options;

        parent::__construct($data, $status, $headers);
    }
}
