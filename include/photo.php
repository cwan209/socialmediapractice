<?php
require_once(LIB_PATH.DS.'database.php');

class Photo extends DatabaseObject {

    protected static $table_name="photo";
    protected static $db_fields = array('photoid', 'filename', 'type', 'size', 'caption');
    protected static $db_fields_for_insert = array('filename', 'type', 'size', 'caption');

    public $photoid;
    public $filename;
    public $type;
    public $size;
    public $caption;

    private $temp_path;
    protected $upload_dir = "image" . DS . "profile-image";
    public $errors = array();

    protected $upload_errors = array(

        UPLOAD_ERR_OK => "There is no error, the file uploaded with success.",
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
        UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder. Introduced in PHP 5.0.3.",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk. Introduced in PHP 5.1.0.",
        UPLOAD_ERR_EXTENSION => "File upload stopped by extension."

    );

    public function attach_file($file) {

        if(!$file || empty($file) || !is_array($file)) {
            $this->errors[] = "No file was uploaded.";
            return false;
        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        } else {
            $this->temp_path = $file['tmp_name'];
            $this->filename = basename($file['name']);
            $this->type = $file['type'];
            $this->size = $file['size'];
        }

        return true;
    }

    //override
    public function create() {
        global $database;

        $sql = "insert into photo (";
        $sql .= "filename, type, size, caption";
        $sql .= ") values (";
        $sql .= "'{$this->filename}','{$this->type}','{$this->size}','{$this->caption}'";
        $sql .= ")";

        if($database->query($sql)) {
            $this->photoid = $database->insert_id();
            return true;
        } else {
            return false;
        }


    }

    //Override
    public function save() {

        if(isset($this->photoid)){
            // Really just to update the caption

            $this->update();
        } else {
            if(!empty($this->errors)) {return false;}

//            if(strlen($this->caption) >= 255) {
//                $this->errorsp[] = "The caption can only be 255 characters long.";
//                return false;
//            }

            $target_path = SITE_ROOT . DS . $this->upload_dir . DS . $this->filename;

            if(file_exists($target_path)) {
                $this->errors[] = "The file {$this->filename} already exists.";
            }

            if(move_uploaded_file($this->temp_path, $target_path)) {

                if($this->create()) {
                    unset($this->temp_path);
                    return true;
                }
            } else {
                $this->errors[] = "The file uploaded failed, possibly due to incorrct permissions on the upload folder.";
                return false;
            }

        }

    }

    //override
    public static function find_by_id($id=0) {
        global $database;
        $result_array = static::find_by_sql("select * from "  . static::$table_name .
            " where photoid ={$id} limit 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public function image_path() {
        return $this->upload_dir . DS . $this->filename;
    }

    public function destroy() {
        // First remove the database entry
        // then remove the file

        if($this->delete()) {
            $target_path = SITE_ROOT . DS . 'public' . DS. $this->image_path();
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }

    public function size_as_text() {
        if($this->size < 1024) {
            return "{$this->size} bytes";
        } elseif ($this->size < 1048576) {
            $size_kb = round($this->size/1024);
            return "{$size_kb} KB";
        } else {
            $size_mb = round($this->size/10248576, 1);
            return "{$size_mb} MB";
        }
    }

//    public function comments() {
//        return Comment::find_comments_on($this->id);
//    }
}