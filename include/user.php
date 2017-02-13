<?php

require_once(LIB_PATH.DS.'database.php');

class User extends DatabaseObject {

    protected static $table_name="user";
    protected static $db_fields = array('userid', 'username', 'password', 'firstname', 'lastname', 'motto', 'number_of_follow', 'number_of_followed', 'galleryid', 'portraitid');
    protected static $db_fields_for_insert = array('username', 'password', 'firstname', 'lastname', 'motto', 'number_of_follow', 'number_of_followed', 'galleryid', 'portraitid');

    public $userid;
    public $username;
    public $password;
    public $firstname;
    public $lastname;
    public $motto;
    public $number_of_follow;
    public $number_of_followed;
    public $galleryid;
    public $portraitid;


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

    public static function is_repeated($username="", $password="") {
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);

        $sql = "select * from user ";
        $sql .= "where username = '{$username}' ";

        $result_array = self::find_by_sql($sql);

        return !empty($result_array) ? true : false;
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
        $sql .= join(", ", static::$db_fields_for_insert);
        $sql .= ") values ('";
        $sql .= $this->username . "','" . $this->password . "','" . $this->firstname . "','" . $this->lastname . "', '', 0, 0, 0, 0";
        $sql .= ")";

        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }

        return $sql;
    }

    public static function get_photoid($userid) {
        $result_array = self::find_by_id($userid);
        $photoid = $result_array['portraitid'];
        return $photoid;

    }

    //override
    public static function find_by_id($id=0) {
        global $database;
        $result_array = static::find_by_sql("select * from "  . static::$table_name .
            " where userid ={$id} limit 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function updatePhotoid($photoid, $userid) {
        global $database;

        $sql = 'update user set portraitid = ' . $photoid . ' where userid = '
         . $userid;

        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public static function updateMotto($motto, $userid) {
        global $database;

        $sql = "update user set motto = '" . $motto . "'where userid = "
            . $userid;

        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }


}

?>