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

class DefaultType implements Type
{
    /**
     * @var Connector
     */
    protected $connector;

    /**
     * id is important
     * @var array
     */
    protected $mapping = [
        'id' => 'oxidtable__oxid'
    ];

    /**
     * @var string
     */
    protected $index = '';

    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param oxBase $oxObject
     * @param $ident
     * @param array $query
     */
    public function loadOne(oxBase $oxObject, $ident, $query = [])
    {
        // TODO: Implement loadOne() method.
    }

    /**
     * @param oxList $oxList
     * @param array $query
     * @param array $sort
     * @param null $size
     * @param null $from
     * @return mixed
     */
    public function loadList(oxList $oxList, $query = [], $sort = [], $size = null, $from = null)
    {
        // TODO: Implement loadList() method.
    }

    /**
     * @return array
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     *
     */
    public function persist()
    {
        $this->connector->persist($this->index, $this->type, $this->data);
    }
}
