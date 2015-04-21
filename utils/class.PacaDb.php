<?php

//Database class
class PacaDb {

    private $db_name;
    private $db;

    // open a connection to the database
    public function __construct($database='paca') {
        $db_host = ini_get("mysql.default_host");
        $db_user = ini_get("mysql.default_user");
        $db_pass = ini_get("mysql.default_password");
        $this->db_name=$database;
        $this->db = new mysqli($db_host, $db_user, $db_pass, $this->db_name);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function getdb() {
        return $this->db;
    }

    public function close() {
        return $this->db->close();
    }

    // escape a given string into mysqli query
    public function escape($string) {
        $this->db->real_escape_string($string);
    }

    // return an array in associate with a row set from the database
    public function processRowSet ($rowSet, $singleRow=false) {
        $resultArray = array();
        while ($row = $rowSet->fetch_assoc()) {
            array_push($resultArray,$row);
        }
        if($singleRow==true) {
            return $resultArray[0];
        }
        return $resultArray;
    }

    // select rows from the database
    public function select($table, $where, $singleRow=false) {
        $sql = "SELECT * FROM $table WHERE $where";
        $result = $this->db->query($sql);
        if ($result->num_rows() == 0) {
            return null;
        }
        if ($result->num_rows() == 1) {
            return $this->processRowSet($result,true);
        }
        return $this->processRowSet($result,$singleRow);
    }

    // updates a current row in the database
    public function update($data, $table, $where) {
        foreach ($data as $column => $value) {
            $sql = "UPDATE $table SET $column = $value WHERE $where";
            $this->db->query($sql) or die($this->db->error);
        }
        return true;
    }
    
    // delete row(s) in the database
    public function delete($table, $where) {
        $sql = "DELETE FROM $table WHERE $where";
        $this->db->query($sql) or die($this->db->error);
        return true;
    }

    // inserts a new row into th database
    public function insert($data, $table) {
        $columns = "";
        $values = "";
        foreach ($data as $column => $value){
            $columns .= ($columns == "") ? "" : ", ";
            $columns .= $column;
            $values .= ($values == "") ? "" : ", ";
            $values .= $value;
        }
        $sql = "INSERT INTO $table ($columns) values ($values)";
        $this->db->query($sql) or die($this->db->error);

        return $this->db->insert_id;
    }
    
}

?>
