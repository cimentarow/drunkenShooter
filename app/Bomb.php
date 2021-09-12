<?php
namespace App;

class Bomb extends Target {
    
    const DAMAGE_HIT = 10;

    public function getDamageHit() {
        return self::DAMAGE_HIT;
    }

    public function getDamageHitMsg($points){
        return 'Nice shot! You damaged Bomb '.$this->uniqId.' for '.$points.'!';
    }

    public function explode(&$targets){
        
        echo 'Bomb '.$this->uniqId.' exploded!'.PHP_EOL;

        foreach($targets as $k=>$t){ // unset bomb before impacting other targets to prevent second bomb explosion
            if($t->uniqId == $this->uniqId){
                unset($targets[$k]);
            }
        }

        foreach($targets as $k => $target){ // iterate all targets

            if($target->uniqId == $this->uniqId){
                unset($targets[$k]);
            }   
    
            if($target->uniqId != $this->uniqId){ // ignore the exploding target 
    
                $randDamageHit = rand(25, 40);

                parent::hitOrDestroy($target, $randDamageHit, $k, $targets);
                
            }
       
        }

    }
    
    function __destruct() {
        echo "The target Bomb '.$this->uniqId.' is destroyed.".PHP_EOL; 
    }

}