<?php

//Database class
class PacaDb {

    private $db;
    private $dbName;
    private $dbTable;

    // open a connection to the database
    public function __construct() {
        $pacaIni = parse_ini_file("/etc/php5/apache2/conf.d/paca.ini");
        $dbHost = $pacaIni["paca_host"];
        $dbUser = $pacaIni["paca_user"];
        $dbPass = $pacaIni["paca_password"];
        $this->dbName = $pacaIni["paca_database"];
        $this->dbTable = $pacaIni["paca_table"];
        $this->db = new mysqli($dbHost, $dbUser, $dbPass, $this->dbName);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }
    
    public function close() {
        return $this->getDb()->close();
    }
    
    // escape a given string into mysqli query
    public function escape($string) {
        $this->getDb()->real_escape_string($string);
    }

    public function getDb() {
        return $this->db;
    }

    public function getTable() {
        return $this->dbTable;
    }
    
    public function insertPicture($name, $timestamp, $lat, $lng) {
        $data = array(
            "address" => "'".$name."'",
            "timestamp" => "'".$timestamp."'",
            "lat" => $lat,
            "lng" => $lng,
        );
        return $this->insert($data);
    }
    
    public function retrievePictures($lat, $lng) {
        $var = "id, address, ( 3959 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance";
        $where = "distance > 0 ORDER BY id DESC LIMIT 0 , 10";
        return $this->select_having($where, $var);
    }

    // return an array in associate with a row set from the database
    private function processRowSet($rowSet, $singleRow=false) {
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
    private function select_having($where, $var="*", $singleRow=false) {
        $sql = "SELECT ".$var." FROM ".$this->getTable()." HAVING $where";
        $result = $this->getDb()->query($sql);
        if ($result->num_rows == 0) {
            return null;
        }
        if ($result->num_rows == 1) {
            return $this->processRowSet($result, true);
        }
        return $this->processRowSet($result, $singleRow);
    }

    // updates a current row in the database
    private function update($data, $where) {
        foreach ($data as $column => $value) {
            $sql = "UPDATE ".$this->getTable()." SET $column = $value WHERE $where";
            $this->getDb()->query($sql) or die($this->getDb()->error);
        }
        return true;
    }
    
    // delete row(s) in the database
    private function delete($where) {
        $sql = "DELETE FROM ".$this->getTable()." WHERE $where";
        $this->getDb()->query($sql) or die($this->getDb()->error);
        return true;
    }

    // inserts a new row into th database
    private function insert($data) {
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
