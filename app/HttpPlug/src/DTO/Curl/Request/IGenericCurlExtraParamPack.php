<?php

namespace Merce\RestClient\HttpPlug\src\DTO\Curl\Request;

interface IGenericCurlExtraParamPack
{
    public function setCURLOPTVERBOSE($CURLOPT_VERBOSE): self;
    public function setCURLOPTFAILONERROR(bool $CURLOPT_FAILONERROR): self;
    public function setCURLOPTRETURNTRANSFER(bool $CURLOPT_RETURNTRANSFER): self;
    public function setCURLOPTHEADER(bool $CURLOPT_HEADER): self;
    public static function recreateFromJson(object $jsonObject): self;
    public function get(): array;
}