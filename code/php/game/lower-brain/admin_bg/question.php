<?php
	define('HN1', true);
	define('SCRIPT_ROOT',  dirname(dirname(dirname(dirname(__FILE__)))).'/game/lower-brain/');
	define('INC_PATH',  SCRIPT_ROOT.'inc');

	require_once( SCRIPT_ROOT . 'global.php' );
	require_once( SCRIPT_ROOT . 'logic/game_brain_question_bankBean.php' );
	require_once( SCRIPT_ROOT . 'logic/game_brain_answer_bankBean.php' );

	$type  = isset($_REQUEST['act']) ? $_REQUEST['act'] : null;

	if (  $_SESSION['admin_login'] != 1 )
	{
		redirect('/game/lower-brain/admin_bg/login.php','请先进行登录！！');
	}



	$question = new game_brain_question_bankBean();
	$question->conn = $db;

	$answer = new game_brain_answer_bankBean();
	$answer->conn 	= $db;



	switch ( $type )
	{
		case "add":	// 添加题目
			include_once( '../tpl/admin/question_add_page.php' );
		break;


		case 'add_save':
			$question->type 		= $_POST['type'];
			$question->question 	= $_POST['question'];
			$answer->subject_id 	= $question->add();									// 添加问题，并获取问题id


			$answer_r 				= $_POST['answer_r'];								// 获取正确答案
			$answer_w 				= $_POST['answer_w'];								// 获取错误答案

			$answer_list[0] 		= array( 'text'=>$answer_r , 'is_right'=>1 );
			foreach ( $answer_w as $key=>$answers )
			{
				if ($answers != "" )
				{
					$answer_list[$key+1] = array( 'text'=>$answers, 'is_right'=>0 );
				}
			}

			foreach ( $answer_list as $answers )
			{
				$answer->text 		= $answers['text'];
				$answer->is_right 	= $answers['is_right'];
				$answer->add();															 // 添加问题对应的答案列表
			}

			redirect( $site_game_bg . '/question.php','题目添加成功！');
		break;

		case 'edit':
			$s_id = $_GET['id'];
			$question_info 		 = $question->get_question($db, $s_id);
			$answer_right_list   = $answer->get_right_list($db, $s_id);
			$answer_wrong_list   = $answer->get_wrong_list($db, $s_id);

			include_once( '../tpl/admin/question_edit_page.php' );
		break;

		case "edit_save":
			$question->question 	= $_POST['question'];
			$question->id 			= $_POST['question_id'];
			$question->edit();

			$arrAnswer 				= $_POST['answer'];										// 获取正确答案

			foreach ( $arrAnswer as $key=>$answers )
			{
				if ($answers != "" )
				{
					$answer_list[$key+1] = array( 'text'=>$answers, 'id'=>$key );
				}
			}

			foreach ( $answer_list as $answers_info )
			{
				$answer->id 		= $answers_info['id'];
				$answer->text 		= $answers_info['text'];
				$answer->edit();															 // 更新问题对应的答案列表
			}

			redirect( $site_game_bg . '/question.php?act=edit&id='.$question->id,'题目更新成功！');
		break;


		default:		// 默认页面
			$question_list = $question->get_question_list();
			foreach ( $question_list as $key=>$question )
			{
				$question_list[$key]->answer = $answer->get_answer_list($db, $question->id);
			}

			include_once( '../tpl/admin/question_page.php' );
	}


?>
