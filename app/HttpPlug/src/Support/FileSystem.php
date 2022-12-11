<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Support;

trait FileSystem
{

    public function getLibRoot(): string
    {

        $lDirName = dirname(__DIR__);
        return substr($lDirName, 0, strpos($lDirName, "HttpPlug")) . "/HttpPlug";
    }
}