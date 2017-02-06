<?php
class Turntable extends Common{
    /**
     * 活动列表
     */
    public function index(){
        $persize = 20;
        $page = CheckDatas('p', 1);
        $page = max(1, $page);
        $param = array(
            'name' => CheckDatas('n', ''),
            'starttime' => CheckDatas('st', ''),
            'endtime' => CheckDatas('et', ''),
            'status' => CheckDatas('s', ''),
        );
        $time = time();

        $cond = array();
        $pageUrlParam = array();
        if($param['name'] != ''){
            $cond[] = "name LIKE '%{$param['name']}%'";
            $pageUrlParam['n'] = urldecode($param['name']);
        }
        if($param['starttime'] != ''){
            $cond[] = 'start_time>='.strtotime($param['starttime']);
            $pageUrlParam['st'] = urldecode($param['starttime']);
        }
        if($param['endtime'] != ''){
            $cond[] = 'end_time<='.strtotime($param['endtime']);
            $pageUrlParam['et'] = urldecode($param['endtime']);
        }
        switch($param['status']){
            case 1://已开始
                $cond[] = 'start_time<='.$time;
                break;
            case 2://已结束
                $cond[] = 'end_time<='.$time;
                break;
        }
        $pageUrlParam['s'] = $param['status'];
        $order = array('id'=>'desc');

        $mdl = M('wxhd_turntable');
        $rs = $mdl->gets(implode(' and ', $cond), '*', $order, $page, $persize);
        $list = $rs['DataSet'];
        $index = ($page - 1) * $persize + 1;
        if(!empty($list)){
            foreach($list as $k => $v){
                $v->index = $index;
                $index++;
            }
        }

        if($rs['PageCount'] > 1){
            $cfgPage = array(
                'show_first_last' => false,
            );
            $strPage = genPageStr($rs['RecordCount'], $persize, $page, url('Turntable', 'index', $pageUrlParam).'&p', $cfgPage);
            $this->assign('strPage', $strPage);
        }

        $this->assign('param', $param);
        $this->assign('list', $list);
        $this->renderTpl('turntable_index');
    }

    /**
     * 编辑活动
     */
    public function editTurntable(){
        $id = CheckDatas('id', 0);
        empty($id) && $this->error('参数错误');

        $mdl = M('wxhd_turntable');

        if(IS_POST()){
            $data = $_POST['data'];
            $data['start_time'] = strtotime($data['st']);
            $data['end_time'] = strtotime($data['et']);
            unset($data['st'], $data['et']);

            if($mdl->modify($data, array('id'=>$id)) === false){
                $this->error('编辑失败');
            }else{
                $this->success('编辑成功', url('Turntable'));
            }
        }else{
            $info = $mdl->get(array('id'=>$id), '*', ARRAY_A);
            empty($info) && $this->error('信息不存在');

            $this->assign('action', 'editTurntable');
            $this->assign('info', $info);
            $this->renderTpl('turntable_form');
        }
    }

    /**
     * 更改状态
     */
    public function switchTurntableStatus(){
        $id = CheckDatas('id');
        $status = CheckDatas('status', 0);

        $id = explode(',', $id);

        $mdl = M('wxhd_turntable');
        ($mdl->modify(array('status'=>$status), array('__IN__'=>array('id'=>$id))) === false) ? $this->ajaxResponse(0, '操作失败') : $this->ajaxResponse(1, '操作成功');
    }

    /**
     * 更改审核状态
     */
    public function switchTurntableVerify(){
        $id = CheckDatas('id');
        $verify = CheckDatas('verify', 0);

        $id = explode(',', $id);

        $mdl = M('wxhd_turntable');
        ($mdl->modify(array('verify'=>$verify), array('__IN__'=>array('id'=>$id))) === false) ? $this->ajaxResponse(0, '操作失败') : $this->ajaxResponse(1, '操作成功');
    }
}