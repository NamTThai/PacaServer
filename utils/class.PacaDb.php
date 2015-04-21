<?php

//Database class
class PacaDb {

    private $db;
    private $db_name;
    private $db_table;

    // open a connection to the database
    public function __construct() {
        $paca_ini = parse_ini_file("/etc/php5/apache2/conf.d/paca.ini");
        $db_host = $paca_ini["paca_host"];
        $db_user = $paca_ini["paca_user"];
        $db_pass = $paca_ini["paca_password"];
        $this->db_name = $paca_ini["paca_database"];
        $this->db_table = $paca_ini["paca_table"];
        $this->db = new mysqli($db_host, $db_user, $db_pass, $this->db_name);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function getDb() {
        return $this->db;
    }

    public function getTable() {
        return $this->db_table;
    }

    public function close() {
        return $this->getDb()->close();
    }

    // escape a given string into mysqli query
    public function escape($string) {
        $this->getDb()->real_escape_string($string);
    }

    // return an array in associate with a row set from the database
    public function processRowSet($rowSet, $singleRow=false) {
        $resultArray = array();
        while ($row = $rowSet->fetch_assoc()) {
            array_push($resultArray, $row);
        }
        if ($singleRow == true) {
            return $resultArray[0];
        }
        return $resultArray;
    }

    // select rows from the database
    public function select($where, $singleRow=false) {
        $sql = "SELECT * FROM ".$this->getTable()." WHERE $where";
        $result = $this->db->query($sql);
        if ($result->num_rows() == 0) {
            return null;
        }
        if ($result->num_rows() == 1) {
            return $this->processRowSet($result, true);
        }
        return $this->processRowSet($result, $singleRow);
    }

    // updates a current row in the database
    public function update($data, $where) {
        foreach ($data as $column => $value) {
            $sql = "UPDATE ".$this->getTable()." SET $column = $value WHERE $where";
            $this->getDb()->query($sql) or die($this->getDb()->error);
        }
        return true;
    }
    
    // delete row(s) in the database
    public function delete($where) {
        $sql = "DELETE FROM ".$this->getTable()." WHERE $where";
        $this->getDb()->query($sql) or die($this->getDb()->error);
        return true;
    }

    // inserts a new row into th database
    public function insert($data) {
        $columns = "";
        $values = "";
        foreach ($data as $column => $value){
            $columns .= ($columns == "") ? "" : ", ";
            $columns .= $column;
            $values .= ($values == "") ? "" : ", ";
            $values .= $value;
        }
        $sql = "INSERT INTO ".$this->getTable()." ($columns) values ($values)";
        $this->getDb()->query($sql) or die($this->getDb()->error);

        return $this->getDb()->insert_id;
    }
    
}

?>
