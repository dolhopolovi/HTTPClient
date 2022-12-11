<?php

namespace Merce\RestClient\HttpPlug\src\Support;

trait FileSystem
{
    public function getLibRoot(): string {

        $ldirName = dirname(__DIR__);
        return substr($ldirName, 0, strpos($ldirName(__DIR__), "HttpPlug")) . "/HttpPlug";
    }
}