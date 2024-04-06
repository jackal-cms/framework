<?php

namespace Quagga\Quagga\Hooks;

use Quagga\Quagga\Hook;

class FilterHook extends Hook
{
    public static function create($fn, $priority = 10, $paramsQuantity = 1): FilterHook
    {
        $hook = new FilterHook();

        $hook->setCallable($fn);
        $hook->setPriority($priority);
        $hook->setParamsQuantity($paramsQuantity);

        return $hook;
    }
}
