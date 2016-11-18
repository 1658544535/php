<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/12 0012
 * Time: 9:38
 */
include_once('global.php');

include_once(LIB_ROOT . 'CustomReplyDB.class.php');

$db = new CustomReplyDB();
if(!$db) echo $db->lastErrorMsg();

//根据操作名称进行相应操作
$act = CheckDatas('act','');

$options_arr = array(
    'text'       => '文本',
    'scan'       => '扫码',
    'subscribe'  => '扫码关注',
    'click'      => '点击',
);

switch ($act)
{
    case 'create':
        include_once('tpl/reply_form.php');
        break;

    case 'insert':
        //数据验证
        if (!$_POST['key']){
            echo json_encode(array('status'=>0,'info'=>'保存失败，关键字不能为空'));
            exit;
        }
        if (!$_POST['event'])  {
            echo json_encode(array('status'=>0,'info'=>'保存失败，自定义回复种类不能为空'));
            exit;
        }
        if (!$_POST['content'])  {
            echo json_encode(array('status'=>0,'info'=>'保存失败，内容不能为空'));
            exit;
        }
//        $content_JSON = contentToJSON();

        checkExistKey(array('key'=>trim($_POST['key']), 'event'=>$_POST['event']));//判断是否存在相同关键字

        $data = array(
            'key'         => ' ' . trim($_POST['key']) . ' ', //事件Key值
            'event'       => $_POST['event'], //事件类型
            'content'     => htmlentities($_POST['content'],ENT_NOQUOTES,"utf-8"),
            'create_time' => time(),
        );

        $result = $db->insert($data);

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
            $data = $db->find(array('id'=>$edit_id));
        }
        $replyEvent = isset($data['event']) ? $data['event'] : '';
        include_once('tpl/reply_form.php');
        break;

    case 'update':
        //判断是否为空
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            ajaxReturn(0, '保存失败，参数错误');
        }

        if (!$_POST['event']) ajaxReturn(0,'事件类型不能为空');
        if (!$_POST['key'])   ajaxReturn(0,'key值不能为空');

        $data = array(
            'key'     => ' ' . trim($_POST['key']) . ' ',
            'event'   => $_POST['event'],
            'content' => htmlentities($_POST['content'],ENT_NOQUOTES,"utf-8"),
        );

        checkExistKey(array('key'=>trim($_POST['key']), 'event'=>$_POST['event']), $id);

        if ($db->update($data, array('id'=>$id))) ajaxReturn(1,'修改成功');

        break;

    case 'delete':
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if ($id) {
            if ($id == '1') ajaxReturn(1, '该条数据无法删除'); //id => 1 为关注回复，不能删除
            $db->delete($id);
        } else {
            echo json_encode(array('status'=>0,'info'=>'参数错误'));
            exit;
        }
        echo json_encode(array('status'=>1,'info'=>'删除成功'));
        break;

    case 'test':
        echo '测试页<hr>';
//        $lists  = $db->getAll();
//        dataToKeyMap($lists);

        $db->like(array('key'=>123),'text',1);
        break;

    default:
        $lists  = $db->getAll();
        $subscribe_data = current($lists); //默认关注的回复数据
        array_shift($lists); //默认关注回复的数据出栈

        include_once('tpl/reply_list.php');
        break;

}

$db->close(); //断开数据库链接
