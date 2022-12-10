<?php

namespace Merce\RestClient\AuthTokenPlug\src\Core\TokenController\BasicAuthToken;

use Http\Message\Authentication;
use Psr\Http\Message\RequestInterface;
use Merce\RestClient\AuthTokenPlug\src\DTO\BasicAuthToken\BasicAuthTokenCredentialData;

class ManualBasicAuthTokenController implements Authentication
{
    public function __construct(private readonly BasicAuthTokenCredentialData $authTokenCredentialData) {
    }
    
    public function authenticate(RequestInterface $request): RequestInterface
    {
        return $request->withHeader('Authorization', sprintf('Basic %s', $this->authTokenCredentialData));
    }
}