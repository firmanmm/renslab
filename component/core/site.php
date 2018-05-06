<?php
	require_once 'component/core/config.php';
	class Data{ 
		private static $data;
		private static $mainRef; 
		public static function Set($query,$data){
			self::$data[$query][0] = $data;
			self::$data[$query][1] = false;
			self::$mainRef[$query] = &self::$data[$query][0];
		}
		public static function Get($query){
			return isset(self::$data[$query][0]) ? self::$data[$query][0] : NULL;
		}
		public static function Print($query,$out=false){
			if(isset(self::$data[$query])){
				$temp = &self::$data[$query];
				if(!$temp[1]){
					$temp[1] = true;
					$temp[2] = htmlspecialchars_decode(self::$temp[0]);
				}
				if(!$out){
					echo $temp[2];
				}
				return $temp[2];
			}
			return false;
		}
		public static function &GetReference(){
			return self::$mainRef;
		}

	}
	class ErrorMsg{
		private static $errorData;
		private static $sysError;
		public static function SysSet($msg){
			self::$sysError[] = $msg;
		}
		public static function SysGet(){
			if(isset($sysError[0])){
				return self::$sysError;
			}
			return NULL;
			
		}
		public static function Set($query,$msg){
			self::$errorData[$query] = $msg;
		}
		public static function Get($query){
			return isset(self::$errorData[$query]) ? self::$errorData[$query] : NULL;
		}
	}
	
	class Site{
		private static $data;
		public static function DocRoot(){
			if(!isset(self::$data[0])){
				self::$data[0] = $_SERVER['DOCUMENT_ROOT'].CURRENT_PATH;
			}
			return self::$data[0];
		}
		public static function Host(){
			if(!isset(self::$data[1])){
				self::$data[1] = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$_SERVER['HTTP_HOST'];
			}
			return self::$data[1];
		}
		public static function HostURL(){
			if(!isset(self::$data[2])){
				self::$data[2] = Site::Host().CURRENT_PATH;
			}
			return self::$data[2];
		}
		public static function URL(){
			if(!isset(self::$data[3])){
				self::$data[3] = Site::Host().$_SERVER['REQUEST_URI'];
			}
			return self::$data[3];
		}
		public static function ComponentPath(){
			if(!isset(self::$data[4])){
				self::$data[4] = Site::DocRoot().'/component/';
			}
			return self::$data[4];
		}
	}
	
	class Component{
		public static function Get($component,$query=NULL){
			if($query){
				include Site::ComponentPath().$component.'/'.$query.'.php';
			}else{
				include Site::DocRoot().'/'.$component.'.php';
			}
		}
		public static function GetOnce($component,$query){
			include_once Site::ComponentPath().$component.'/'.$query.'.php';
		}
		public static function RequireCore($query){
			require_once Site::ComponentPath().'core/'.$query.'.php';
		}
		public static function CacheLoad($query){
			include Site::ComponentPath().'cache/'.str_replace('/', '-', $query).'_c.html';
		}
	}
	
	function Redirect($path){
		header('Location: '.GetHostURL().'/'.$path);
		die();
	}
?>