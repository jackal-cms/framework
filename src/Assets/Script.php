<?php

namespace Jackal\Jackal\Assets;

use App\Constracts\Assets\AssetConstract;
use App\Constracts\Assets\AssetHtmlConstract;
use App\Constracts\Assets\AssetScriptConstract;
use Jackal\Jackal\Asset;
use App\Traits\AssetScriptTrait;

class Script extends Asset implements AssetHtmlConstract, AssetScriptConstract
{
    use AssetScriptTrait;

    public function renderHtml()
    {
        parent::renderHtml();
    }
}
