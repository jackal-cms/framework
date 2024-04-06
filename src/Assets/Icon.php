<?php

namespace Quagga\Quagga\Assets;

use App\Constracts\Assets\AssetIconConstract;
use Quagga\Quagga\Asset;

class Icon extends Asset implements AssetIconConstract
{
    public function renderHtml()
    {
        parent::renderHtml();
    }
}
