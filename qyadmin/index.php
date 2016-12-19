<?php
/**
 * 后台入口
 */
define('DEBUG', false);
define('HN1', true);
define('MODULE_ROOT', dirname(__FILE__).'/');
define('SYSTEM_ROOT', MODULE_ROOT.'../');
define('SYSTEM_INC_DIR', SYSTEM_ROOT.'includes/inc/');
define('APP_INC', SYSTEM_INC_DIR);
define('MODULE_LIB', MODULE_ROOT.'lib/');

define('CONTROLLER_DIR', MODULE_ROOT.'controller/');
define('TPL_DIR', MODULE_ROOT.'view/');
define('SESS_ADMIN_K', 'adminkse');

define('__CSS__', 'static/css/');
define('__JS__', 'static/js/');
define('__IMAGE__', 'static/img/');
define('__PLUGIN__', 'static/plugins/');

session_start();

$CONFIG = array();
$commonCfg = require_once(MODULE_ROOT.'config/config.php');
empty($commonCfg) && $commonCfg = array();
$CONFIG = array_merge($CONFIG, $commonCfg);
$debugCfgFile = MODULE_ROOT.'config/debug.php';
if(defined('DEBUG') && DEBUG && file_exists($debugCfgFile)){
	$debugCfg = require_once($debugCfgFile);
	empty($debugCfg) && $debugCfg = array();
	$CONFIG = array_merge($CONFIG, $debugCfg);
}
include_once(SYSTEM_INC_DIR.'ez_sql_core.php');
include_once(SYSTEM_INC_DIR.'ez_sql_mysql.php');
include_once(SYSTEM_INC_DIR.'functions.php');
include_once(MODULE_ROOT.'common/function.php');
include_once(SYSTEM_INC_DIR.'db.php');
include_once(SYSTEM_INC_DIR.'Model.class.php');

$dbCfg = $CONFIG['DATABASE'];

$db = new ezSQL_mysql($dbCfg['USER'], $dbCfg['PASSWORD'], $dbCfg['NAME'], $dbCfg['HOST']);
$db->query('SET character_set_connection='.$dbCfg['CHARSET'].', character_set_results='.$dbCfg['CHARSET'].', character_set_client=binary');

$controller = CheckDatas('c', 'index');
$action = CheckDatas('a', 'index');

$ctlClz = ucfirst($controller);
try{
    require_once(CONTROLLER_DIR.'Base.class.php');
    require_once(CONTROLLER_DIR.'Common.class.php');
    if(!file_exists(CONTROLLER_DIR.$ctlClz.'.class.php')) throw new Exception('类文件不存在');
    require_once(CONTROLLER_DIR.$ctlClz.'.class.php');
    if(!class_exists($ctlClz)) throw new Exception('对应的类【'.$ctlClz.'】不存在');
    $Clazz = new $ctlClz();
    if(!method_exists($Clazz, $action)) throw new Exception('对应的方法【'.$action.'】不存在');
    $Clazz->$action();
}catch(Exception $e){
    echo $e->getMessage();
}
?>