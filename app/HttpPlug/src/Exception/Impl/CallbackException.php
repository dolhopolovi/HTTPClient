<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Exception\Impl;

use Throwable;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Client\RequestExceptionInterface as PsrRequestException;

class CallbackException extends ClientException implements PsrRequestException
{

    private RequestInterface $request;

    public function __construct(RequestInterface $request, string $message = '', int $code = 0, Throwable $previous = null)
    {

        $this->request = $request;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {

        return $this->request;
    }
}
