<?php
namespace App;

class Bomb extends Target {
    
    const DAMAGE_HIT = 10;

    public function explode(&$targets){

        parent::preExplode($targets);

        foreach($targets as $k => $target){ // iterate all targets

            if($target->uniqId != $this->uniqId){ // ignore the exploding target 
    
                $randDamageHit = rand(25, 40);

                parent::hitOrDestroy($target, $randDamageHit, $k, $targets);
                
            }
       
        }

    }

}