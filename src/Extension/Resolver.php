<?php

namespace Quagga\Quagga\Extension;

use Quagga\Contracts\ExtensionConstract;
use Quagga\Quagga\ExtensionManager;
use MJS\TopSort\Implementations\StringSort;

class Resolver
{
    protected $app;
    protected $container;


    /**
     * @var \Quagga\Quagga\Extension\ExtensionInfo[]
     */
    protected $extensions = [];
    protected $resolvedExtensions = [];

    protected $cmsVersion;

    public function __construct(&$app, &$container, &$extensions = null)
    {
        $this->app       = $app;
        $this->container = $container;

        if (is_null($extensions) || !is_array($extensions)) {
            $extensions = ExtensionManager::getAllExtensions();
        }
        $this->extensions = $extensions;

        $this->cmsVersion = $container->get('version');
    }

    protected function createResolver(): StringSort
    {
        $resolver = new StringSort();

        foreach ($this->extensions as $extensionName => $extensionInfo) {
            $resolver->add($extensionName, array_keys($extensionInfo->getDeps()));
        }
        return $resolver;
    }


    protected function resolveExtensions($extensions)
    {
        $resolver  = $this->createResolver();

        $resolvedExtensions = $resolver->sort();
        usort($extensions, function ($a, $b) use ($resolvedExtensions) {
            $aIndex = intval(array_search($a->getExtensionName(), $resolvedExtensions));
            $bIndex = intval(array_search($b->getExtensionName(), $resolvedExtensions));

            return $aIndex - $bIndex;
        });



        return $extensions;
    }

    protected function getActiveExtensions()
    {
        $extensions = [];
        foreach ($this->extensions as $extensionInfo) {
            /**
             * @var \Quagga\Quagga\Extension
             */
            $extension = $extensionInfo->getExtension();
            if ($extension instanceof ExtensionConstract) {
                $extension->setApp($this->app);
                $extension->setContainer($this->container);
            }
            $extensions[$extensionInfo->getExtensionName()] = $extension;
        }
        return $extensions;
    }

    /**
     * Resolve the extensions
     *
     * @return \Quagga\Quagga\Extension[]
     */
    public function resolve(): array
    {
        return $this->resolveExtensions($this->getActiveExtensions());
    }
}
