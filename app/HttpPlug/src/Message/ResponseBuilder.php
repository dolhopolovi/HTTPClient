<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Message;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Merce\RestClient\HttpPlug\src\Exception\Impl\InvalidArgumentException;

use function count;

final class ResponseBuilder
{

    private ResponseInterface $response;

    public function __construct(private readonly ResponseFactoryInterface $responseFactory)
    {

        $this->response = $responseFactory->createResponse();
    }

    /**
     * @param  string  $input
     * @return void
     * @throws InvalidArgumentException
     */
    public function setStatus(string $input): void
    {

        $parts = explode(' ', $input, 3);
        if (count($parts) < 2 || !str_starts_with(strtolower($parts[0]), 'http/')) {
            throw new InvalidArgumentException("$input is not a valid HTTP status line");
        }

        $this->response = $this->response->withStatus((int)$parts[1], $parts[2] ?? '');
        $this->response = $this->response->withProtocolVersion(substr($parts[0], 5));
    }

    /**
     * @param  string  $input
     * @return void
     */
    public function addHeader(string $input): void
    {

        [$key, $value] = explode(':', $input, 2);
        $this->response = $this->response->withAddedHeader(trim($key), trim($value));
    }

    /**
     * @param  string  $input
     * @return int
     */
    public function writeBody(string $input): int
    {

        return $this->response->getBody()->write($input);
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {

        $this->response->getBody()->rewind();
        $response = $this->response;
        $this->response = $this->responseFactory->createResponse();

        return $response;
    }
}