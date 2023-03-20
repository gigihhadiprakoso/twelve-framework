<?php

namespace Classes;

class Database {

    private $conn;

    public function __construct(){
        global $config;
        $this->conn = new \mysqli($config['database']['hostname'].":".$config['database']['port'], $config['database']['username'], $config['database']['password'], $config['database']['dbname']);
    }

    public function getRows($sql){
        return $this->execQuery($sql);
    }

    public function getRow($sql){
        return $this->execQuery($sql . " limit 1")[0];
    }

    public function getCombo($sql){
        $data = $this->execQuery($sql);
        $rows = array();
        foreach($data as $d){
            $rows[current($d)] = next($d);
        }

        return $rows;
    }

    public function insert($table, $data=array()){

        $insert = "INSERT INTO $table (" . implode(",",array_keys($data)) . ") ";
        $values = "VALUES ('" . implode("','",array_values($data)) . "')";
        
        $sql = $insert.$values;
        $this->execQuery($sql);
    }

    public function update($table, $data=array(), $where=array()){
        $update = "UPDATE $table ";

        $set = "SET ";
        foreach($data as $col => $val){
            $set .= trim($col)."='".$val."', ";
        }
        $set = rtrim($set,", ");
        $set .= " ";

        $where_clause = "WHERE ";
        foreach($where as $col => $val){
            $where_clause .= $col."='".$val."' and ";
        }
        $where_clause = rtrim($where_clause, " and ");
        
        $sql = $update.$set.$where_clause." RETURNING id";
        $this->execQuery($sql);
    }

    public function delete($table, $where=array()){
        $delete = "DELETE FROM $table ";

        $where_clause = "WHERE ";
        foreach($where as $col => $val){
            $where_clause .= $col."='".$val."' AND ";
        }
        $where_clause = rtrim($where_clause, " AND ");

        $sql = $delete.$where_clause;
        $this->execQuery($sql);
    }

    public function execQuery($sql){
        $rows = array();
        $result = $this->conn->query($sql);
        if ($result) {
            if($result->num_rows > 0 && $this->conn->affected_rows == 0){
                while($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
            } elseif($this->conn->affected_rows > 0) {
                var_dump($this->conn);
                $rows = $this->conn->insert_id;
            }
        }

        return $rows;
    }

    public function getError(){
        return $this->conn->error;
    }

    public function getColumns($table){
        $sql = "show columns from ".$table;
        return $this->getRows($sql);
    }
}