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

        $explodedElIdx = false;

        foreach($targets as $k=>$t){
            if($t->uniqId == $this->uniqId){
                $explodedElIdx = $k;
                unset($targets[$k]);
            }
        }

        foreach($targets as $k => $target){ // iterate all targets
        
                if($target->uniqId != $this->uniqId){ // ignore the exploding target 
        
                    $randDamageHit = rand(25, 40);
                   
                    $hit = $target->hit($randDamageHit);
    
                    if($hit){
                        echo $hit.PHP_EOL;
                    }
                    else{ // destroy target
                        $targetHitName = $target->name();

                        switch ($targetHitName) {

                            case 'App\Dummy':
                                
                                
                                echo $target->getDamageHitMsg($randDamageHit).PHP_EOL;
                                unset($targets[$k]);

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
                
                

        }


        return $explodedElIdx;
    }
    
    function __destruct() {
        echo "The target Bomb '.$this->uniqId.' is destroyed.".PHP_EOL; 
    }

}