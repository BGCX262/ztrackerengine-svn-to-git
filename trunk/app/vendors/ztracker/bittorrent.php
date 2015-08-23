<?
// SET PHP ENVIRONMENT
@error_reporting(E_ALL & ~E_NOTICE);
@ini_set('error_reporting', E_ALL & ~E_NOTICE);
@ini_set('display_errors', '1');
@ini_set('display_startup_errors', '0');
@ini_set('ignore_repeated_errors', '1');
@ignore_user_abort(1);
@set_time_limit(0);
@set_magic_quotes_runtime(0);
@session_start();
define ('ROOT_PATH', dirname(dirname(__FILE__))."/");

?>