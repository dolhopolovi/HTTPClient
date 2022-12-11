<?php

namespace Merce\RestClient\HttpPlug\src\DTO\Curl\Request\Impl;

use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\IGenericCurlExtraParamPack;

class GenericCurlExtraParamPack implements IGenericCurlExtraParamPack
{

    private array $option = [];

    public function setCURLOPTVERBOSE(bool $CURLOPT_VERBOSE): self
    {

        $this->option[CURLOPT_VERBOSE] = $CURLOPT_VERBOSE;
        return $this;
    }

    public function setCURLOPTFAILONERROR(bool $CURLOPT_FAILONERROR): self
    {

        $this->option[CURLOPT_FAILONERROR] = $CURLOPT_FAILONERROR;
        return $this;
    }

    public function setCURLOPTRETURNTRANSFER(bool $CURLOPT_RETURNTRANSFER): self
    {

        $this->option[CURLOPT_RETURNTRANSFER] = $CURLOPT_RETURNTRANSFER;
        return $this;
    }

    public function setCURLOPTHEADER(bool $CURLOPT_HEADER): self
    {

        $this->option[CURLOPT_HEADER] = $CURLOPT_HEADER;
        return $this;
    }

    public static function recreateFromJson(object $jsonObject): self {

        $paramPack = new self();

        foreach ($jsonObject as $key => $value) {
            $paramPack->$key((bool)$value);
        }

        return $paramPack;
    }

    public function get(): array {
        return $this->option;
    }
}