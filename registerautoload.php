<?
/**
 *	This is used in the Testing and Validation phase of the mvn test
**/	

define('QWERLY_PATH', 		realpath(dirname(__FILE__)).'/src/main/php/Qwerly');
define('QWERLY_TEST_PATH',	realpath(dirname(__FILE__)).'/src/test/php/Qwerly/');
$paths = array(	get_include_path(),
				QWERLY_PATH,
				realpath(dirname(__FILE__)).'/src/main/php',
				realpath(dirname(__FILE__)).'/target/phpinc',
				'.');
set_include_path(implode(PATH_SEPARATOR, $paths));

require_once 'environments.php';
defined('APPLICATION_ENV')		or define('APPLICATION_ENV', 	ENVIRONMENT_UNIT_TEST);
defined('APPLICATION_PATH') 	or define('APPLICATION_PATH', 	realpath(dirname(__FILE__)).'/src/main/php/Qwerly');
defined('MOCK_DB_PATH')			or define('MOCK_DB_PATH', 		realpath(dirname(__FILE__)).'/src/test/testDB/');

require_once "Zend/Loader/Autoloader.php";
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('PHPUnit_');
$autoloader->registerNamespace('Zend_');
$autoloader->registerNamespace('Qwerly_');

PHPUnit_Util_Filter::addDirectoryToWhitelist(QWERLY_PATH);

