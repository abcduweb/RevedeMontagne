<?php
class timer
{
	function timer()
	{
		$this->mtime = microtime ();
		$this->mtime = explode (' ', $this->mtime);
		$this->mtime = $this->mtime[1] + $this->mtime[0];
	}
	
	function start_load()
	{
		$this->starttime = $this->mtime;	
	}
	
	function end_load()
	{
		$this->mtime = microtime ();
		$this->mtime = explode (' ', $this->mtime);
		$this->mtime = $this->mtime[1] + $this->mtime[0];
		$this->endtime = $this->mtime;
		$this->totaltime = round (($this->endtime - $this->starttime), 5);
		return $this->totaltime.'sec';
	}
}
?>