<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Exception\Impl;

use BadMethodCallException;
use Merce\RestClient\HttpPlug\src\Exception\IException;

class NotImplementedException extends BadMethodCallException implements IException
{

}