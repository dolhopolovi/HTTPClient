<?php

declare(strict_types = 1);

namespace Merce\RestClient\AuthTokenPlug\src\Core\TokenController\JWTToken;

use Nyholm\Psr7\Request;
use Http\Message\Authentication;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Cache\Adapter\PHPArray\ArrayCachePool;
use Psr\SimpleCache\InvalidArgumentException;
use Psr\Http\Client\ClientExceptionInterface;
use Merce\RestClient\AuthTokenPlug\src\DTO\JWTToknen\JWTAuthData;
use Merce\RestClient\AuthTokenPlug\src\Core\TokenParser\Impl\JWTTokenParser;

class AutoJWTTokenController implements Authentication
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
     *
     * @throws InvalidArgumentException
     * @throws ClientExceptionInterface
     */
    public function authenticate(RequestInterface $request): RequestInterface
    {

        $item = self::$tokenStorage->get((string)$this->jwtAuthData);

        if ($item) {
            return $request->withHeader('Authorization', sprintf('Bearer %s', $item));
        }

        $token = $this->apiLogin();

        if (is_null($token)) {
            return $request;
        }

        $tokenPayload = $this->jwtTokenParser->parseTokenPayload($token);

        self::$tokenStorage->set((string)$this->jwtAuthData, $token, $tokenPayload->expDate ? $tokenPayload->expDate - time() : null);

        return $request->withHeader('Authorization', sprintf('Bearer %s', $token));
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