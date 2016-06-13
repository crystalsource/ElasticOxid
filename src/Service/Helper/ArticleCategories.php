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

namespace ElasticOxid\Service\Helper;

class ArticleCategories implements TypeHelperInterface
{
    /**
     * @param \oxBase $oxObject
     * @param $esField
     * @param array $oxField
     * @param array $esResponseData
     * @return mixed
     */
    public function fillObject(\oxBase $oxObject, $esField, array $oxField, array $esResponseData)
    {
        // TODO: Implement fillObject() method.
    }

    /**
     * @param \oxBase $oxObject
     * @param array $source
     * @param $field
     * @return mixed
     */
    public function fillElastic(\oxBase $oxObject, array $source, $field)
    {
        $dbConn = $this->getOxidDb();
        $catIds = $dbConn->getCol(
            'SELECT oxcatnid FROM oxobject2category WHERE oxobjectid = ?', array($oxObject->getId())
        );
        var_dump($catIds);
    }

    private function getOxidDb()
    {
        return \oxDb::getDb();
    }


}
