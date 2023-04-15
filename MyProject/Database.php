<?php

namespace MyProject;
class Database
{
    private $connection;
    private $last_query;

    public function __construct() {
        $config = require 'config.php';
        $this->connection = new \mysqli( $config['host'], $config['username'], $config['password'], $config['database'] );
    }

    public function query($sql, $params = array()) {
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new \Exception('Database query error: ' . $this->connection->error);
        }

        if ($params) {
            $types = '';
            $values = [];
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
                $values[] = $param;
            }
            $stmt->bind_param($types, ...$values);
        }
        $result = $stmt->execute();
        if (!$result) {
            throw new \Exception('Database query error: ' . $stmt->error);
        }

        $this->last_query = $stmt;
        return $stmt;
    }

    public function getLastInsertId() {
        return $this->connection->insert_id;
    }

    public function getLastQuery() {
        return $this->last_query;
    }

    public function closeConnect()
    {
        $this->connection->close();
    }
    public function __destruct() {
//        $this->connection->close();
    }
}