<?php
define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'sys_loginBean.php';
require_once  LOGIC_ROOT.'feedbackBean.php';
$return_url = (!isset($_GET['return_url']) || ($_GET['return_url'] == '')) ? '/help' : $_GET['return_url'];
$act 	= ! isset($_REQUEST['act']) ? '' : $_REQUEST['act'];

if( $openid == null )
{
	redirect("login.php?dir=user_hongbao");
	return;
}
else if ( $user == null )
{
	redirect("user_binding?dir=user_hongbao");
	return;
}

$userid = $user->id;



switch ( $act )
{
	/*============ 留言提交处理 ===========*/
	case "post":
        $feedback 	 = new feedbackBean($db, 'feedback');
        $type        = $_REQUEST['type']        == null ? '' : $_REQUEST['type'];
 	    $content 	 = $_REQUEST['content']     == null ? '' : $_REQUEST['content'];
		$email 		 = $_REQUEST['email']       == null ? '' : $_REQUEST['email'];
        $telephone   = $_REQUEST['telephone']   == null ? '' : $_REQUEST['telephone'];


        $arrParam = array(
        	'user_id' 	  => $userid,
        	'type' 		  =>$type,
        	'content'	  =>$content,
        	'email' 	  =>$email,
        	'telephone'   =>$telephone,
        	'create_date' =>date('Y-m-d H:i:s')
        );

		$feedback->create( $arrParam);

		redirect('user','提交成功！');
	break;

	/*============ 留言提交显示页面 ===========*/
	default:
		include "tpl/feedback_web.php";
}

?>