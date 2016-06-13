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
     * @var bool
     */
    protected $multiLang = false;

    /**
     * @var int
     */
    protected $language = 0;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->data['id'];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type . ($this->multiLang ? '_' . $this->language : '');
    }

    /**
     * @param \oxBase $oxObject
     * @param array $match
     * @param int $lang
     * @return bool
     */
    public function loadOneFromMatch(\oxBase $oxObject, $match = [], $lang = 0)
    {
        $this->setLanguage($lang);
        $elasticResponse = $this->connector->match($this->index, $this->getType(), $match);

        $elasticResponseArray = $elasticResponse->getData();
        if ($elasticResponseArray['hits']['total'] < 1) {
            return false;
        }

        $objectFields = $elasticResponseArray['hits']['hits'][0]['_source'];
        foreach ($this->getMapping() as $field => $target) {
            if (is_string($target)) {
                $value = $objectFields[$field];
                $this->fillObjectField($oxObject, $field, $target, $value);
            }
            elseif (is_array($target)) {
                $this->fillObjectFieldFromCustomFunction($oxObject, $field, $target, $objectFields);
            }
        }
        return $objectFields['id'];
    }

    /**
     * @param \oxBase $oxObject
     * @param $ident
     * @param int $lang
     * @return bool
     */
    public function loadOne(\oxBase $oxObject, $ident, $lang = 0)
    {
        return $this->loadOneFromMatch($oxObject, ['id' => $ident], $lang);
    }

    /**
     * @param \oxList $oxList
     * @param array $query
     * @param int $lang
     * @param array $sort
     * @param null $size
     * @param null $from
     */
    public function loadList(\oxList $oxList, $query = [], $lang = 0, $sort = [], $size = null, $from = null)
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
     * @param array $mapping
     */
    public function setMapping($mapping)
    {
        $this->mapping = $mapping;
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
     * @return int
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param int $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return boolean
     */
    public function isMultiLang()
    {
        return $this->multiLang;
    }

    /**
     * @param \oxBase $oxObject
     */
    public function setDataFromObject(\oxBase $oxObject)
    {
        foreach ($this->getMapping() as $field => $source) {
            if (is_string($source)) {
                $this->fillElasticField($oxObject, $source, $field);
            }
            elseif (is_array($source)) {
                $this->fillElasticFieldFromCustomFunction($oxObject, $source, $field);
            }
        }
    }

    /**
     *
     */
    public function persist()
    {
        $this->connector->persist($this->index, $this->getType(), $this->data);
    }

    /**
     * @param \oxBase $oxObject
     * @param $esField
     * @param $oxField
     * @param $value
     */
    protected function fillObjectField(\oxBase $oxObject, $esField, $oxField, $value)
    {
        if ($esField == 'id') {
            $oxObject->setId($value);
        }
        $oxObject->{$oxField} = new \oxField($value, \oxField::T_RAW);
    }

    protected function fillObjectFieldFromCustomFunction(
        \oxBase $oxObject, $esField, array $oxField, array $esResponseData
    ) {
        if ($oxField['type'] == 'service') {
            $serviceClass = $oxField['class'];
            $service = $this->connector->get($serviceClass);
            $service->fillObject($oxObject, $esField, $oxField, $esResponseData);
        }
    }

    /**
     * @param \oxBase $oxObject
     * @param $oxField
     * @param $esField
     */
    protected function fillElasticField(\oxBase $oxObject, $oxField, $esField)
    {
        if ($oxObject->{$oxField} instanceof \oxField) {
            $this->data[$esField] = $oxObject->{$oxField}->getRawValue();
        }
    }

    /**
     * @param \oxBase $oxObject
     * @param array $source
     * @param $field
     */
    protected function fillElasticFieldFromCustomFunction(\oxBase $oxObject, array $source, $field)
    {
        if ($source['type'] == 'service') {
            $serviceClass = $source['class'];
            $service = $this->connector->get($serviceClass);
            $service->fillElastic($oxObject, $source, $field);
        }
    }
}
