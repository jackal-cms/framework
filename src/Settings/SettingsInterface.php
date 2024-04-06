<?php

declare(strict_types=1);

namespace Quagga\Quagga\Settings;

interface SettingsInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key = '', $defaultValue = null);
}
