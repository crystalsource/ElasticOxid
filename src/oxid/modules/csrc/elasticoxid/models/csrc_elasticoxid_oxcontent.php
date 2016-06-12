<?php

/**
 * OXID extension: csrc_elasticoxid_oxcontent
 */
class csrc_elasticoxid_oxcontent extends csrc_elasticoxid_oxcontent_parent
{
    /**
     * @param $sLoadId
     * @return mixed
     */
    public function loadByIdent($sLoadId)
    {
        if ($this->isActiveForContent()) {
            return $this->esLoadByIdent($sLoadId);
        }
        return parent::loadByIdent($sLoadId);
    }

    /**
     * @param $iLanguage
     * @param $sOxid
     * @return mixed
     */
    public function loadInLang($iLanguage, $sOxid)
    {
        if ($this->isActiveForContent()) {
            $this->setLanguage($iLanguage);
            return $this->esLoad($sOxid, $iLanguage);
        }
        return parent::loadInLang($iLanguage, $sOxid);
    }

    /**
     * @param $sOxid
     * @return mixed
     */
    public function load($sOxid)
    {
        if ($this->isActiveForContent()) {
            return $this->esLoad($sOxid);
        }
        return parent::load($sOxid);
    }

    /**
     * @param $sOxid
     * @return mixed
     */
    public function esLoad($sOxid, $lang = null)
    {
        try {
            if ($lang === null) {
                $lang = oxRegistry::getLang()->getBaseLanguage();
            }
            $elasticOxidContent = $this->getElasticOxidContent();
            return $elasticOxidContent->loadOne($this, $sOxid, $lang);
        } catch (Exception $e) {
            oxRegistry::getUtils()->writeToLog($e->getMessage() . PHP_EOL . PHP_EOL, 'elasticoxid.txt');
            return parent::loadByIdent($sOxid);
        }
    }

    /**
     * @param $sLoadId
     * @return mixed
     */
    public function esLoadByIdent($sLoadId, $lang = null)
    {
        try {
            if ($lang === null) {
                $lang = oxRegistry::getLang()->getBaseLanguage();
            }
            $elasticOxidContent = $this->getElasticOxidContent();
            return $elasticOxidContent->loadOneFromMatch($this, [ "loadident" => $sLoadId ], $lang);
        } catch (Exception $e) {
            oxRegistry::getUtils()->writeToLog($e->getMessage() . PHP_EOL . PHP_EOL, 'elasticoxid.txt');
            return parent::loadByIdent($sLoadId);
        }
    }

    /**
     * @return bool
     */
    protected function isActiveForContent()
    {
        return (bool)oxRegistry::getConfig()->getConfigParam('bElasticOxidContent');
    }

    /**
     * @return mixed
     */
    protected function getElasticOxidContent()
    {
        $elasticOxidContent = oxRegistry::get('elasticoxid')->loader()->get('elasticoxid.oxid.object.oxcontent');
        return $elasticOxidContent;
    }
}