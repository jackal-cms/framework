<?php

namespace Quagga\Quagga\Assets;

use App\Constracts\Assets\AssetHtmlConstract;
use Quagga\Quagga\Asset;

class Style extends Asset implements AssetHtmlConstract
{
    public function renderHtml()
    {
        parent::renderHtml();
    }
}
