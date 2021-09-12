<?php
namespace App;

class Firecracker extends Target {
    
    const DAMAGE_HIT = 12;

    public function getDamageHit() {
        return self::DAMAGE_HIT;
    }

    public function getDamageHitMsg($points){
        return 'Nice shot! You damaged Firecracker '.$this->uniqId.' for '.$points.'!';
    }
    
    public function explode(&$targets){
        
        echo 'Firecracker '.$this->uniqId.' exploded! '.PHP_EOL;

        
        foreach($targets as $k=>$t){
            if($t->uniqId == $this->uniqId){
                unset($targets[$k]);
            }
        }

        shuffle($targets); // shuffle targets

        for($i=0; $i<=2; $i++){ // iterate first 3 shuffled targets

            if(isset($targets[$i])){
                
                $target = $targets[$i];

                if($target->uniqId != $this->uniqId){ // ignore the exploding target 
                   
                    $randDamageHit = rand(10, 15);

                    parent::hitOrDestroy($target, $randDamageHit, $i, $targets);

                }
                
            }

        }

    }
    
    function __destruct() {
        echo "The target Firecracker '.$this->uniqId.' is destroyed. ".PHP_EOL;; 
    }

}