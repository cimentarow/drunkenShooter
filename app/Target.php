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
    return get_class($this);
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
  
  abstract function getDamageHitMsg($points);
}