<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/12 0012
 * Time: 9:38
 */
include_once('CustomReplyDB.class.php');

$db = new CustomReplyDB();
if(!$db) echo $db->lastErrorMsg();

/**
 * 检测提交变量，并返回相应的值
 *
 * @param string $val_name 变量名
 * @param string $default_val 默认值
 * @param string $submit_type 提交方式 （POST|GET|REQUEST）
 */
function CheckDatas( $val_name, $default_val='', $submit_type= 'REQUEST' )
{
    if ( strtoupper($submit_type) == 'POST' )
    {
        $data = isset( $_POST[$val_name] ) ? $_POST[$val_name] : $default_val;
    }
    else if( strtoupper($submit_type) == 'GET' )
    {
        $data = isset( $_GET[$val_name] ) ? $_GET[$val_name] : $default_val;
    }
    else
    {
        $data = isset( $_REQUEST[$val_name] ) ? $_REQUEST[$val_name] : $default_val;
    }

    return $data;
}

$act = CheckDatas('act','');

//根据操作名称进行相应操作
switch ($act)
{
    default:
        $lists = $db->getAll('text');
        include_once('./web/reply_list.php');
        break;

    case 'create':
        include_once('./web/reply_form.php');
        break;

    case 'insert':
        //判断是否为空
        if (!$_POST['keyword']){
            echo json_encode(array('status'=>0,'info'=>'保存失败，关键字不能为空'));
            exit;
        }
        if (!$_POST['content'])  {
            echo json_encode(array('status'=>0,'info'=>'保存失败，内容不能为空'));
            exit;
        }

        $data = array(
            'keyword'     => $_POST['keyword'],
            'content'     => $_POST['content'],
            'create_time' => time(),
        );

        if ($db->checkExistKeyword($_POST['keyword'], 'text')) {
//            $db = new CustomReplyDB();
            $result = $db->insert($data,'text');
        } else {
            echo json_encode(array('status' => 0, 'info'=>'存在相同关键字'));
            exit;
        }

        if ($result) {
            echo json_encode(array('status' => 1, 'info'=>'保存成功！'));
        } else {
            echo json_encode(array('status' => 0, 'info'=>$db->lastErrorMsg()));
        }
        break;

    case 'edit':
        $type = 'text';
        $isEdit  = true;
        $edit_id = isset($_GET['id']) ? $_GET['id'] : '';



        if (!$edit_id) {
            echo '<script>alert("参数错误");history.go(-1);</script>';
            exit;
        } else {
            $data = $db->find($edit_id, $type);
        }
        include_once('./web/reply_form.php');
        break;

    case 'update':
        //判断是否为空
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            echo json_encode(array('status'=>0,'info'=>'保存失败，参数错误'));
            exit;
        }
        if (!$_POST['keyword']){
            echo json_encode(array('status'=>0,'info'=>'保存失败，关键字不能为空'));
            exit;
        }
        if (!$_POST['content'])  {
            echo json_encode(array('status'=>0,'info'=>'保存失败，内容不能为空'));
            exit;
        }

        $data = array(
            'keyword'     => $_POST['keyword'],
            'content'     => $_POST['content'],
        );

        if ($db->checkExistKeyword($_POST['keyword'], 'text')) {
//            $db = new CustomReplyDB();
            $result = $db->update($id , $data, 'text');
        } else {
            echo json_encode(array('status' => 0, 'info'=>'存在相同关键字'));
            exit;
        }

        if ($result) {
            echo json_encode(array('status' => 1, 'info'=>'保存成功！'));
        } else {
            echo json_encode(array('status' => 0, 'info'=>$db->lastErrorMsg()));
        }

        break;

    case 'delete':
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if ($id) {
            $db->delete($id, 'text');
        } else {
            echo json_encode(array('status'=>0,'info'=>'参数错误'));
            exit;
        }
        echo json_encode(array('status'=>1,'info'=>'删除成功'));
        break;
}

$db->close();

//$key = 'test';
//$Insert_sql = 'INSERT INTO CustomTextReply (keyword,content,create_time) values ("'. $key .'","InsertTest",'. time() .')';
//$db->insert(array('keyword'=>'测试','content'=>'faild','create_time'=>time()),'text');

//if (!$db->checkExistKeyword($key,$type='text')){
//
//    $result = $db->exec($Insert_sql);
//    if (!$result) echo $db->lastErrorMsg();
//
//} else {
//    echo '插入失败，存在相同关键字';
//}
