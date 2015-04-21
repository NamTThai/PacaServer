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
    public function escape($database,$string){
        mysqli_real_escape_string($database,$string);
    }

    // return an array in associate with a row set from the database
    public function processRowSet ($rowSet,$singleRow=false){
        $resultArray = array();
        while($row = mysqli_fetch_assoc($rowSet)) 
            array_push($resultArray,$row);
        if($singleRow==true)
            return $resultArray[0];
        return $resultArray;
    }

    // select rows from the database
    public function select($database,$table,$where,$singleRow=false){
        $sql = "SELECT * FROM $table WHERE $where";
        $result = mysqli_query($database,$sql);
        if(mysqli_num_rows($result)==0)
            return null;
        if(mysqli_num_rows($result)==1)
            return $this->processRowSet($result,true);
        return $this->processRowSet($result,$singleRow);
    }

    // updates a current row in the database
    public function update($database,$data,$table,$where){
        foreach ($data as $column => $value){
            $sql = "UPDATE $table SET $column = $value WHERE $where";
            mysqli_query($database,$sql) or die(mysqli_error($database));
        }
        return true;
    }
    
    // delete row(s) in the database
    public function delete($database,$table,$where){
        $sql = "DELETE FROM $table WHERE $where";
        mysqli_query($database,$sql) or die(mysqli_error($database));
        return true;
    }

    // inserts a new row into th database
    public function insert($database,$data,$table){
        $columns = "";
        $values = "";
        foreach ($data as $column => $value){
            $columns .= ($columns == "") ? "" : ", ";
            $columns .= $column;
            $values .= ($values == "") ? "" : ", ";
            $values .= $value;
        }
        $sql = "INSERT INTO $table ($columns) values ($values)";
        mysqli_query($database,$sql) or die(mysqli_error($database));

        return mysqli_insert_id($database);
    }
    
}

?>
