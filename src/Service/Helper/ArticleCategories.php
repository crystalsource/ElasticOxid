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
     * @var string
     */
    private $seperateSign = '|';

    /**
     * @param \oxBase $oxObject
     * @param $esField
     * @param array $oxField
     * @param array $esResponseData
     * @param int $language
     */
    public function fillObject(\oxBase $oxObject, $esField, array $oxField, array $esResponseData, $language = 0)
    {
        // TODO: Implement fillObject() method.
    }

    /**
     * @param \oxBase $oxObject
     * @param array $source
     * @param $field
     * @param int $language
     */
    public function fillElastic(\oxBase $oxObject, array $source, $field, $language = 0)
    {
        $dbConn = $this->getOxidDb();
        $catIds = $dbConn->getCol(
            'SELECT oxcatnid FROM oxobject2category WHERE oxobjectid = ?', array($oxObject->getId())
        );
        $categoryListValue = $this->getCategoryListValue($catIds, $language);
        var_dump($categoryListValue);
    }

    /**
     * @param array $catIds
     * @param int $language
     * @return string
     */
    private function getCategoryListValue(array $catIds, $language = 0)
    {
        $dbConn = $this->getOxidDb();
        $value = $this->seperateSign;
        $langField = $language == 0 ? 'OXTITLE' : 'OXTITLE_' . $language;
        foreach ($catIds as $catId) {
            $categoryInfos = $dbConn->getRow(
                'SELECT * FROM oxcategories WHERE oxid = ?',
                [
                    $catId
                ]
            );
            $value .= $this->getCategoryListValue([ $categoryInfos['oxparentid'] ]) . $this->seperateSign;
            $value .= $categoryInfos[$langField] . $this->seperateSign;
        }
        return $value;
    }

    /**
     * @return \oxLagecyDb
     */
    private function getOxidDb()
    {
        return \oxDb::getDb();
    }


}
