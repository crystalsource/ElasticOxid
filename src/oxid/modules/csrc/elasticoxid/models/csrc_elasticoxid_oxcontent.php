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
        startProfile('elasticoxid::' . __CLASS__ . '::esLoad');
        if ($lang === null) {
            $lang = oxRegistry::getLang()->getBaseLanguage();
        }
        $elasticOxidContent = $this->getElasticOxidContent();
        $result = $elasticOxidContent->loadOne($this, $sOxid, $lang);
        stopProfile('elasticoxid::' . __CLASS__ . '::esLoad');
        return $result;
    }

    /**
     * @param $sLoadId
     * @return mixed
     */
    public function esLoadByIdent($sLoadId, $lang = null)
    {
        startProfile('elasticoxid::' . __CLASS__ . '::esLoadByIdent');
        if ($lang === null) {
            $lang = oxRegistry::getLang()->getBaseLanguage();
        }
        $elasticOxidContent = $this->getElasticOxidContent();
        $result = $elasticOxidContent->loadOneFromMatch($this, [ "loadident" => $sLoadId ], $lang);
        stopProfile('elasticoxid::' . __CLASS__ . '::esLoadByIdent');
        return $result;
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