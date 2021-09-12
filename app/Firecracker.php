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
    
        shuffle($targets);
        
        echo 'Firecracker '.$this->uniqId.' exploded! '.PHP_EOL;

        $explodedElIdx = false;

        foreach($targets as $k=>$t){
            if($t->uniqId == $this->uniqId){
                $explodedElIdx = true;
                unset($targets[$k]);
            }
        }

        for($i=0; $i<=2; $i++){ // iterate first 3 shuffled targets

            if(isset($targets[$i])){
                
                $target = $targets[$i];

                if($target->uniqId != $this->uniqId){ // ignore the exploding target 
                   
                    $randDamageHit = rand(10, 15);
                    $hit = $target->hit($randDamageHit);
    
                    if($hit){
                        echo $hit.PHP_EOL;;;
                    }
                    else{ // destroy target

                        $targetHitName = $target->name();

                        switch ($targetHitName) {

                            case 'App\Dummy':
                                
                                echo $target->getDamageHitMsg($randDamageHit).PHP_EOL;
                                unset($targets[$i]);

                                break;

                            case 'App\Firecracker':
                               
                                echo $target->getDamageHitMsg($randDamageHit).PHP_EOL;
                                $target->explode($targets);
            
                
                                break;
                            case 'App\Bomb':
                                
                                echo $target->getDamageHitMsg($randDamageHit).PHP_EOL;
                                $target->explode($targets);
        
                                break;
                        }

                       
                    }

                }
                else{
                    $explodedElIdx = $i;
                }
                
            }

        }


        return $explodedElIdx;
      
    }
    
    function __destruct() {
        echo "The target Firecracker '.$this->uniqId.' is destroyed. ".PHP_EOL;; 
    }

}