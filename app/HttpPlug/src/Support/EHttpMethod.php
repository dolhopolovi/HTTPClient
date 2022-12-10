<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Support;

enum EHttpMethod:string
{

    case HEAD = 'HEAD';
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case PATCH = 'PATCH';
    case OPTIONS = 'OPTIONS';
}
