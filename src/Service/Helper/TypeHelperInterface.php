<?php

namespace ElasticOxid\Service\Helper;

interface TypeHelperInterface
{
    /**
     * @param \oxBase $oxObject
     * @param $esField
     * @param array $oxField
     * @param array $esResponseData
     * @param int $language
     * @return mixed
     */
    public function fillObject(\oxBase $oxObject, $esField, array $oxField, array $esResponseData, $language = 0);

    /**
     * @param \oxBase $oxObject
     * @param array $source
     * @param $field
     * @param int $language
     * @return mixed
     */
    public function getElasticValue(\oxBase $oxObject, array $source, $field, $language = 0);
}