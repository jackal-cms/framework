<?php

declare(strict_types=1);

namespace Jackal\Jackal\Settings;

interface SettingsInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key = '', $defaultValue = null);
}
