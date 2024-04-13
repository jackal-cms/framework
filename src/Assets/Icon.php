<?php

namespace Quagga\Quagga\Assets;

use Quagga\Contracts\Assets\AssetIconConstract;
use Quagga\Quagga\Asset;

class Icon extends Asset implements AssetIconConstract
{
    public function renderHtml()
    {
        parent::renderHtml();
    }
}
