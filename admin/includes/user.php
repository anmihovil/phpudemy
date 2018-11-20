<?php

class User{

        public $_id;
        public $username;
        public $password;
        public $first_name;
        public $last_name;

        public static function find_all_users(){
        // global $database;
        // $result_set = $database->query("SELECT * FROM users");
        // return $result_set;
        return self::find_this_query("SELECT * FROM users");
      }

      public static function find_user_by_id($user_id){
        global $database;
        $the_result_array = self::find_this_query("SELECT*FROM users WHERE _id=$user_id LIMIT 1");

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

      public static function find_this_query($sql){
        global $database;
        $result_set = $database->query($sql);
        $the_object_array = array();

        while($row = mysqli_fetch_array($result_set)){
          $the_object_array[] = self::instantiation($row);
        }
        return $the_object_array;
      }

      public static function verify_user($username, $password){
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM users WHERE ";
        $sql.= "username = '{$username}' ";
        $sql.= "AND password = '{$password}' ";
        $sql.= "LIMIT 1 ";

        $the_result_array = self::find_this_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;

      }


      public static function instantiation($the_record){
        $the_object = new self;

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

      private function has_the_attribute($the_attribute){
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute, $object_properties);

      }

}



?>
