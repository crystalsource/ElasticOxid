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

namespace ElasticOxid\Connector;

use Elastica\Client;
use Elastica\Response;

interface ConnectorInterface
{
    /**
     * @param array $config
     */
    public function setConfig($config);

    /**
     * @return Client
     */
    public function getClient();

    /**
     * @param $index
     * @param $type
     * @param array $data
     */
    public function persist($index, $type, array $data);

    /**
     * @param $index
     * @param $type
     * @return Response
     */
    public function matchAll($index, $type, $source = [], $size = null, $from = null);

    /**
     * @param $index
     * @param $type
     * @param array $match
     * @return Response
     */
    public function match($index, $type, $match = [], $source = [], $size = null, $from = null);

    /**
     * @param $path
     * @param $type
     * @param $query
     * @return Response
     */
    public function sendRequest($path, $type, $query);
}
