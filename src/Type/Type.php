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

interface Type
{
    /**
     * @param oxBase $oxObject
     * @param $ident
     * @param array $query
     */
    public function loadOne(oxBase $oxObject, $ident, $query = []);

    /**
     * @param oxList $oxList
     * @param array $query
     * @param array $sort
     * @param null $size
     * @param null $from
     * @return mixed
     */
    public function loadList(oxList $oxList, $query = [], $sort = [], $size = null, $from = null);

    /**
     * @return array
     */
    public function getMapping();

    /**
     * @return array
     */
    public function getData();

    /**
     * @param array $data
     */
    public function setData(array $data);
    
    public function persist();
}
