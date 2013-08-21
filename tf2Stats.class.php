<?

class tfStat{

	private $adr;
	private $port;

	function __construct ($adr, $port)
	{
		$this->adr = $adr;
		$this->port = $port;
	}

	function  get()
	{
		
		$fp = fsockopen('udp://'.$this->adr, $this->port);
		stream_set_timeout($fp, 2); 
		fwrite($fp,"\xFF\xFF\xFF\xFFTSource Engine Query\x00\r"); 
		$temp = fread($fp, 5); 
		$status = socket_get_status($fp); 
		if($status['unread_bytes']>0) 
		{
			$temp = fread($fp, $status['unread_bytes']);
			$array = array(); 
			$pos = 0; 
			while($pos !== false) 
			{ 
				$pos2 = strpos($temp, "\0", $pos+1); 
				$array[] = substr($temp, $pos+1, $pos2-$pos)."\n"; 
				$pos = $pos2;
			}
			$server['status'] 		= 'online'; 
			$server['players'] 		= ord($array[5][1]); 
			$server['maxplayers']   = ord($array[5][0]); 
			$server['name']   		= trim($array[0]); 
			$server['map']    		= trim($array[1]);
			$server['type']			= trim($array[3]);
		}else{
			$server['status'] 		= 'offline'; 
			$server['players'] 		= 0; 
			$server['maxplayers']   = 0; 
			$server['name']   		= 'n/a'; 
			$server['map']    		= 'n/a';
			$server['type']			= 'n/a';

		}
	return $server;
	}
}