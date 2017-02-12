<?php

require_once(LIB_PATH.DS.'database.php');

class DatabaseObject {

    public static function find_by_sql($sql="") {
        global $database;
        $result_set = $database->query($sql);
        $obejct_array = array();
        while ($row = $database->fetch_array($result_set)) {
//            $object_array[] = self::instantiate($row);
            array_push($obejct_array, static::instantiate($row));
        }
        return $obejct_array;
    }

    public static function count_all() {
        global $database;
        $sql = "select count(*) from " . static::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    public static function find_all() {
        return static::find_by_sql("select * from " . static::$table_name);
    }

    public static function find_by_id($id=0) {
        global $database;
        $result_array = static::find_by_sql("select * from "  . static::$table_name .
            " where id ={$id} limit 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function instantiate($record) {

        $object = new static;

        foreach($record as $attribute=>$value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }

        return $object;
    }

    protected function has_attribute($attribute) {

        $object_vars = $this->attributes();
        return array_key_exists($attribute, $object_vars);
    }

    protected function attributes($create="") {

        $attributes = array();
        foreach (static::$db_fields as $field) {

            if(property_exists($this, $field)) {
                if ($create == "true")
                {
                    if(!empty($this->$field)){
                        $attributes[$field] = $this->$field;
                    }
                    else {
                        $attributes[$field] = '';
                    }
                } else
                {
                    $attributes[$field] = $this->$field;
                }
            }
        }

        return $attributes;
    }

    protected function sanitized_attributes($create="") {

        global $database;
        $clean_attributes = array();

        if ($create=="true") {
            foreach($this->attributes("true") as $key => $value) {
                $clean_attributes[$key] = $database->escape_value($value);
            }
        } else {
            foreach($this->attributes() as $key => $value) {
                $clean_attributes[$key] = $database->escape_value($value);
            }
        }

        return $clean_attributes;
    }

    public function delete(){

        global $database;

        $sql = "delete from ".static::$table_name . " ";
        $sql .= "where id=" . $database->escape_value($this->id);
        $sql .= " limit 1";

        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;

    }

    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create(){
        global $database;

        $attributes = $this->sanitized_attributes("true");

        $sql = "insert into ".static::$table_name . " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") values ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";

        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }

    }

    public function update(){
        global $database;

        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();

        foreach($attributes as $key => $value) {
//            array_push($attribute_pairs, static::instantiate($row));
            $attribute_pairs[] = "{$key} = '{$value}'";
        }

        $sql = "update ".static::$table_name . " set ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " where id=" . $database->escape_value($this->id);


        $database->query($sql);

        return ($database->affected_rows() == 1) ? true : false;
    }

}