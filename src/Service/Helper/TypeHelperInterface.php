<?php

namespace ElasticOxid\Service\Helper;

interface TypeHelperInterface
{
    /**
     * @param \oxBase $oxObject
     * @param $esField
     * @param array $oxField
     * @param array $esResponseData
     * @return mixed
     */
    public function fillObject(\oxBase $oxObject, $esField, array $oxField, array $esResponseData);

    /**
     * @param \oxBase $oxObject
     * @param array $source
     * @param $field
     * @return mixed
     */
    public function fillElastic(\oxBase $oxObject, array $source, $field);
}