<?php

class elasticoxid
{
    /**
     * @var \ElasticOxid\Connector\Connector
     */
    private $connector;

    /**
     * @var \ElasticOxid\Service\Loader
     */
    private $elasticOxidLoader = null;

    /**
     * @return \ElasticOxid\Service\Loader
     */
    public function loader()
    {
        if ($this->elasticOxidLoader === null) {
            $this->elasticOxidLoader = $this->getNewElasticOxidLoader();
        }
        return $this->elasticOxidLoader;
    }

    /**
     * @return \ElasticOxid\Service\Loader
     */
    public function getNewElasticOxidLoader()
    {
        return new \ElasticOxid\Service\Loader();
    }

    /**
     * @return array
     */
    protected function getElasticOxidConfig()
    {
        $config = [
            'host'            => oxRegistry::getConfig()->getConfigParam('sElasticOxidHost'),
            'port'            => oxRegistry::getConfig()->getConfigParam('sElasticOxidPort'),
            'path'            => oxRegistry::getConfig()->getConfigParam('sElasticOxidPath'),
            'url'             => oxRegistry::getConfig()->getConfigParam('sElasticOxidUrl'),
            'proxy'           => oxRegistry::getConfig()->getConfigParam('sElasticOxidProxy'),
            'transport'       => oxRegistry::getConfig()->getConfigParam('sElasticOxidTransport'),
            'persistent'      => oxRegistry::getConfig()->getConfigParam('sElasticOxidPersistent'),
            'timeout'         => oxRegistry::getConfig()->getConfigParam('sElasticOxidTimeout'),
            'connections'     => oxRegistry::getConfig()->getConfigParam('sElasticOxidConnection'),
            'roundRobin'      => oxRegistry::getConfig()->getConfigParam('sElasticOxidRoundRobin'),
            'log'             => oxRegistry::getConfig()->getConfigParam('sElasticOxidLog'),
            'retryOnConflict' => oxRegistry::getConfig()->getConfigParam('sElasticOxidRetryOnConflict')
        ];
        return $config;
    }
}