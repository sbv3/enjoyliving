<?
class Timer{
  public $timerStart;
  public $timerEnd;
  public $iteration;
  
  public function start(){
    $this->timerStart = microtime();
    $this->timerEnd = 0;
    $this->iteration = $this->iteration+1;
  }

  public function stop(){
    $this->timerEnd = microtime();
  }

  public function get(){
    if($this->timerEnd == 0) $this->stop();
      $duration = $this->timerEnd - $this->timerStart;
	  ?><script>console.log("iterations: " + <? echo $this->iteration;?>); console.log("execution time: " + <? echo $duration ?> + ' seconds');</script><?
  }
}


// this class is simple to use
$Timer = new Timer;
$Timer->start();

// some code you want to benchmark

phpinfo();

$Timer->stop();
$Timer->get();
?>
