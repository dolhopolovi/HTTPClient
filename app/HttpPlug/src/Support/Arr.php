<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Support;

use function is_array;

class Arr
{

    /**
     * @param  array  $mapList
     * @return array
     */
    public static function flatMap(array $mapList): array
    {

        $result = [];

        foreach ($mapList as $key => $values) {
            if (!is_array($values)) {
                $result[] = "$key: $values";
            } else {
                foreach ($values as $value) {
                    $result[] = "$key: $value";
                }
            }
        }

        return $result;
    }
}