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
            $this->elasticOxidLoader->get('elasticoxid.connector')->setConfig($this->getElasticOxidConfig());
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
            'host'            => $this->getConfigParamOrNull('sElasticOxidHost'),
            'port'            => $this->getConfigParamOrNull('sElasticOxidPort'),
            'path'            => $this->getConfigParamOrNull('sElasticOxidPath'),
            'url'             => $this->getConfigParamOrNull('sElasticOxidUrl'),
            'proxy'           => $this->getConfigParamOrNull('sElasticOxidProxy'),
            'transport'       => $this->getConfigParamOrNull('sElasticOxidTransport'),
            'persistent'      => $this->getConfigParamOrNull('sElasticOxidPersistent'),
            'timeout'         => $this->getConfigParamOrNull('sElasticOxidTimeout'),
            'roundRobin'      => $this->getConfigParamOrNull('sElasticOxidRoundRobin'),
            'log'             => $this->getConfigParamOrNull('sElasticOxidLog'),
            'retryOnConflict' => $this->getConfigParamOrNull('sElasticOxidRetryOnConflict')
        ];
        return $config;
    }

    protected function getConfigParamOrNull($configName)
    {
        return oxRegistry::getConfig()->getConfigParam($configName) ? oxRegistry::getConfig()->getConfigParam(
            'sElasticOxidHost'
        ) : null;
    }
}