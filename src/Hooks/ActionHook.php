<?php

namespace Quagga\Quagga\Hooks;

use Quagga\Quagga\Hook;

class ActionHook extends Hook
{
    public static function create($fn, $priority = 10, $paramsQuantity = 1): ActionHook
    {
        $hook = new ActionHook();

        $hook->setCallable($fn);
        $hook->setPriority($priority);
        $hook->setParamsQuantity($paramsQuantity);

        return $hook;
    }
}
