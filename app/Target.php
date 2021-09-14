<?php
namespace App;

abstract class Target {
  // Properties
  public $points;
  public $uniqId;

  function __construct($points, $uniqId) {
    $this->points = $points; 
    $this->uniqId = $uniqId;

  }

  // Methods
  function set_points($points) {
    $this->points = $points;
  }

  function get_points() {
    return $this->points;
  }

  function name() {
    $class = get_class($this);
    $name = str_replace("App\\", "", $class);
    return $name;
  }

  public static function create($model, $points, $prefix, $count = 1, &$targets)
  {
      for ($i = 0; $i < $count; $i++) {
          $targets[] = new $model($points, $prefix . $i);
      }
  }

  public function hit($points){
    $this->points = $this->points - $points;

    if($this->points > 0){
        return $this->getDamageHitMsg($points);
    }
    else{
        return false;
    }
   
  }

  public function hitOrDestroy($target, $points, $idx, &$targets){
    
    $hit = $target->hit($points);
    
    if($hit){
        echo $hit.PHP_EOL;
    }
    else{ // destroy target

          echo $target->getDamageHitMsg($points).PHP_EOL;
          $target->explode($targets, $idx);

    }
  }

  public function getDamageHitMsg($points){
   
    return 'Nice shot! You damaged '.$this->name().' '.$this->uniqId.' for '.$points.'!';
  }

  public function preExplode(&$targets, $showExplodeMsg = true){

    if($showExplodeMsg){
      echo $this->name().' '.$this->uniqId.' exploded! '.PHP_EOL;
    }
        
    foreach($targets as $k=>$t){
        if($t->uniqId == $this->uniqId){
            unset($targets[$k]);
        }
    }
  }

  function __destruct() {
    $name = $this->name();
    echo "The target ".$name." ".$this->uniqId." is destroyed.".PHP_EOL; 
  }
  
}