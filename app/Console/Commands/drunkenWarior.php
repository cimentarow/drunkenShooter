<?php

namespace App\Console\Commands;

use App\Bomb;
use App\Dummy;
use App\Firecracker;
use App\Dynamite;
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

        Target::create('App\Dummy', 50, 'dummy_', 8, $targetsAr);
        Target::create('App\Firecracker', 75, 'firecracker_', 5, $targetsAr);
        Target::create('App\Bomb', 100, 'bomb_', 1, $targetsAr);
        Target::create('App\Dynamite', 15, 'dynamite_', 1, $targetsAr);

        return $targetsAr;

    }

    public function shoot(&$targets){

         echo PHP_EOL;
         echo PHP_EOL;
         $this->info('shooting!');

         if(!empty($targets)){
            $targetIdx = array_rand($targets);
            $target =  $targets[$targetIdx]; // hit random target ..
          
            $target->hitOrDestroy($target, $target::DAMAGE_HIT, $targetIdx, $targets);
   
         }
         else{
             return false;
         }
        

         return true;
    }

}
