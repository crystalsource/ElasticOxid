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
     * @param $sLoadId
     * @return mixed
     */
    public function esLoadByIdent($sLoadId)
    {
        $elasticOxidContent = $this->getElasticOxidContent();
        return $elasticOxidContent->loadOne($this, $sLoadId);
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