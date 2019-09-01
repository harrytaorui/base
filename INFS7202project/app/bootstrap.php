<?php
	// Load Config
	require_once 'config/config.php';

	// Load helper functinos
	require_once 'helpers/url_helper.php';
	require_once 'helpers/session_helper.php';

	// Autoload Core Libraries 
	// When, we instantiate “MyClass”, class name(MyClass) is passed by PHP to “spl_autoload_register()”
	spl_autoload_register(function($className) {
		require_once 'core/' . $className . '.php';
	});