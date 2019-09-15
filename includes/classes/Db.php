<?php

class Db
{
    private static $_instance = null;
    private static $_lastInsertId = null;
    private $_pdo,
        $_query,
        $_error = false,
        $_results,
        $_count = 0;

    public function __construct()
    {
        $dsn = 'mysql:host=127.0.0.1;dbname=' . DATABASE_NAME;
        $user = DATABASE_USER;
        $password = DATABASE_PASSWORD;

        try {
            $this->_pdo = new PDO($dsn, $user, $password);
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new Db();
        }
        return self::$_instance;
    }

    public function query($sql, $params = array()) {
        $this->_error = false;

        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $data_type = PDO::PARAM_STR;
                    if (is_null($param) || empty($param)) {
                        $data_type = PDO::PARAM_NULL;
                    }

                    $this->_query->bindValue($x, $param, $data_type);
                    $x++;
                }
            }

            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
                self::$_lastInsertId = $this->_pdo->lastInsertId();
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }

    public function action($action, $table, $where = array()) {
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=');

            $field      = $where[0];
            $operator   = $where[1];
            $value      = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action} from {$table} where {$field} {$operator} ?";

                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }

        }

        return false;
    }

    public function get($table, $where) {
        return $this->action('select *', $table, $where);
    }

    public function delete($table, $where) {
        return $this->action('delete', $table, $where);
    }

    public function insert($table, $fields = array()) {
        $keys = array_keys($fields);
        $values = '';
        $x = 1;

        foreach ($fields as $field) {
            $values .= "?";
            if ($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }
        $sql = "insert into {$table} (`" . implode('`, `', $keys) . "`) values ({$values})";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    public function update($table, $id, $fields) {
        $set = '';
        $x = 1;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if ($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }
        $sql = "update {$table} set {$set} where id = {$id}";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    public function results() {
        return $this->_results;
    }

    public function first() {
        return $this->results()[0];
    }

    public function error() {
        return $this->_error;
    }

    public function count() {
        return $this->_count;
    }

    public static function getLastInsertId()
    {
        return self::$_lastInsertId;
    }
}