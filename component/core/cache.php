<?php
	class Cache{
		private static $data;
		private static $uDat;
		private static $path;
		public static function Init(){
			self::$path = Site::ComponentPath().'cache/';
		}
		public static function Path($inName){
			self::$data[] = $inName;
		}
		public static function Execute($mode = 'route'){
			if($mode === 'route'){
				for($i=0;isset(self::$data[$i]);$i++){
					self::MakePage(self::$data[$i]);
				}
			}else if($mode === 'store' && isset(self::$uDat)){
				foreach (self::$uDat as $key => $value) {
					file_put_contents(self::$path.$key.'_c.cf', json_encode($value));
				}
			}
		}
		public static function MakePage($route){
			$tName = str_replace('/', '-', $route);
			Component::RequireCore('loader');
			ob_start();
			$callback = Route::GetCallback($route);
			if(is_string($callback))
				Loader::Controller($callback);
			else
				$callback();
			file_put_contents(Site::DocRoot().'/component/cache/'.$tName.'_pg.cf', ob_get_contents());
			ob_end_flush();
		}
		public static function Set($cName,&$cData){
			self::$uDat[$cName] = &$cData;
		}
		public static function Get($cName,$callback = null){
			$tName = self::$path.$cName.'_c.cf';
			if(file_exists($tName)){
				return json_decode(file_get_contents($tName),false);
			}else if($callback){
				return $callback();
			}
			return NULL;
		}
		public static function LoadPage($route){
			$tName = self::$path.str_replace('/', '-', $route).'_pg.cf';
			if(file_exists($tName)){
				include self::$path.str_replace('/', '-', $route).'_pg.cf';
				return true;
			}else{
				self::MakePage($route);
			}
			return NULL;
		}
		public static function Clear(){
			self::rrmdir(Site::DocRoot().'/component/cache');
			$cFolder = Site::DocRoot().'/component/cache';
			mkdir($cFolder);
			mkdir($cFolder.'/blade');
			file_put_contents($cFolder.'/index.php', '<?php include \'../../view/404.php\'; ?>');
			file_put_contents($cFolder.'/blade/index.php', '<?php include \'../../../view/404.php\'; ?>');

		}
		private static function rrmdir($dir){
			if (is_dir($dir)) {
				echo 'Traversing directory ';
				echo  $dir;
				echo '<br>';
		     	$objects = scandir($dir); 
		     	foreach ($objects as $object) { 
			       	if ($object != "." && $object != "..") { 
			        	if (is_dir($dir."/".$object))
			           		self::rrmdir($dir."/".$object);
			         	else 
			           		unlink($dir."/".$object);
			           	echo 'Deleting  ';
			           	echo $dir.'/'.$object;
			           	echo '<br>';
		       		} 
		     	}
		     	rmdir($dir); 
		    }
		}

	}
?>