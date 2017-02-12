<?php

require_once(LIB_PATH.DS.'database.php');

class User extends DatabaseObject {

    protected static $table_name="user";
    protected static $db_fields = array('username', 'password', 'firstname', 'lastname', 'motto', 'number_of_follow', 'number_of_followed', 'portrait_url', 'galleryid');

    public $id;
    public $username;
    public $password;
    public $firstname;
    public $lastname;
    public $motto;
    public $number_of_follow;
    public $number_of_followed;
    public $portrait_url;
    public $galleryid;

    public static function authenticate($username="", $password="") {
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);

        $sql = "select * from user ";
        $sql .= "where username = '{$username}' ";
        $sql .= "and password = '{$password}' ";
        $sql .= "limit 1";

        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function checkrepeat($username="", $password="") {
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);

        $sql = "select * from user ";
        $sql .= "where username = '{$username}' ";

        $result_array = self::find_by_sql($sql);

        return empty($result_array) ? true : false;
    }


    public function full_name() {
        if(isset($this->firstname) && isset($this->lastname)) {
            return $this->firstname . " " . $this->lastname;
        } else {
            return "";
        }
    }

    //override
    public function create(){
        global $database;

        $sql = "insert into ".static::$table_name . " (";
        $sql .= join(", ", static::$db_fields);
        $sql .= ") values ('";
        $sql .= $this->username . "','" . $this->password . "','" . $this->firstname . "','" . $this->lastname . "', '', 0, 0, '', 0";
        $sql .= ")";

        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }

        return $sql;

    }
}

?>