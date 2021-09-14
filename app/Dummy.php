<?php
namespace App;

class Dummy extends Target {

    const DAMAGE_HIT = 15;

    public function explode(&$targets){
 
        parent::preExplode($targets, false);
    }

}