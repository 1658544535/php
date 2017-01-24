<?php
class WxHongbao extends Common{
	public function index(){
		$this->password();
	}

	public function password(){
		$mdl = M('wxhb_password');
		$list = $mdl->getAll(array(), '*', array('id'=>'asc'));
		$this->assign('list', $list);
		$this->renderTpl('wxhb_password');
	}

	public function editPassword(){
		$id = CheckDatas('id', 0);
		empty($id) && $this->error('参数错误');

		$mdl = M('wxhb_password');

		if(IS_POST()){
			$data = $_POST['data'];
			$data['password'] = trim($data['password']);
			empty($data['password']) && $this->error('口令不能为空');
			empty($data['money']) && $this->error('金额不能为空');
			!is_numeric($data['money']) && $this->error('金额必须是数字');
			$money = floatval($data['money']);
			(($money < 1) || ($money > 200)) && $this->error('金额范围为 1~200');
			$data['total'] = intval($data['total']);
			if($mdl->modify($data, array('id'=>$id)) === false){
				$this->error('编辑失败');
			}else{
				$file = SYSTEM_ROOT.'data/weixin_hongbao_password.php';
				$rs = $mdl->getAll(array(), 'id,password', array('id'=>'asc'));
				$list = array();
				foreach($rs as $v){
					$list[$v->password] = $v->id;
				}
				file_put_contents($file, "<?php\r\nreturn ".var_export($list, true).";\r\n?>");
				$this->success('编辑成功', url('WxHongbao'));
			}
		}else{
			$info = $mdl->get(array('id'=>$id), '*', ARRAY_A);
			empty($info) && $this->error('相关信息不存在');

			$this->assign('info', $info);
			$this->renderTpl('wxhb_password_edit');
		}
	}

	public function receiveLog(){
		$param = array();
		$param['starttime'] = CheckDatas('st', '');
        $param['endtime'] = CheckDatas('et', '');
		$persize = 20;
		$page = CheckDatas('p', 1);
        $page = max(1, $page);

		$mdl = M('wxhb_receive_log');
		$cond = array();
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
            $strPage = genPageStr($rs['RecordCount'], $persize, $page, url('WxHongbao', 'receiveLog', $pageUrlParam).'&p', $cfgPage);
            $this->assign('strPage', $strPage);
        }

		$this->assign('param', $param);
		$this->assign('list', $list);
		$this->renderTpl('wxhb_receive_log');
	}
}
?>