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

$options_arr = array(
    'text'       => '文字',
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

        checkExistKey(array('key'=>trim($_POST['key']), 'event'=>$_POST['event']));//判断是否存在相同关键字

        switch($_POST['replyType'])
        {
            case 'text':
                if (!$_POST['content'])  ajaxReturn(0,'保存失败，内容不能为空');
                $content = json_encode_custom(array(
                    'msg' => $_POST['content'],
                ));
                break;

            case 'news':
                $arr       = array();
                $picUrlArr = array();
                for ($i=0;$i<count($_POST['title']);$i++) {
                    $k = $i+1;
                    if (!$_FILES['pic']['name'][$i]) {
                        ajaxReturn(0,'第'.$k.'链接图片为空，请上传');
                    } else {
                        //图片上传并生成链接
                        !file_exists(WX_UPLOAD) && mkdir(WX_UPLOAD, 0777, true);
                        $array    = explode('.',$_FILES['pic']['name'][$i]);
                        $suffix   = end($array); //后缀
                        $filename = date('YmdHi',time()) . rand(1,100) . '.' . $suffix; //文件名
                        $result   = move_uploaded_file($_FILES["pic"]["tmp_name"][$i], WX_UPLOAD . $filename);
                        if ($result) {
                            $picUrlArr[] = $site . 'upfiles/wx/' . $filename;
                        } else {
                            ajaxReturn(0,'图片上传失败');
                        }
                    }
                    if (!$_POST['title'][$i]) ajaxReturn(0,'保存失败，第'. $k .'个链接内容为空');
                    if (!$_POST['desc'][$i])  ajaxReturn(0,'保存失败，第'. $k .'个链接描述为空');
                    if (!$_POST['url'][$i])   ajaxReturn(0,'保存失败，第'. $k .'个链接链接为空');

                    $arr[] =  array(
                        'Title'       => $_POST['title'][$i],
                        'Description' => $_POST['desc'][$i],
                        'Url'         => $_POST['url'][$i],
                        'PicUrl'      => $picUrlArr[$i],
                    );
                }
                $content = json_encode_custom($arr);

                break;
        }

        $data = array(
            'key'         => ' ' . trim($_POST['key']) . ' ', //事件Key值
            'event'       => $_POST['event'], //事件类型
            'reply_type'  => $_POST['replyType'],
            'content'     => htmlentities($content,ENT_QUOTES,"utf-8"),
            'create_time' => time(),
        );

        $result = $db->insert($data);

        if ($result) {
            ajaxReturn(1, '保存成功');
        } else {
            ajaxReturn(0, $db->lastErrorMsg());
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

        $data['content'] = json_decode(html_entity_decode($data['content']), true); //json转为php数组
        $replyType    = $data['reply_type']; //回复类型
        $replyContent = array(); //回复内容
        foreach ($data['content'] as $key => $value) {
            array_push($replyContent, $value); //回复内容
        }

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

        switch($_POST['replyType'])
        {
            case 'text':
                if (!$_POST['content'])  ajaxReturn(0,'保存失败，内容不能为空');
                $content = array(
                    'msg' => $_POST['content'],
                );
                break;

            case 'news':
                $arr       = array();
                $picUrlArr = array();
                for ($i=0;$i<count($_POST['title']);$i++) {
                    $k = $i+1;
                    if (!$_FILES['pic']['name'][$i]) {
                        ajaxReturn(0,'第'.$k.'链接图片为空，请上传');
                    } else {
                        //图片上传并生成链接
                        !file_exists(WX_UPLOAD) && mkdir(WX_UPLOAD, 0777, true);
                        $array    = explode('.',$_FILES['pic']['name'][$i]);
                        $suffix   = end($array); //后缀
                        $filename = date('YmdHi',time()) . rand(1,100) . '.' . $suffix; //文件名
                        $result   = move_uploaded_file($_FILES["pic"]["tmp_name"][$i], WX_UPLOAD . $filename);
                        if ($result) {
                            $picUrlArr[] = $site . 'upfiles/wx/' . $filename;
                        } else {
                            ajaxReturn(0,'图片上传失败');
                        }
                    }
                    if (!$_POST['title'][$i]) ajaxReturn(0,'保存失败，第'. $k .'个链接内容为空');
                    if (!$_POST['desc'][$i])  ajaxReturn(0,'保存失败，第'. $k .'个链接描述为空');
                    if (!$_POST['url'][$i])   ajaxReturn(0,'保存失败，第'. $k .'个链接链接为空');

                    $content[] =  array(
                        'Title'       => $_POST['title'][$i],
                        'Description' => $_POST['desc'][$i],
                        'Url'         => $_POST['url'][$i],
                        'PicUrl'      => $picUrlArr[$i],
                    );
                }

                break;
        }

        $data = array(
            'key'         => ' ' . trim($_POST['key']) . ' ', //事件Key值
            'event'       => $_POST['event'], //事件类型
            'reply_type'  => $_POST['replyType'],
            'content'     => htmlentities(json_encode_custom($content),ENT_QUOTES,"utf-8"),
            'create_time' => time(),
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
            ajaxReturn(0,'参数错误');
        }
        ajaxReturn(1,'删除成功');
        break;

    case 'test':
        echo '测试页<hr>';
        $data = $db->page(3);
        $array = dataToKeyMap($data); //转换成二维数组
        break;

    default:
        $lists     = $db->page(5); //分页，里面填输出数目
        $totalPage = $db->totalPage; //总页数
        $nav       = $db->getPageNav();
        $subscribe_data = current($lists); //默认关注的回复数据
        array_shift($lists); //默认关注回复的数据出栈

        include_once('tpl/reply_list.php');
        break;
}

$db->close(); //断开数据库链接
