<?php
	require_once 'component/core/site.php';
	Component::RequireCore('init');
	//Go Wild~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	Route::Path('test',function(){
		echo '<h1>Tetsts</h1>';
	},true);
	Route::Path('yay/itworks',function(){
		echo 'yay called';
	});
	Route::Path('yay',function(){
		echo 'is this on?';
	});
	Route::Path('',function(){
		echo 'home??';
	},true);
	Route::Path('tcont','test',true);
	Route::Path('btest','btess');
	//Stay Calm~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	Component::RequireCore('end');
?>