<?php

namespace Quagga\Quagga\Assets;

use Quagga\Constracts\Assets\AssetConstract;
use Quagga\Constracts\Assets\AssetHtmlConstract;
use Quagga\Constracts\Assets\AssetScriptConstract;
use Quagga\Quagga\Asset;
use App\Traits\AssetScriptTrait;

class Script extends Asset implements AssetHtmlConstract, AssetScriptConstract
{
    use AssetScriptTrait;

    public function renderHtml()
    {
        parent::renderHtml();
    }
}
