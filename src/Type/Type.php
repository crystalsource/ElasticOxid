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
     * @param \oxBase $oxObject
     * @param $ident
     * @param int $lang
     * @return mixed
     */
    public function loadOne(\oxBase $oxObject, $ident, $lang = 0);

    /**
     * @param \oxBase $oxObject
     * @param int $lang
     * @param array $match
     * @return mixed
     */
    public function loadOneFromMatch(\oxBase $oxObject, $lang = 0, $match = []);

    /**
     * @param \oxList $oxList
     * @param array $query
     * @param int $lang
     * @param array $sort
     * @param null $size
     * @param null $from
     * @return mixed
     */
    public function loadList(\oxList $oxList, $query = [], $lang = 0, $sort = [], $size = null, $from = null);

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

    /**
     * @param \oxBase $oxObject
     */
    public function setDataFromObject(\oxBase $oxObject);

    public function getType();

    /**
     * @return bool
     */
    public function isMultiLang();
    
    public function persist();
}
