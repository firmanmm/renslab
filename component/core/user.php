<?php
	
	class User {
		public static $data;
		public static function MinLevel($min){
			self::ForceLogin();
			if( self::$data['lvl'] === $min){
				return true;
			}
			return false;
		}
		public static function ForceLogin(){
			if(isset(self::$data)){
				return;
			}
			Redirect('');
		}
		public static function Set($query,$data){
			self::ForceLogin();
			self::$data[$query] = $data;
		}
		public static function Get($query){
			self::ForceLogin();
			return self::$data[$query];
		}
		public static function Logout(){
			session_destroy();
		}
		public static function Login($lvl){
			session_start();
			if(isset($_SESSION['user'])){
				self::$data = &$_SESSION['user'];
			}
		}
	}

?>