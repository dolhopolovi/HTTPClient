<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\DTO\Curl\Request;

interface IGenericCurlExtraParamPack
{

    public static function recreateFromJson(object $jsonObject): self;

    public function setCURLOPTVERBOSE(bool $CURLOPT_VERBOSE): self;

    public function setCURLOPTFAILONERROR(bool $CURLOPT_FAILONERROR): self;

    public function setCURLOPTRETURNTRANSFER(bool $CURLOPT_RETURNTRANSFER): self;

    public function setCURLOPTHEADER(bool $CURLOPT_HEADER): self;

    public function get(): array;
}