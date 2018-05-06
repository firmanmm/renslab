<?php
	class Input{
		private static $data;
		public static function GET($query){
			if(isset($_GET[$query])){
				if(isset(self::$data[$query])){
					return $data[$query];
				}
				self::$data[$query] = filter_var($_GET[$query],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				return self::$data[$query];
			}
			return NULL;
		}
		public static function POST($query){
			if(isset($_POST[$query])){
				if(isset(self::$data[$query])){
					return $data[$query];
				}
				self::$data[$query] = filter_var($_POST[$query],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				return self::$data[$query];
			}
			return NULL;
		}
		public static function POSTGET($query){
			if(self::POST($query)){
				return self::POST($query);
			}else if(self::GET($query)){
				return self::GET($query);
			}
			return NULL;
		}
		public static function POSTGETALL(){
			foreach ($_GET as $key => $value) {
				self::GET($key);
			}
			foreach ($_POST as $key => $value) {
				self::POST($key);
			}
		}
		public static function ClearTags($string){
			return strip_tags(htmlspecialchars_decode($string));
		}
		public static function VerifyRecaptcha(){
			$post_data = http_build_query(
			    array(
			        'secret' => CAPTCHA_SECRET,
			        'response' => $_POST['g-recaptcha-response'],
			        'remoteip' => $_SERVER['REMOTE_ADDR']
			    )
			);
			$opts = array('http' =>
			    array(
			        'method'  => 'POST',
			        'header'  => 'Content-type: application/x-www-form-urlencoded',
			        'content' => $post_data
			    )
			);
			$context  = stream_context_create($opts);
			$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
			$result = json_decode($response);
			return $result->success;
		}
		public static function Upload($inName,$target='uploaded/',$ext=array('png','jpg','jpeg','gif')){
			if(!isset($_FILES[$inName]))
				return NULL;
			if($_FILES[$inName]['error'] == UPLOAD_ERR_OK)
				return NULL;
			if(!in_array(pathinfo($_FILES[$inName]['name'],PATHINFO_EXTENSION), $ext))
				return NULL;
			if(!move_uploaded_file($_FILES[$inName]['tmp_name'],$target.date('Ymdhisa').'_'.basename($_FILES[$inName]['name'])))
				return NULL;
			return true;
		}
		public static function MultiUpload($inName,$target='uploaded/',$ext=array('png','jpg','jpeg','gif')){
			for($i = 0;isset($_FILES[$inName]['name'][$i]);$i++){
				if($_FILES[$inName]['error'][$i] == UPLOAD_ERR_OK)
					return NULL;
				if(!in_array(pathinfo($_FILES[$inName]['name'][$i],PATHINFO_EXTENSION), $ext))
					return NULL;
				if(!move_uploaded_file($_FILES[$inName]['tmp_name'][$i],$target.date('Ymdhisa').'_'.basename($_FILES[$inName]['name'][$i])))
					return NULL;
			}
			return true;
		}
	}
	
	
	
?>