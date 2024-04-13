<?php

namespace Quagga\Quagga;

use Quagga\Constracts\Assets\AssetExternalConstract;
use Quagga\Quagga\Assets\AssetUrl;

abstract class ExternalAsset extends Asset implements AssetExternalConstract
{
    protected AssetUrl $url;

    public function setUrl(AssetUrl $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl($supportMinUrl = null)
    {
        if (empty($this->url)) {
            return "";
        }

        if (is_null($supportMinUrl)) {
            $supportMinUrl = Env::get('COMPRESSED_ASSETS', !Env::get('DEBUG', false));
        }

        $asetUrl = $this->url->getUrl($supportMinUrl);
        if (empty($this->getVersion())) {
            return $asetUrl;
        }

        $queryJoinCharacter = '?';
        if (strpos($asetUrl, '?')) {
            $queryJoinCharacter = '&';
        }
        return $asetUrl . $queryJoinCharacter . 'v=' . $this->getVersion();
    }
}
