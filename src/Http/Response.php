<?php

namespace Quagga\Quagga\Http;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

class Response extends BaseResponse implements ResponseInterface
{
    use PsrResponse;
}
