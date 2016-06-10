<?php
/**
 * This Software is the property of CrystalSource and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @link      http://www.crystalsource.de
 * @copyright (C) CrystalSource 2016
 */

namespace ElasticOxid\Service;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Loader extends ContainerBuilder
{
    /**
     * Loader constructor.
     * @param ParameterBagInterface|null $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag = null)
    {
        $this->parameterBag = $parameterBag ?: new ParameterBag();
        $this->loadYamlFile(__DIR__ . '/Services.yaml');
    }

    /**
     * @param $file
     */
    private function loadYamlFile($file)
    {
        $loader = new YamlFileLoader($this, new FileLocator(dirname($file)));
        $loader->load(basename($file));
    }
}
