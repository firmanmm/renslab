<?php
	use eftec\bladeone;
	class Loader{

		private static $blade;

		public static function Model($name){
			include Site::DocRoot().'/model/'.$name.'.php';
		}

		public static function Controller($name){
			include Site::DocRoot().'/controller/'.$name.'.php';
		}

		public static function ViewNative($name){
			include Site::DocRoot().'/view/'.$name.'.php';
		}

		public static function ViewBlade($name,$data = NULL){
			if(!isset(self::$blade)){
				self::InitBlade();
			}
			if($data)
				echo self::$blade->run($name,$data);
			else
				echo self::$blade->run($name,Data::GetReference());
		}

		private static function InitBlade(){
			Component::GetOnce('utility','BladeOne');
			$compiled = Site::ComponentPath().'/cache/blade';
			$views = Site::DocRoot().'/view';
			self::$blade = new bladeone\BladeOne($views,$compiled);
		}
	}
?>