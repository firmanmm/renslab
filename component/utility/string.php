<?php 
	//SpeedNote : 7.1525573730469E-6 vs 1.6927719116211E-5, 4.2 Time faster!
	function TrimRight($string,$needle){
		$result = "";
		$pos = 0;
		for($i=0;isset($string[$i]);$i++){
			if($string[$i]==$needle){
				$pos = $i;
			}
		}
		while(isset($string[++$pos]) && $string[$pos] != '?'){
			$result .= $string[$pos];
		}
		return $result;
	}
	function ClearRight($string,$needle){
		$data = "";
		$lastPos = 0;
		for($i = 0;isset($string[$i]);$i++){
			if($string[$i]==$needle){
				for($j = $lastPos; $j<$i;$j++){
					$data .= $string[$j];
				}
				$lastPos = $i;
			}
		}
		return $data;
	}
	function htmlDecode($string){
		return htmlspecialchars_decode($string);
	}
	function SeoURL($string){
		$string = strtolower($string);
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	    $string = preg_replace("/[\s-]+/", " ", $string);
	    $string = preg_replace("/[\s_]/", "-", $string);
	    return $string;
	}
	function AppendQuery($extra){
		$queryString = "";
		foreach ($extra as $key => $value) {
			$queryString .= ",{$value}";
		}
		return $queryString;
	}
?>