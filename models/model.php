<?php

class Model
{
    protected $table;
    public $collumns;
    public $collumnInserts;
    private $db;
    private $pdo;    

    public function __construct()
    {
        require_once 'connect.php';
        $this->db = new DB_Connect();
        $this->pdo = $this->db->connect();
        $this->collumns = $this->getTableColumns();
        $this->collumnInserts = $this->getTableColumnInsert();
    }

    public function getTableColumns()
    {
      $stmt = $this->pdo->prepare("DESCRIBE {$this->table}");
      $collumns = [];
      $stmt->execute();
      foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $row) {
        $collumns[] = $row;
      }
      unset($collumns[0]);

      return $collumns;
    }

    public function getTableColumnInsert()
    {
      $inserts = array_map(function($o){
        return ":{$o}";
      }, $this->collumns);

      return implode(',', $inserts);
    }

    public function all()
    {
        $list = [];
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} ORDER BY id DESC");
        $stmt->execute();

        foreach ($stmt->fetchAll() as $item) {
            $el = [];

            $el['id'] = $item['id'];
            foreach ($this->collumns as $collumn) {
              $el[$collumn] = $item[$collumn];
            }

            $list[] = $el;
        }
        return $list;
    }
    public function create($params)
    {
        $tableInsert = implode(',', $this->collumns);
        $this->pdo->exec("set names utf8mb4");
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table}($tableInsert)
                                     VALUES({$this->collumnInserts})");
        $date = new DateTime("now");
        $params['created_at'] = $date->format("Y-m-d");
        $result = $stmt->execute($params);

        return $result;
    }

    public function delete($conditions)
    {
        $query = '';
        foreach ($conditions as $key => $value) {
          $query .= " AND $key = $value ";
        }

        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE 1 = 1 $query");
        $result = $stmt->execute();

        return $result;
    }

    public function exist($conditions)
    {
        $searchColumns = array_keys($conditions);
        $query = "";
        foreach ($searchColumns as $searchColumn) {
          $query .= " AND $searchColumn = :$searchColumn ";
        }
        $stmt = $this->pdo->prepare("SELECT *
                          FROM {$this->table}
                          WHERE 1 = 1 $query");

        $result = $stmt->execute($conditions);

        foreach ($stmt as $row) {
            return true;
        }
        return false;
    }
}
