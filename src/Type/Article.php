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

namespace ElasticOxid\Type;

use ElasticOxid\Connector\Connector;

class Content extends DefaultType
{
    /**
     * @var string
     */
    protected $index = 'content';

    /**
     * @var string
     */
    protected $type = 'oxcontent';

    /**
     * @var bool
     */
    protected $multiLang = true;

    /**
     * @var array
     */
    protected $mapping = [
        'id'        => 'oxarticles__oxid',
        'shopid'    => 'oxarticles__oxshopid',
        'parentid'  => 'oxarticles__oxparentid',
        'active'    => 'oxarticles__oxactive',
        'title'     => 'oxarticles__oxtitle',
        'price'     => 'oxarticles__oxprice',
        'shortdesc' => 'oxarticles__oxshortdesc',
        'longdesc'  => 'oxarticles__oxlongdesc',
    ];

    /**
     * Content constructor.
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param \oxBase $oxObject
     * @param $esField
     * @param $oxField
     * @param $value
     */
    protected function fillObjectField(\oxBase $oxObject, $esField, $oxField, $value)
    {
        parent::fillElasticField($oxObject, $esField, $oxField, $value);
    }

    /**
     * @param \oxBase $oxObject
     * @param $oxField
     * @param $esField
     */
    protected function fillElasticField(\oxBase $oxObject, $oxField, $esField)
    {
        $this->data[$esField] = $oxObject->{$oxField}->getRawValue();
    }
}
