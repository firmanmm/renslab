<?php
	require_once 'component/core/config.php';
	class DB{
		private static $mySQL;
		private static $rasync = false; //Determine is there an aysnc query
		public static function Connect(){
			if(!isset(self::$mySQL)){
				self::$mySQL = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME); //Don't create new connection
			}
		}
		public static function Disconnect(){
			if(isset(self::$mySQL)){
				self::$mySQL->close();
				unset(self::$mySQL);
			}
		}
		public static function Query($query,$out = false,$async=false){
			DB::Connect();
			if($async){
				if(self::$rasync){
					return;
				}
				self::$rasync = true;
				self::$mySQL->query($query,MYSQLI_ASYNC);
				return;
			}else{
				$temp = self::$mySQL->query($query);
				if($out){
					return $temp->fetch_all(MYSQLI_ASSOC);
				}
			}
			
		}
		public static function Prepare($query){
			DB::Connect();
			return self::$mySQL->prepare($query);
		}
		public static function AsyncGet(){
			if(!self::$rasync){
				return false;
			}
			$rasync = false;
			return self::$mySQL->reap_async_query()->fetch_all();
		}
	}
?>
