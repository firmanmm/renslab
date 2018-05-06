<?php
	Route::Path(ADMIN_LINK.'/cache',function(){
		Component::Get('cache');
		switch (Data::Get('param')) {
			case 'clear':
				Cache::Clear();
				break;
			case 'create':
				Cache::Execute('route');
				break;
			default:
				break;
		}
	});
	Component::RequireCore('Loader');
	Loader::ViewNative('404');
?>