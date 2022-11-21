<?php

declare(strict_types = 1);

namespace Merce\RestClient\AuthTokenPlug\src\Core\TokenManager;

use Nyholm\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Cache\Adapter\PHPArray\ArrayCachePool;
use Psr\SimpleCache\InvalidArgumentException;
use Psr\Http\Client\ClientExceptionInterface;
use Merce\RestClient\AuthTokenPlug\src\DTO\JWTAuthData;
use Merce\RestClient\AuthTokenPlug\src\Core\TokenParser\Impl\JWTTokenParser;

class JWTTokenManager
{

    private static ?ArrayCachePool $tokenStorage = null;

    public function __construct(
        private readonly JWTAuthData $jwtAuthData,
        private readonly ClientInterface $client,
        private readonly JWTTokenParser $jwtTokenParser = new JWTTokenParser()
    ) {

        if (is_null(self::$tokenStorage)) {
            self::$tokenStorage = new ArrayCachePool();
        }
    }

    /**
     * @return string
     * @throws InvalidArgumentException
     * @throws ClientExceptionInterface
     */
    public function get(): string
    {

        $item = self::$tokenStorage->get((string)$this->jwtAuthData);

        if ($item) {
            return $item;
        }

        $token = $this->apiLogin();

        if (is_null($token)) {
            return '';
        }

        $tokenPayload = $this->jwtTokenParser->parseTokenPayload($token);

        self::$tokenStorage->set((string)$this->jwtAuthData, $token, $tokenPayload->expDate ? $tokenPayload->expDate - time() : null);

        return $token;
    }

    /**
     * @return string|null
     * @throws ClientExceptionInterface
     */
    private function apiLogin(): ?string
    {

        $request = new Request('GET', $this->jwtAuthData->sourceRoute);
        $response = $this->client->sendRequest($request);

        if ($response->getStatusCode() !== 401) {
            return $response->getBody()->getContents();
        }

        return null;
    }
}