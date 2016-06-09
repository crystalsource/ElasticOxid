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
use Elastica\Document;
use Elastica\Request;
use Elastica\Response;

class Connector implements ConnectorInterface
{
    /**
     * @var Client
     */
    private $client = null;

    /**
     * @var array
     */
    private $config;

    /**
     * Connector constructor.
     * @param array $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        if ($this->client === null) {
            $this->client = new Client($this->config);
        }
        return $this->client;
    }

    /**
     * @param $index
     * @param $type
     * @param array $data
     */
    public function persist($index, $type, array $data)
    {
        $elasticIndex = $this->client->getIndex($index);
        $elasticType = $elasticIndex->getType($type);
        $elasticId = $data['id'];

        $elaticDocument = new Document($elasticId, $data);
        $elasticType->addDocument($elaticDocument);
        $elasticType->getIndex()->refresh();
    }

    /**
     * @param $index
     * @param $type
     * @return Response
     */
    public function matchAll($index, $type, $source = [], $size = null, $from = null)
    {
        $customQuery = [
            'match_all' => []
        ];

        $query = $this->getSeachQuery($customQuery, $source, $size, $from);
        return $this->executeSearchQuery($index, $type, $query);
    }

    /**
     * @param $index
     * @param $type
     * @param array $match
     * @return Response
     */
    public function match($index, $type, $match = [], $source = [], $size = -1, $from = 0)
    {
        $customQuery = [
            'match' => $match
        ];

        $query = $this->getSeachQuery($customQuery, $source, $size, $from);
        return $this->executeSearchQuery($index, $type, $query);
    }

    /**
     * @param $path
     * @param $type
     * @param $query
     * @return Response
     */
    public function sendRequest($path, $type, $query)
    {
        return $this->client->request($path, $type, $query);
    }

    /**
     * @param array $customQuery
     * @param $source
     * @param $size
     * @param $from
     * @return array
     */
    private function getSeachQuery($customQuery, $source = [], $size = null, $from = null)
    {
        $query = [
            'query' => $customQuery
        ];
        if (is_array($source)) {
            $query['source'] = $source;
        }
        if ($size !== null) {
            $query['size'] = $size;
        }
        if ($from !== null) {
            $query['from'] = $from;
            return $query;
        }
        return $query;
    }

    /**
     * @param $index
     * @param $type
     * @param $query
     * @return Response
     */
    private function executeSearchQuery($index, $type, $query)
    {
        $elasticIndex = $this->client->getIndex($index);
        $elasticType = $elasticIndex->getType($type);

        $path = $elasticIndex->getName() . '/' . $elasticType->getName() . '/_search';
        return $this->sendRequest($path, Request::GET, $query);
    }

}
