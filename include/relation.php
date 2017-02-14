<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 14/02/2017
 * Time: 12:10 AM
 */

require_once(LIB_PATH.DS.'database.php');

class Relation extends DatabaseObject {

    public $followid;
    public $followedid;

    protected static $table_name="follow";
    protected static $db_fields = array('followid', 'followedid');

    public static function follow($followid, $followedid) {
        global $database;

        $sql = 'insert into follow (followid, followedid) values (' . $followid . ',' . $followedid . ')';

        if ($database->query($sql)){
            return true;
        } else {
            return false;
        };
    }

    public static function is_followed($followid, $followedid)
    {
        global $database;
        $followid = $database->escape_value($followid);
        $followedid = $database->escape_value($followedid);

        $sql = "select * from follow ";
        $sql .= "where followid = '{$followid}' ";
        $sql .= "and followedid = '{$followedid}' ";
        $sql .= "limit 1";

        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? true : false;
    }

    public static function unfollow($followid, $followedid)
    {
        global $database;

        $sql = "delete from " . static::$table_name . " ";
        $sql .= "where followid= " . $followid . " and followedid = " . $followedid;
        $sql .= " limit 1";

        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public static function get_number_of_follow($userid) {
        global $database;

        $sql = "select count(*) from " . static::$table_name . " where followid = " . $userid;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    public static function get_number_of_followed($userid) {
        global $database;

        $sql = "select count(*) from " . static::$table_name . " where followedid = " . $userid;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }




}