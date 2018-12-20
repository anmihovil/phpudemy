<?php

class Db_object{

    protected static $db_table = "users"; //A property to replace 'users' anywhere in the code

    public static function find_all(){
    // global $database;
    // $result_set = $database->query("SELECT * FROM users");
    // return $result_set;
    return static::find_by_query("SELECT * FROM ".static::$db_table." ");
  }


  public static function find_by_id($user_id){
    global $database;
    $the_result_array = static::find_by_query("SELECT * FROM ". static::$db_table . " WHERE _id=$user_id LIMIT 1");

    //This single line subsitutes all commented code afterwards - ternary operator
    return !empty($the_result_array) ? array_shift($the_result_array) : false;
    //$found_user = mysqli_fetch_array($result_set);
    // if(!empty($the_result_array)){
    //   $first_item = array_shift("$the_result_array");
    //   return $first_item;
    // }else{
    //   return false;
    // }
    //Next line corrected by Edwin from the future
    //return $found_user;
  }


    public static function find_by_query($sql){
      global $database;
      $result_set = $database->query($sql);
      $the_object_array = array();

      while($row = mysqli_fetch_array($result_set)){
        $the_object_array[] = static::instantiation($row);
      }
      return $the_object_array;
    }


    public static function instantiation($the_record){

      // The routine: late static binding
      $calling_class = get_called_class();
      $the_object = new $calling_class;
      // $the_object->_id        = $found_user['_id'];
      // $the_object->username   = $found_user['username'];
      // $the_object->password   = $found_user['password'];
      // $the_object->first_name = $found_user['first_name'];
      // $the_object->last_name  = $found_user['last_name'];
      foreach ($the_record as $the_attribute => $value) {
        // code...
        if($the_object->has_the_attribute($the_attribute)){
          $the_object->$the_attribute = $value;
        }
      }
      return $the_object;
    }

    //
    private function has_the_attribute($the_attribute){
      $object_properties = get_object_vars($this);
      return array_key_exists($the_attribute, $object_properties);

    }

    protected function properties(){
      //return get_object_vars($this);
      $properties = array();
      foreach (static::$db_table_fields as $db_field) {
        // code...
        if(property_exists($this, $db_field)){
          //using dynamic property ad hoc
          $properties[$db_field]=$this->$db_field;
        }
      }
      return $properties;
    }


    protected function clean_properties(){
      global $database;

      $clean_properties = array();

      foreach ($this->properties() as $key => $value) {
        // code...
        $clean_properties[$key] = $database->escape_string($value);
      }

      return $clean_properties;
    }


    public function save(){
      global $database;
      return isset($this->_id) ? $this->update() : $this->create();
    }

    public function create(){
      global $database;

      $properties = $this->clean_properties();

      //Genuine basic solution improved by abstraction routine later on
      //should be commented out, left for testing purposes
      $sql = "INSERT INTO ".static::$db_table ." (username,password,first_name,last_name)";
      $sql.= "VALUES ('";
      $sql.= $database->escape_string($this->username). "',' ";
      $sql.= $database->escape_string($this->password). "',' ";
      $sql.= $database->escape_string($this->first_name). "','";
      $sql.= $database->escape_string($this->last_name). "')";

      //Properties abstraction routine - improved solution, should be active
      //but returns query failed message!

      // $sql = "INSERT INTO ". static::$db_table ."(". implode(",", array_keys($properties)) .")";
      // $sql.= "VALUES ('".implode("','", array_values($properties))."')";

      if($database->query($sql)){
        $this->id = $database->the_insert_id();
        return true;
      }else{
        return false;
      }
    }

    public function update(){
      global $database;

      $properties = $this->clean_properties();
      $properties_pairs = array();

      foreach ($properties as $key => $value) {
        // code...
        $properties_pairs[]="{$key}='{$value}'";

      }
      $sql = "UPDATE ".static::$db_table." SET ";
      $sql.= implode(", ", $properties_pairs);
      // Using the same abstraction routine from create method
      // $sql.= "username='" . $database->escape_string($this->username)     . "', ";
      // $sql.= "password='" . $database->escape_string($this->password)     . "', ";
      // $sql.= "first_name='" . $database->escape_string($this->first_name) . "', ";
      // $sql.= "last_name='" . $database->escape_string($this->last_name)   . "' ";
      $sql.= " WHERE _id= " . $database->escape_string($this->_id);

      $database->query($sql);

      return (mysqli_affected_rows($database->connection)==1) ? true : false;
    }

    public function delete(){
      global $database;
      $sql = "DELETE FROM ".static::$db_table." ";
      $sql.= "WHERE _id=".$database->escape_string($this->_id);
      $sql.= " LIMIT 1";

      $database->query($sql);

      return (mysqli_affected_rows($database->connection)==1) ? true : false;
    }



}

?>
