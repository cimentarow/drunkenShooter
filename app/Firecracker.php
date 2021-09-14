<?php
namespace App;

class Firecracker extends Target {
    
    const DAMAGE_HIT = 12;
    
    public function explode(&$targets){
       
        parent::preExplode($targets);
      
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

}