<?php

class Car{

  public function run(){
    echo "<h1>HELLO folks, this is running!</h1>";
  }
}

$mercedes= new Car();
echo $mercedes->run();

?>
