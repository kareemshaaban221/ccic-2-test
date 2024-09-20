<?php

class DBManager {

    private PDO $pdo;
    private $type;
    private $host;
    private $dbname;
    private $username;
    private $password;

    public function __construct() {
        $configs = require_once __DIR__ . "/../config/database.php";
        $this->setParams($configs);
        $this->getConnecetion();
    }

    public function setParams(array $configs) {
        extract($configs);
        $this->type = $type ?? null;
        $this->host = $host ?? null;
        $this->dbname = $dbname ?? null;
        $this->username = $username ?? null;
        $this->password = $password ?? null;
    }

    public function getConnecetion(): PDO {
        if (empty($this->pdo)) {
            $this->pdo = new PDO ($this->getDSN(), $this->username, $this->password);
        }
        return $this->pdo;
    }

    public function query($sql, ...$args) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

    private function getDSN(): string {
        return sprintf("mysql:host=%s;dbname=%s", $this->host, $this->dbname);
    }

}
