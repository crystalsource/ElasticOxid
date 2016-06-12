#!/usr/bin/php
<?php

error_reporting(-1);
ini_set("display_errors", 0);
ini_set("log_errors", 0);
ini_set("memory_limit", -1);

require_once realpath(dirname(__FILE__) . '/../../../../') . "/bootstrap.php";


class elasticOxidSync
{
    private $systems = [
        'oxcontent' => 'bElasticOxidContent'
    ];

    public function exitIfNotInClientMode()
    {
        if (!$this->isClient()) {
            exit('Cronjob only runnable with php in client-mode');
        }
    }

    /**
     * @param $message
     * @param string $prefix
     */
    public function printLine($message, $prefix = 'sync')
    {
        echo '[' . $prefix . '] ' . $message . PHP_EOL;
    }

    /**
     * @param $oxClass
     * @param $serviceClass
     */
    public function syncToElasticSearch($oxClass, $serviceClass)
    {
        $service = \oxRegistry::get('elasticoxid')->get($serviceClass);
        $oxObject = \oxNew($oxClass);

        var_dump($this->getLanguages());

        $oxList = new \oxList();
        $oxList->init($oxClass);
        $oxList->selectString('SELECT * FROM ' . $oxObject->getViewName());
        $this->printLine(" -> Export " . $oxList->count() . " objects of " . $oxClass);
        foreach ($oxList as $oxData) {
            $service->setDataFromObject($oxData);
            $this->printLine(" --> Export " . $service->getId());
            $service->persist();
        }
    }

    public function getActiveSystems()
    {
        $activeSystems = [];
        foreach ($this->systems as $oxClass => $configName) {
            if (oxRegistry::getConfig()->getConfigParam($configName)) {
                $activeSystems[$oxClass] = 'elasticoxid.oxid.object.' . strtolower($oxClass);
            }
        }
    }

    /**
     * @return bool
     */
    private function isClient()
    {
        return (php_sapi_name() == 'cli');
    }

    /**
     * @return mixed
     */
    private function getLanguages()
    {
        $aLangData['params'] = oxRegistry::getConfig()->getConfigParam('aLanguageParams');
        $aLangData['lang'] = oxRegistry::getConfig()->getConfigParam('aLanguages');
        $aLangData['urls'] = oxRegistry::getConfig()->getConfigParam('aLanguageURLs');
        $aLangData['sslUrls'] = oxRegistry::getConfig()->getConfigParam('aLanguageSSLURLs');

        // empty languages parameters array - creating new one with default values
        if (!is_array($aLangData['params'])) {
            $aLangData['params'] = $this->assignDefaultLangParams($aLangData['lang']);
        }

        return $aLangData;
    }

    /**
     * @param $aLanguages
     * @return array
     */
    private function assignDefaultLangParams($aLanguages)
    {
        $aParams = array();
        $iBaseId = 0;

        foreach (array_keys($aLanguages) as $sOxId) {
            $aParams[$sOxId]['baseId'] = $iBaseId;
            $aParams[$sOxId]['active'] = 1;
            $aParams[$sOxId]['sort'] = $iBaseId + 1;

            $iBaseId++;
        }

        return $aParams;
    }
}


$sync = new elasticOxidSync();
$sync->exitIfNotInClientMode();

foreach ($sync->getActiveSystems() as $oxClass => $service) {
    $sync->printLine("Syncronize " . $oxClass);
    $sync->syncToElasticSearch($oxClass, $service);
}

