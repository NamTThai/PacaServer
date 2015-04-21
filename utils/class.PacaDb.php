<?php

//Database class
class PacaDb {

    private $db_name;
    private $db;

    // open a connection to the database
    public function __construct($database='paca'){
        $db_host = ini_get("mysql.default_host");
        $db_user = ini_get("mysql.default_user");
        $db_pass = ini_get("mysql.default_password");
        $this->db_name=$database;
        $this->db = new mysqli($db_host, $db_user, $db_pass, $this->db_name);
    }

}
/*
    public function getdb(){
        return $this->db;
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

    //Log the user in and set session variable
    public function login($database, $username, $password){  
  
        $hashedPassword = md5($password);
        $result = mysqli_query($database, "SELECT * FROM login WHERE username = '$username' AND password = '$hashedPassword'");  
        if(mysqli_num_rows($result) == 1)  {  
            $_SESSION["user"] = serialize(new User(mysqli_fetch_assoc($result)));  
            $_SESSION["login_time"] = time();  
            $_SESSION["logged_in"] = 1;  
            return true;  
        }else{  
            return false;  
        }  
    }  

    //Log the user out. Destroy the session variables.  
    public function logout() {  
        unset($_SESSION['user']);  
        unset($_SESSION['login_time']);  
        unset($_SESSION['logged_in']);  
        session_destroy();  
    }  
  
    //Check to see if a username exists during registration 
    public function checkUsernameExists($database, $username) {  
        $result = mysqli_query($database, "select id from login where username='$username'");  
        if(mysqli_num_rows($result) == 0)  {  
            return false;  
        }else{  
            return true;  
        }  
    }  
    
}


class User {
    public $id;
    public $username;
    public $hashedPassword;

    function __construct($data) {  
        $this->id = (isset($data['id'])) ? $data['id'] : "";  
        $this->username = (isset($data['username'])) ? $data['username'] : "";  
        $this->hashedPassword = (isset($data['password'])) ? $data['password'] : "";
    }  
  
    public function save($db,$isNewUser = false) {
        $database=$db->getdb();
          
        //if the user is already registered and we're  
        //just updating their info.  
        if(!$isNewUser) {  
            $data = array(  
            "username" => "'$this->username'",  
            "password" => "'$this->hashedPassword'"
            );  
            $db->update($database, $data, 'login', 'id = '.$this->id); 
        }else { 
            $data = array( 
            "username" => "'$this->username'", 
            "password" => "'$this->hashedPassword'"
            );  
              
            $this->id = $db->insert($database, $data, 'login');
        }  
        return true;  
    }    
}  


//returns a User object. Takes the users id as an input  
function get($db,$id)  {
    $result = $db->select($db->getdb(),'login', "id = '$id'");   
    return new User($result);  
}*/

?>
