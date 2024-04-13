<?php

namespace Quagga\Quagga\Assets;

use Quagga\Contracts\Assets\AssetHtmlConstract;
use Quagga\Quagga\Asset;

class Style extends Asset implements AssetHtmlConstract
{
    public function renderHtml()
    {
        parent::renderHtml();
    }
}
