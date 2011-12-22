<?php

$zf2Path = '/var/php/library/zf2/library/';
set_include_path($zf2Path . PATH_SEPARATOR . get_include_path());


require 'Zend/Loader/AutoloaderFactory.php';
use Zend\Loader\AutoloaderFactory;


//Autoloading
AutoloaderFactory::factory(array(
	'Zend\Loader\StandardAutoloader' => array(
		'namespaces' => array(
			'MASchoolManagement' => __DIR__ . '/../../../src/library/MASchoolManagement',
		),
	),
));