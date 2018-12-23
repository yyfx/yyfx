<?php

namespace yyfx\component;

class Db
{
    const FETCH_NONE = 0;
    const FETCH_ALL = 1;
    const FETCH_ONE = 2;

    /**
     * @var Db
     */
    static private $_db=null;

    /**
     * @return Db
     */
    static public function GetDb() {
        if (self::$_db === null) {
            $ini = Application::Config('db');
            self::$_db = new self(
                $ini['host'],
                $ini['port'],
                $ini['database'],
                $ini['username'],
                $ini['password'],
                $ini['charset']
            );
        }

        return self::$_db;
    }

    /**
     * @var \PDO $pdo
     */
    private $pdo;
    function __construct($host, $port, $database, $username='', $passsword='', $charset='utf8') {
        $this->pdo = new \PDO("mysql:host={$host}; port={$port}; dbname={$database}; charset={$charset}", $username, $passsword);
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    public function commitTransaction() {
        return $this->pdo->commit();
    }

    public function rollbackTransaction() {
        return $this->pdo->rollBack();

    }

    public function inTransaction() {
        return $this->pdo->inTransaction();
    }


    /**
     * @param $sql
     * @param $fetch
     * @param array $params
     * @return null|int|array
     */
    function query($sql, $fetch ,$params=[]) {
        try {
            $stat = $this->pdo->prepare($sql);
            $execResult = @$stat->execute($params);
//        $stat->debugDumpParams();
        } catch (\Exception $e) {
            Logging::Fatal($e->getMessage());
            Logging::Trace($e->getTrace(),$e->getMessage());
        }

//        $err = error_get_last();
//        if ($err) {
//            var_dump($err);
//            Logging::Fatal($err);
//        }

        $err = $stat->errorInfo();

        if (!empty($err[1])) {
            throw new \Exception($err[2], $err[1]);
        }
        if ($err[0] != '00000') {
            throw new \Exception(error_get_last()['message'],-1);
        }


        if (!$execResult) {
            return null;
        }

        if ($fetch == self::FETCH_NONE) {
            return $stat->rowCount();
        }

        if ($fetch == self::FETCH_ONE) {
            return $stat->fetch(\PDO::FETCH_ASSOC);
        } else {
            return $stat->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    function getLastInsertId() {
        return $this->pdo->lastInsertId();
    }
}