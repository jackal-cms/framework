<?php

namespace Quagga\Quagga\Http;

trait PsrResponse
{
    function getReasonPhrase()
    {
        $this->statusText;
    }

    function withStatus(int $code, string $reasonPhrase = '')
    {
        $this->setStatusCode($code, $reasonPhrase);
    }

    function getBody()
    {
        return $this->getContent();
    }

    function getHeader(string $name)
    {
        $this->headers->get($name, null);
    }

    function getHeaderLine(string $name)
    {
        return collect(iterator_to_array(
            $this->headers->getIterator()
        ))->join(',');
    }

    function getHeaders()
    {
        return $this->headers->getIterator();
    }

    function hasHeader(string $name)
    {
        return $this->headers->has($name);
    }

    function withAddedHeader(string $name, $value)
    {
    }
    function withBody(\Psr\Http\Message\StreamInterface $body)
    {
        $this->setContent($body);
    }

    function withHeader(string $name, $value)
    {
        $this->headers->set($name, $value);
    }

    function withoutHeader(string $name)
    {
        $this->headers->remove($name);
    }

    function withProtocolVersion(string $version)
    {
        $this->setProtocolVersion($version);
    }
}
