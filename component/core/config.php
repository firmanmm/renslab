<?php
	/* -- Database initialization! --> */
	define('DB_NAME','DB NAME');
	define('DB_USER','USERNAME');
	define('DB_PASS','PASSWORD');
	define('DB_HOST','HOSTNAME');
	define('ADMIN_LINK','ADMIN LINK');
	/* -- End Of Database initialization! --> */
	
	/* -- Protection Rule initialization! --? */
	define('CAPTCHA_SECRET', 'GOOGLE CAPTCHA_SECRET');
	define('ADMIN_USER', 'USERNAME');
	define('ADMIN_PASS','BCRYPTED PASSWORD'); //USE BCRYPT!
	define('MAX_IMG_SIZE', 50000000);
	define('VALID_IMG_TYPE', array("image/jpg", "image/jpeg", "image/gif", "image/png"));
	/* -- End Of Protection Rule initialization! --? */

	/* -- Site Related Setting -- */
	define("BLADEONE_MODE",0); //1 Keep Compile -- 2 Production -- 0 Automatic
	define('OFFLINE',false);
	define('DEBUG',true);
	define('THEME','default');
	define('THEME_COLOR','#2196f3');
	define('CURRENT_PATH', 'CURRENT WORKING DIRECTORY');
	/* -- End of Site Related Setting -- */

?>