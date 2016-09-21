<?php
!defined('HN1') && exit('Access Denied.');
error_reporting(E_ALL);
error_reporting(0);

//set_magic_quotes_runtime(0);
define('APP_INC', dirname(__FILE__) . '/inc/');
define('DATA_ROOT', dirname(__FILE__) . '/data/');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
define('LOGIC_ROOT',  dirname(__FILE__).'/logic/');
define('MODEL_DIR', dirname(__FILE__).'/model');
define('FUNC_INC', dirname(__FILE__) . '/func/');

define('LOG_INC', dirname(__FILE__) . '/admin/logs/');

$isDebug = TRUE;

include_once(APP_INC . 'wxjssdk.php');

if ( $isDebug )
{
	include_once(APP_INC . 'debug_config.php');
}
else
{
	include_once(APP_INC . 'config.php');
}
include_once(APP_INC.'Model.class.php');
include_once(APP_INC . 'ez_sql_core.php');
include_once(APP_INC . 'ez_sql_mysql.php');
include_once(APP_INC . 'functions.php');
include_once(APP_INC . 'db.php');
require_once( APP_INC . 'log.php' );
include_once( FUNC_INC . 'Snoopy.class.php' );
include_once( FUNC_INC . 'simple_html_dom.php' );
$db = new ezSQL_mysql($dbUser, $dbPass, $dbName, $dbHost);
$db->query('SET character_set_connection=' . $dbCharset . ', character_set_results=' . $dbCharset . ', character_set_client=binary');

header("content-type: text/html; charset=utf-8");
session_start();

date_default_timezone_set('Asia/Shanghai'); //设置默认时区

/**********输出日志**********/
$file = LOG_INC . 'TmallFarm/' . date('Y_m_d') . '.log';
$CLogFileHandler = new CLogFileHandler( $file );
Log::Init($CLogFileHandler,1);

// Log::DEBUG('aabbbug');
// exit;


// require_once( APP_INC . 'log_seas.php' );
// $Log = new LogSeas();
// $Log->setBasePath( LOG_INC );

// $Log->setLogger( 'Hello' );
// $Log->isSHowLevel( TRUE );
// $Log->info('ABC');

// exit;
?>