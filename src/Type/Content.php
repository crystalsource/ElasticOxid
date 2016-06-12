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
        'id'        => 'oxcontents__oxid',
        'loadident' => 'oxcontents__oxloadid',
        'shopid'    => 'oxcontents__oxshopid',
        'position'  => 'oxcontents__oxposition',
        'title'     => 'oxcontents__oxtitle',
        'content'   => 'oxcontents__oxcontent'
    ];

    /**
     * Content constructor.
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }
}
