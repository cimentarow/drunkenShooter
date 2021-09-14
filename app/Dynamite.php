<?php
namespace App;

class Dynamite extends Target {
    
    const DAMAGE_HIT = 15;
    
    public function explode(&$targets){
       
        parent::preExplode($targets);
      
        shuffle($targets); // shuffle targets

        for($i=0; $i<=4; $i++){ // iterate first 5 shuffled targets

            if(isset($targets[$i])){
                
                $target = $targets[$i];

                parent::hitOrDestroy($target, 20, $i, $targets);
                
            }

        }

    }

}