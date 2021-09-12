<?php

namespace App\Console\Commands;

use App\Bomb;
use App\Dummy;
use App\Firecracker;
use Illuminate\Console\Command;
use App\Target;

class drunkenWarior extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drunkenWarior:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Intense shooting game.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->initGame();
        
        return 0;
    }

    function translateKeypress($string) { // get the pressed key
        switch ($string) {
          case "\033[A":
            return "UP";
          case "\033[B":
            return "DOWN";
          case "\033[C":
            return "RIGHT";
          case "\033[D":
            return "LEFT";
          case "\n":
            return "ENTER";
          case " ":
            return "SPACE";
          case "\010":
          case "\177":
            return "BACKSPACE";
          case "\t":
            return "TAB";
          case "\e":
            return "ESC";
         }
        return $string;
    }


    public function initGame(){

        $totalShotsCount = 0;
        $gameEnded = false;
        $targets = $this->createTargets();

        $stdin = fopen('php://stdin', 'r');
        stream_set_blocking($stdin, 0);
        system('stty cbreak -echo');
         

        $this->info('Game initialized...Choose targets carefuly!');
        $this->info('Press Enter to shoot, ctr+c to exit.');
      
        while (!$gameEnded) {
          $keypress = fgets($stdin);
          if ($keypress) {
            $result = $this->translateKeypress($keypress);

            if($result == 'ENTER'){ // listen for enter key to shoot 
                $totalShotsCount++;
                $shotResult = $this->shoot($targets);

                if(!$shotResult){
                    $this->info('Game ended! Total shots fired: '.$totalShotsCount);
                    $gameEnded = true;
                }
               
            }
            else{
                $this->info('Invalid Control!! Press Enter to shoot, ctr+c to exit');
            }
           
          }
        }

    }

    public function createTargets(){

        $targetsAr = [];

        for($i=0;$i<=7;$i++){
            $targetsAr['dummy_'.$i] = new Dummy(50,'dummy_'.$i);
        }

        for($i=0;$i<=4;$i++){
            $targetsAr['firecracker_'.$i] = new Firecracker(75,'firecracker_'.$i);
        }

        for($i=0;$i<=0;$i++){
            $targetsAr['bomb_'.$i] = new Bomb(100,'bomb_'.$i);
        }

        return $targetsAr;

    }

    public function shoot(&$targets){

         $this->info('shooting!');

         if(!empty($targets)){
            $targetIdx = array_rand($targets);
            $target =  $targets[$targetIdx]; // hit random target ..
            $targetHitName = $target->name();
   
            switch ($targetHitName) {

               case 'App\Dummy':
                   
                   $hit = $target->hit($target::DAMAGE_HIT);
                   
                   if($hit){
                       $this->info($hit);
                   }
                   else{ // destroy obj
                       $this->info($target->getDamageHitMsg($target::DAMAGE_HIT)); 
                       unset($targets[$targetIdx]);
                   }
                   
                   break;
               case 'App\Firecracker':
                  
                   $hit = $target->hit($target::DAMAGE_HIT);
                   
                   if($hit){
                       $this->info($hit);
                   }
                   else{ // destroy obj
                       $this->info($target->getDamageHitMsg($target::DAMAGE_HIT)); 
                       $target->explode($targets);
                   }
   
                   break;
               case 'App\Bomb':
                   
                   $hit = $target->hit($target::DAMAGE_HIT);
                   
                   if($hit){
                       $this->info($hit);
                   }
                   else{// destroy obj
                        $this->info($target->getDamageHitMsg($target::DAMAGE_HIT)); 
                        $target->explode($targets);          
                   }
   
                   break;
           }
   
         }
         else{
             return false;
         }
        

         return true;
    }

}
