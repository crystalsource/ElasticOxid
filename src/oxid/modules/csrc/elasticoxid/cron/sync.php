#!/usr/bin/php
<?php

error_reporting(E_ERROR);
ini_set("display_errors", 1);
ini_set("log_errors", 0);
ini_set("memory_limit", -1);

require_once realpath(dirname(__FILE__) . '/../../../../') . "/bootstrap.php";


class elasticOxidSync
{
    private $systems = [
        'oxarticle' => 'bElasticOxidArticle',
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
        $service = \oxRegistry::get('elasticoxid')->loader()->get($serviceClass);
        $oxObject = \oxNew($oxClass);

        if ($service->isMultiLang()) {
            foreach ($this->getLanguages()['params'] as $lang) {
                if (!$lang['active']) {
                    continue;
                }
                oxRegistry::getLang()->setBaseLanguage($lang['baseId']);
                $service->setLanguage($lang['baseId']);
                $oxObject->setLanguage($lang['baseId']);
                $this->printLine(" -> Expert Lang " . $lang['baseId']);

                $this->syncOxObject($oxClass, $oxObject, $service);
            }
        } else {
            oxRegistry::getLang()->setBaseLanguage(0);
            $service->setLanguage(0);
            $oxObject->setLanguage(0);
            $this->syncOxObject($oxClass, $oxObject, $service);
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
        return $activeSystems;
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

    /**
     * @param $oxClass
     * @param $oxObject
     * @param $service
     */
    private function syncOxObject($oxClass, $oxObject, $service)
    {
        $oxList = new \oxList();
        $oxList->init($oxClass);
        $oxList->selectString('SELECT * FROM ' . $oxObject->getViewName());
        $this->printLine(" -> Export " . $oxList->count() . " objects of " . $oxClass);
        foreach ($oxList as $oxData) {
            $service->setDataFromObject($oxData);
            $this->printLine(" --> Export " . $service->getId(), $oxClass);
            $service->persist();
        }
    }
}


$sync = new elasticOxidSync();
$sync->printLine("Start sync");
$sync->exitIfNotInClientMode();

foreach ($sync->getActiveSystems() as $oxClass => $service) {
    $sync->printLine("Syncronize " . $oxClass);
    $sync->syncToElasticSearch($oxClass, $service);
}


