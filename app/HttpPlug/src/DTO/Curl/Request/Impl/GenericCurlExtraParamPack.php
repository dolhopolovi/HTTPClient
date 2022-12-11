<?php

namespace Merce\RestClient\HttpPlug\src\DTO\Curl\Request\Impl;

class GenericCurlExtraParamPack
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

    public function get(): array {
        return $this->option;
    }

}