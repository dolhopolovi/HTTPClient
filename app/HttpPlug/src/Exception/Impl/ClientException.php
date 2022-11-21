<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Exception\Impl;

use RuntimeException;
use Http\Client\Exception as HTTPlugException;
use Merce\RestClient\HttpPlug\src\Exception\IException;

class ClientException extends RuntimeException implements IException, HTTPlugException
{

}
