<?php

namespace Quagga\Quagga\Http;

use Quagga\Contracts\Http\Response as ResponseContract;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

class Response extends BaseResponse implements ResponseContract
{
    use PsrResponse;
}
