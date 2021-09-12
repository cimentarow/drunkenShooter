<?php
namespace App;

class Dummy extends Target {

    const DAMAGE_HIT = 15;

    public function getDamageHit() {
        return self::DAMAGE_HIT;
    }

    public function getDamageHitMsg($points){
        return 'Nice shot! You damaged Dummy '.$this->uniqId.' for '.$points.'!';
    }

    public function explode($targets){
        // dummy doesnt explode
    }
    
    function __destruct() {
        echo "The target DUMMY '.$this->uniqId.' is destroyed.".PHP_EOL; 
    }
    

}