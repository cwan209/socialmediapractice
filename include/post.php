<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 13/02/2017
 * Time: 10:35 PM
 */

class Post extends DatabaseObject
{
    protected static $table_name = "post";
    protected static $db_fields = array('postid', 'userid', 'post_content', 'ts', 'post_galleryid');

    public $postid;
    public $userid;
    public $post_content;
    public $ts;
    public $post_galleryid;


    public function create(){
        global $database;

        $escaped_post_content = $database->escape_value($this->post_content);

        $sql = "insert into ".static::$table_name . " (";
        $sql .= "userid, post_content";
        $sql .= ") values (";
        $sql .= $this->userid . ",'" . $escaped_post_content;
        $sql .= "')";

        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }

    }

}

