<?php
/**
 * 落地页
 */
class LuoDiYe extends Common{
    public function index(){
        $persize = 20;
        $param['flag'] = CheckDatas('f', '');
        $param['ip'] = CheckDatas('ip', '');
        $param['starttime'] = CheckDatas('st', '');
        $param['endtime'] = CheckDatas('et', '');
        $page = CheckDatas('p', 1);
        $page = max(1, $page);

        $mdl = M('external_link_log');
        $cond = array();
        $pageUrlParam = array();
        if($param['flag'] != ''){
            $cond[] = "flag='{$param['flag']}'";
            $pageUrlParam['f'] = urldecode($param['flag']);
        }
        if($param['ip'] != ''){
            $cond[] = "ip like '%{$param['ip']}%'";
            $pageUrlParam['ip'] = urldecode($param['ip']);
        }
        if($param['starttime'] != ''){
            $cond[] = 'time>='.strtotime($param['starttime']);
            $pageUrlParam['st'] = urldecode($param['starttime']);
        }
        if($param['endtime'] != ''){
            $cond[] = 'time<='.strtotime($param['endtime']);
            $pageUrlParam['et'] = urldecode($param['endtime']);
        }
        $order = array('time'=>'desc', 'id'=>'desc');
        $rs = $mdl->gets(implode(' and ', $cond), '*', $order, $page, $persize);
        $list = $rs['DataSet'];

        if($rs['PageCount'] > 1){
            $cfgPage = array(
                'show_first_last' => false,
            );
            $strPage = genPageStr($rs['RecordCount'], $persize, $page, url('LuoDiYe', 'index', $pageUrlParam).'&p', $cfgPage);
            $this->assign('strPage', $strPage);
        }

        $this->assign('param', $param);
        $this->assign('list', $list);
        $this->renderTpl('luodiye_index');
    }
}