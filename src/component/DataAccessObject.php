<?php
/**
 * Created by PhpStorm.
 * User: yaoyi
 * Date: 2018/5/24
 * Time: 下午3:39
 */

namespace yyfx\component;


class DataAccessObject
{
    private static $_pk = 'id';

    const PAGE_SIZE=20;


    public static function SetPkField($pkField) {
        self::$_pk = $pkField;
    }

    public static function Load($id) {

    }

    public static function GetList($pageStart0, $pageSize=self::PAGE_SIZE) {

    }

    public static function Create($data) {

    }

    public static function Delete($id) {

    }

    private $attributes = [];

    private function __construct()
    {
        $this->init();
    }

    /**
     * @return null
     */
    abstract public function init();

    public function save(){}

    /**
     * @return string
     */
    abstract function getTableName() ;

    /**
     * @return array
     */
    abstract function getFields() ;





}