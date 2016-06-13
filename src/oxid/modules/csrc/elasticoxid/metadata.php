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

/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
    'id'          => 'csrcelasticoxid',
    'title'       => '[CrystalSource] ElasticOxid',
    'description' => array(
        'de' => 'Modul zur Integration von ElasticSearch in den OXID eShop',
        'en' => 'Module to integrate elasticsearch to the OXID eShop',
    ),
    'thumbnail'   => 'logo.png',
    'version'     => '1.0.0',
    'author'      => 'CrystalSource',
    'url'         => 'http://www.crystalsource.de',
    'email'       => 'contact@crystalsource.php',
    'extend'      => array(
        'oxcontent' => 'csrc/elasticoxid/models/csrc_elasticoxid_oxcontent'
    ),
    'files'       => array(
        'elasticoxid' => 'csrc/elasticoxid/service/elasticoxid.php'
    ),
    'blocks' => array(),
    'settings' => array(
        array('group' => 'main', 'name' => 'sElasticOxidHost', 'type' => 'str', 'value' => '127.0.0.1'),
        array('group' => 'main', 'name' => 'sElasticOxidPort', 'type' => 'str', 'value' => '9200'),
        array('group' => 'main', 'name' => 'sElasticOxidPath', 'type' => 'str', 'value' => ''),
        array('group' => 'main', 'name' => 'sElasticOxidUrl', 'type' => 'str', 'value' => ''),
        array('group' => 'main', 'name' => 'sElasticOxidProxy', 'type' => 'str', 'value' => ''),
        array('group' => 'main', 'name' => 'sElasticOxidTransport', 'type' => 'str', 'value' => ''),
        array('group' => 'main', 'name' => 'sElasticOxidPersistent', 'type' => 'str', 'value' => ''),
        array('group' => 'main', 'name' => 'sElasticOxidTimeout', 'type' => 'str', 'value' => ''),
        array('group' => 'main', 'name' => 'sElasticOxidRoundRobin', 'type' => 'str', 'value' => ''),
        array('group' => 'main', 'name' => 'sElasticOxidLog', 'type' => 'str', 'value' => ''),
        array('group' => 'main', 'name' => 'sElasticOxidRetryOnConflict', 'type' => 'str', 'value' => ''),
        array('group' => 'systems', 'name' => 'bElasticOxidArticle', 'type' => 'bool', 'value' => '1'),
        array('group' => 'systems', 'name' => 'bElasticOxidContent', 'type' => 'bool', 'value' => '1')
    ),
    'events' => array(),
);