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

  public function hitOrDestroy($target, $points, $idx, &$targets){
    
    $hit = $target->hit($points);
    
    if($hit){
        echo $hit.PHP_EOL;
    }
    else{ // destroy target

        $targetHitName = $target->name();

        switch ($targetHitName) {

            case 'App\Dummy':
                
                echo $target->getDamageHitMsg($points).PHP_EOL;
                unset($targets[$idx]);

                break;

            case 'App\Firecracker':
               
                echo $target->getDamageHitMsg($points).PHP_EOL;
                $target->explode($targets);

                break;
            case 'App\Bomb':
                
                echo $target->getDamageHitMsg($points).PHP_EOL;
                $target->explode($targets);

                break;
        }        
    }
  }
  
  abstract function getDamageHitMsg($points);
}