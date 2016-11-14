<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/12 0012
 * Time: 9:38
 */
include_once('CustomReplyDB.class.php');
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
        $lists  = $db->getAll('text');
        $subscribe_data = $db->find(array('event'=>'subscribe'), 'event');
        include_once('tpl/reply_list.php');
        break;

    case 'create':
        include_once('tpl/reply_form.php');
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

        $condition_arr = array('keyword' => $_POST['keyword']);
        if (!$db->find($condition_arr, 'text')) {
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
            $data = $db->find(array('id'=>$edit_id), $type);
        }
        include_once('tpl/reply_form.php');
        break;

    case 'update':
        $ReqType = isset($_GET['type']) ? $_GET['type'] : '';
        switch ($ReqType) {
            default:
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
                $data = array(
                    'keyword'     => $_POST['keyword'],
                    'content'     => $_POST['content'],
                );

                $result = $db->update($data, 'text', array('id'=>$id));

                break;

            case 'event':
                if (isset($_GET) && isset($_POST['event_name'])) {
                    $data = array(
                        'event'       => $_POST['event_name'],
                        'content'     => $_POST['reply_content'],
                        'create_time' => time(),
                    );
                    $condition_arr = array('event'=>$_POST['event_name']); //查询条件
                    if ($db->find($condition_arr, $ReqType)) { //如果存在该事件自动回复
                        $result = $db->update($data, $ReqType, array('event'=>$_POST['event_name']));
                    } else {
                        $result = $db->insert($data, $ReqType);
                    }
                }
                break;
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

    case 'test':
        echo '测试页<hr>';
        print_r($db->find(array('id'=>1), 'event'));
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
