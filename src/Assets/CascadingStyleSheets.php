<?php

namespace Jackal\Jackal\Assets;

use Jackal\Jackal\Env;
use Jackal\Jackal\ExternalAsset;
use Jackal\Jackal\HookManager;

class CascadingStyleSheets extends ExternalAsset
{
    public function renderHtml()
    {
        echo HookManager::applyFilters(
            'print_css_html',
            sprintf(
                '<link id="%2$s-css" rel="stylesheet" href="%1$s" type="text/css">',
                HookManager::applyFilters("asset_css_url", $this->getUrl(
                    Env::get("COMPRESSED_ASSETS", Env::get("DEBUG") === false)
                ), $this->id, $this),
                $this->id
            ),
            $this->getId(),
            $this
        );

        parent::renderHtml();
    }
}
