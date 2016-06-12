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

    public function loadInLang($iLanguage, $sOxid)
    {
        if ($this->isActiveForContent()) {
            $this->setLanguage($iLanguage);
            return $this->esLoad($sOxid);
        }
        return parent::loadByIdent($sOxid);
    }

    /**
     * @param $sLoadId
     * @return mixed
     */
    public function esLoadByIdent($sLoadId)
    {
        try {
            $elasticOxidContent = $this->getElasticOxidContent();
            return $elasticOxidContent->loadOne($this, $sLoadId);
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