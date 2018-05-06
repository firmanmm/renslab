<?php
	class Route{
		private static $uDat;
		private static $parCount = 0;
		private static $param;
		private static $cRoute;
		private static $routeData;
		public static function Init(){
			$rData = explode('/', Site::HostURL());
			$i = count($rData);
			$rData = explode('/', Site::URL());
			self::$cRoute = '';
			for($parCount = 0,$j=$i;isset($rData[$j+1]);$j++,$parCount++){
				self::$cRoute .= self::$uDat[$parCount] = $rData[$j]; // Get router
				self::$param = $rData[$j+1]; // Get param if avaiable
				if(isset($rData[$j+2])){
					self::$cRoute .= '/';
				}
			}
			if($parCount == 0){
				if(isset($rData[$i])){
					self::$uDat[0] = $rData[$i];
				}else{
					self::$uDat[0] = '';
				}	
			}
		}
		public static function Path($route,$callback,$static=false){
			if($static)
				self::$routeData[$route] = $callback;
			if($route === self::$cRoute){
				Data::Set('param',isset(self::$param) ? self::$param : NULL );
				Data::Set('route',$route);
				if($static){
					Cache::LoadPage($route);
					die();
				}
				Component::RequireCore('Loader');
				if(is_string($callback)){
					Loader::Controller($callback);
					die();
				}
				$callback();
				die();
			}
		}
		public static function GetCallback($route){
			return isset(self::$routeData[$route]) ? self::$routeData[$route] : NULL;
		}
		public static function Execute(){
			$route = implode('/', self::$uDat);
			if(isset(self::$routeData[$route])){
				Data::Set('param',isset(self::$param) ? self::$param : NULL );
				Data::Set('route',$route);
				if(self::$routeData[$route][1]){
					Cache::LoadPage($route);
					return;
				}
				if(is_string(self::$routeData[$route][0])){
					Component::Get('model',self::$routeData[$route][0]);
					self::$routeData[$route][0]();
					Component::Get('view',self::$routeData[$route][0]);
					return;
				}
				self::$routeData[$route][0]();

			}else{
				echo '404 Not Found...';
			}
		}

	}
?>