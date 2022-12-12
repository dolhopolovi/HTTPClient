<?php

namespace Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Partials\Logger;

use Merce\RestClient\HttpPlug\src\Support\FileSystem;

class FileLoggerService
{
    use FileSystem;

    public function __construct(private readonly string $logPath = '/log/curl-log.log') { }

    public function getResource() {
        return fopen("{$this->getLibRoot()} . $this->logPath", 'w+');
    }
}