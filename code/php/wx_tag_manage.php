<?php
/**
 * 微信标签管理
 */
define('HN1', true);
error_reporting(0);
header("content-type: text/html; charset=utf-8");
session_start();
date_default_timezone_set('Asia/Shanghai');// 设置默认时区

define('SYS_ROOT', dirname(__FILE__).'/');
define('APP_INC', dirname(__FILE__) . '/includes/inc/');
define('LIB_ROOT', dirname(__FILE__) . '/includes/lib/');
define('LOG_INC', dirname(__FILE__) . '/logs/');
define('DATA_ROOT', dirname(__FILE__).'/data/');

include_once(APP_INC.'debug_config.php');
include_once(APP_INC.'functions.php');

//微信相关配置信息(用于微信类)
$wxOption = array(
    'appid' => $app_info['appid'],
    'appsecret' => $app_info['secret'],
    'token' => $app_info['token'] ? $app_info['token'] : 'weixin',
    'encodingaeskey' => $app_info['encodingaeskey'] ? $app_info['encodingaeskey'] : '',
);

include_once(LIB_ROOT.'/Weixin.class.php');
include_once(LIB_ROOT.'/weixin/errCode.php');
$objWX = new Weixin($wxOption);

define('WX_TAG_DIR', DATA_ROOT.'wx/tag/sys/');
!file_exists(WX_TAG_DIR) && mkdir(WX_TAG_DIR, 0777, true);
define('WX_SYS_TAGS_FILE', WX_TAG_DIR.'tags.php');

define('DATA_FILE_DIR', DATA_ROOT.'wx/tag/data/');
!file_exists(DATA_FILE_DIR) && mkdir(DATA_FILE_DIR, 0777, true);

define('URL_BASE', '/wx_tag_manage.php');
define('DATA_FILE_NAME', 'op_data.php');
define('DATA_TAG_USER_FILE', 'user_tag_sortout.php');
$opMenu = array(
	'tag' => '获取已有的标签',
	'new' => '创建新标签',
	'data' => '上传数据文件',
	'sortOut' => '用户按标签归类',
	'batchSet' => '批量给用户设置标签',
);

$act = $_GET['act'];
(in_array($act, array_keys($opMenu)) && !in_array($act, array('sortOut','batchSet'))) && TagManagePage::toManage();
switch($act){
	case 'tag'://获取已有的标签
		TagManagePage::regetTags();
		if(isset($_GET['re']) && $_GET['re'] && file_exists(WX_SYS_TAGS_FILE)) unlink(WX_SYS_TAGS_FILE);
		$tags = getWXTags();
		TagManagePage::tags($tags);
		break;
	case 'new'://创建新标签
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$spe = '@@@@@@';
			$name = str_replace("\r\n", $spe, $_POST['name']);
			$name = str_replace(array("\r","\n"), $spe, $name);
			$names = explode($spe, $name);
			$resultMap = array();
			foreach($names as $_name){
				$result = $objWX->createTag($_name);
				if($result === false){
					$resultMap[$_name] = $objWX->errMsg;
				}
			}
			if(empty($resultMap)){
				header('location:'.URL_BASE.'?act=tag');
			}else{
				TagManagePage::menu('p', 'tag,newtag');
				echo '以下标签创建失败：<br />';
				foreach($resultMap as $k => $v){
					echo '<div>'.$k.'：'.$v.'</div>';
				}
			}
		}else{
			TagManagePage::newTag();
		}
		break;
	case 'delete'://删除标签
		$id = intval($_GET['id']);
		empty($id) && redirect(URL_BASE.'?act=tag', '参数错误');

		$result = $objWX->deleteTag($id);
		if($result === false){
			TagManagePage::toBack();
			echo '<div>删除失败</div><div>错误码：'.$objWX->errCode.'</div><div>原因：'.$objWX->errMsg.'</div>';
		}else{
			header('location:'.URL_BASE.'?act=tag');
		}
		break;
	case 'update'://更改标签
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$url = URL_BASE.'?act=tag';
			$id = intval($_POST['id']);
			$name = trim($_POST['name']);
			empty($id) && redirect($url, '参数错误');
			($name == '') && redirect($url, '请填写标签名称');

			$result = $objWX->updateTag($id, $name);
			if($result === false){
				TagManagePage::toBack();
				echo '<div>修改失败</div><div>错误码：'.$objWX->errCode.'</div><div>原因：'.$objWX->errMsg.'</div>';
			}else{
				header('location:'.$url);
			}
		}else{
			$id = intval($_GET['id']);
			empty($id) && redirect(URL_BASE.'?act=tag', '参数错误');

			$data = array();
			$tags = getWXTags();
			if($tags !== false){
				foreach($tags as $tag){
					if($tag['id'] == $id){
						$data = array('id'=>$tag['id'], 'name'=>$tag['name']);
						break;
					}
				}
			}
			TagManagePage::menu('p', 'tag');
			TagManagePage::updateTag($data);
		}
		break;
	case 'data'://上传数据文件
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$file = $_FILES['file'];
			!$file['size'] && redirect(URL_BASE.'?act=data', '上传失败');
			
			$ext = strtolower(substr($file['name'], strrpos($file['name'], '.')+1));
			($ext != 'csv') && redirect(URL_BASE.'?act=data', '请上传csv文件');

			$dataDir = DATA_FILE_DIR;

			$fileName = date('Y-m-d_H-i-s', time()).'.csv';
			$filepath = $dataDir.$fileName;
			(move_uploaded_file($file['tmp_name'], $filepath) !== true) && redirect(URL_BASE.'?act=data', '上传失败');

			$csvRowStartIndex = intval($_POST['rs'])-1;
			$csvColUidIndex = intval($_POST['ci'])-1;
			$csvColUnameIndex = intval($_POST['cu'])-1;
			$csvColOpenidIndex = intval($_POST['co'])-1;
			$csvColMoneyIndex = intval($_POST['cm'])-1;

			$data = array();
			$csvFile = fopen($filepath, 'r');
			$i = 0;
			while($row = fgetcsv($csvFile)){
				if($i >= $csvRowStartIndex){
					$data[] = array(
						'uid' => $row[$csvColUidIndex],
						'uname' => $row[$csvColUnameIndex],
						'openid' => $row[$csvColOpenidIndex],
						'money' => floatval($row[$csvColMoneyIndex]),
						'setted' => 0,
					);
				}
				$i++;
			}
			fclose($csvFile);

			$dataFile = $dataDir.DATA_FILE_NAME;
			if(file_put_contents($dataFile, "<?php\r\nreturn ".var_export($data, true).";\r\n?>") === false){
				TagManagePage::toBack();
				echo '上传失败';
			}else{
				@unlink(DATA_FILE_DIR.DATA_TAG_USER_FILE);
				redirect(URL_BASE, '上传成功');
			}
		}else{
			TagManagePage::uploadData();
		}
		break;
	case 'sortOut'://用户按标签归类
		$tags = getWXTags();
		($tags === false) && redirect(URL_BASE.'?act=tag', '先设置标签');
		
		$dataFile = DATA_FILE_DIR.DATA_FILE_NAME;
		!file_exists($dataFile) && redirect(URL_BASE, '先上传数据文件');

		$data = include($dataFile);
		empty($data) && redirect(URL_BASE, '先上传数据文件');
        $total = count($data);

		//标签关系映射
		$mapArea = array(
			'华东地区' => array('山东', '江苏', '安徽', '浙江', '福建', '上海'),
			'华南地区' => array('广东', '广西', '海南'),
			'华中地区' => array('湖北', '湖南', '河南', '江西'),
			'华北地区' => array('北京', '天津', '河北', '山西', '内蒙古'),
			'西北地区' => array('宁夏', '新疆', '青海', '陕西', '甘肃'),
			'西南地区' => array('四川', '云南', '贵州', '西藏', '重庆'),
			'东北地区' => array('辽宁', '吉林', '黑龙江'),
		);
		$mapMoney = array(
			'100元以上' => '>100',
			'30元-100元' => '30-100',
			'10元-30元' => '10-30',
			'10元以下' => '<10',
		);
		$mapProvinceArea = array();
		foreach($mapArea as $_area => $_provinces){
			foreach($_provinces as $_pro){
				$mapProvinceArea[$_pro] = $_area;
			}
		}
        $mapReMoney = array_flip($mapMoney);

		$mapTags = array();
        $tagList = array();
		foreach($tags as $v){
			$mapTags[$v['name']] = $v;
            $tagList[$v['id']] = $v;
		}

		$opData = array();
		foreach($data as $k => $v){
			if(!$v['setted']){
				$opData[$k] = $v;
			}
		}

		$sortoutFile = DATA_FILE_DIR.DATA_TAG_USER_FILE;
		$sortoutData = file_exists($sortoutFile) ? include($sortoutFile) : array();

        $opList = array();
        $unopList = array();
		$persize = 50;
		$page = intval($_GET['p']);
		$page = max(1, $page);
		$startIndex = ($page-1)*$persize;
		$endIndex = $startIndex+$persize;
        echo '已归类的数量：'.$startIndex.'<br />';
        if($endIndex < $total - 1){
            $over = false;
            echo '正在归类...<br />';
        }else{
            $over = true;
            $endIndex = $total;
            TagManagePage::toManage();
        }

		for($i=$startIndex; $i<$endIndex; $i++){
			if(!empty($data[$i]['openid'])){
				if($data[$i]['money'] > 100){
                    $tagid = $mapTags[$mapReMoney['>100']]['id'];
                }elseif(($data[$i]['money'] > 30) && ($data[$i]['money'] <= 100)){
                    $tagid = $mapTags[$mapReMoney['30-100']]['id'];
                }elseif(($data[$i]['money'] > 10) && ($data[$i]['money'] <= 30)){
                    $tagid = $mapTags[$mapReMoney['10-30']]['id'];
                }else{
                    $tagid = $mapTags[$mapReMoney['<10']]['id'];
                }
				if($tagid){
					$tmp = $data[$i];
					$tmp['setted'] = 0;
					$sortoutData[$tagid]['users'][] = $tmp;
				}
				$wxUser = $objWX->getUserInfo($data[$i]['openid']);
				if($wxUser !== false){
					$province = $wxUser['province'];
					$tagid = $mapTags[$mapProvinceArea[$province]]['id'];
					if($tagid){
						$tmp = $data[$i];
						$tmp['setted'] = 0;
						$sortoutData[$tagid]['users'][] = $tmp;
					}
				}
			}
		}

        if($over){
			foreach($sortoutData as $_tagid => $v){
				$sortoutData[$_tagid]['setted'] = 0;
			}
            file_put_contents($sortoutFile, "<?php\r\nreturn ".var_export($sortoutData, true).";\r\n?>");
            echo '归类完成<br />';
			echo '<a href="'.URL_BASE.'?act=batchSet">现在去设置</a>';
        }else{
			file_put_contents($sortoutFile, "<?php\r\nreturn ".var_export($sortoutData, true).";\r\n?>");
			echo '<script language="javascript">location.href="'.URL_BASE.'?act=sortOut&p='.($page+1).'";</script>';
        }
		break;
	case 'batchSet'://批量给用户设置标签
		$tags = getWXTags();
		$sortoutFile = DATA_FILE_DIR.DATA_TAG_USER_FILE;
		!file_exists($sortoutFile) && redirect(URL_BASE, '请对数据进行归类');

		$sortoutData = include($sortoutFile);
		empty($sortoutData) && redirect(URL_BASE, '没有要操作的数据');

		$time = time();
        $logDir = LOG_INC.'tag_op/';
        !file_exists($logDir) && mkdir($logDir, 0777, true);
        $logFile = $logDir.'tag_'.date('Y-m-d', $time).'.log';
		$logData = array();

		$page = intval($_GET['p']);
		$page = max(1, $page);

		//每批设置的数量
		$perOpCount = 50;
		$tagTotal = count($tags);
        $tagCount = 0;
		foreach($tags as $_tagIndex => $tag){
			$tagCount++;
			if(isset($sortoutData[$tag['id']])){
				if($sortoutData[$tag['id']]['setted']){
					echo '标签【'.$tag['id'].':'.$tag['name'].'】已完成<br />';
				}else{
					$opCount = 0;
					$tagFinish = true;
					$re = true;
					foreach($sortoutData[$tag['id']]['users'] as $_index => $user){
						if($re){
							$opData = array();
							$opOpenids = array();
						}
						if(!$user['setted']){
							$opCount++;
							$opOpenids[] = $user['openid'];
							$user['index'] = $_index;
							$opData[] = $user;
							if((($opCount >= $perOpCount) && ($opCount % $perOpCount == 0)) || ($opCount == $perOpCount)){
								$re = true;
								if($objWX->memberBatchTag($tag['id'], $opOpenids) === false){
									$tagFinish = false;
									foreach($opData as $v){
										$_user = $sortoutData[$tag['id']]['users'][$v['index']];
										$logData[] = "用户{$_user['uname']}[uid:{$_user['uid']}，openid:{$v['openid']}]设置标签失败，原因：{$objWX->errMsg}[{$objWX->errCode}]";
									}
								}else{
									foreach($opData as $v){
										$sortoutData[$tag['id']]['users'][$v['index']]['setted'] = 1;
										$_user = $sortoutData[$tag['id']]['users'][$v['index']];
										$logData[] = "用户{$_user['uname']}[uid:{$_user['uid']}，openid:{$v['openid']}]设置标签【{$tag['name']}】";
									}
								}
							}else{
								$re = false;
							}
						}
					}
					$tagFinish && $sortoutData[$tag['id']]['setted'] = 1;
				}
				file_put_contents($sortoutFile, "<?php\r\nreturn ".var_export($sortoutData, true).";\r\n?>");
			}
			if(!empty($logData)){
			    file_put_contents($logFile, implode("\r\n", $logData)."\r\n", FILE_APPEND);
            }
			if($page == $tagTotal){
                TagManagePage::toManage();
				echo '完成';
			}else{
				echo '正在设置中...<br />';
				echo '已设置个'.$page.'标签';
				echo '<script language="javascript">location.href="'.URL_BASE.'?act=batchSet&p='.($page+1).'";</script>';
			}
		}
		break;
	default:
		TagManagePage::menu('p');
		break;
}

function getWXTags(){
	global $objWX;

    $reget = false;
	if(file_exists(WX_SYS_TAGS_FILE)){
		$tags = include(WX_SYS_TAGS_FILE);
		empty($tags) && $reget = true;
	}else{
		$reget = true;
	}

	if($reget){
		$tags = $objWX->getTag();
		if($tags === false) die('获取数据失败，code:'.$objWX->errCode.'，msg:'.$objWX->errMsg);
		file_put_contents(WX_SYS_TAGS_FILE, "<?php\r\nreturn ".var_export($tags, true).";\r\n?>");
	}
	return $tags;
}

class TagManagePage{
	static private $urlBase = URL_BASE;

	static public function toManage(){
		echo '<p><a href="'.self::$urlBase.'">返回管理菜单</a></p>';
	}

	static public function toBack(){
		echo '<p><a href="javascript:history.back();">返回上一页</a></p>';
	}

	static public function menu($format=' ', $ops=null){
		global $opMenu;

		$menu = $opMenu;
		$list = array();
		$url = self::$urlBase.'?act=';

		if(!is_null($ops)){
			$ops = explode(',', $ops);
			$tmp = $menu;
			$menu = array();
			foreach($ops as $v){
				$menu[$v] = $tmp[$v];
			}
		}

		foreach($menu as $k => $v){
			$list[] = '<a href="'.$url.$k.'">'.$v.'</a>';
		}
		switch($format){
			case 'p':
				$list = '<p>'.implode('</p><p>', $list).'</p>';
				break;
			case 'div':
				$list = '<div>'.implode('</div><div>', $list).'</div>';
				break;
			default:
				$list = implode($format, $list);
				break;
		}
		echo $list;
	}

	static public function regetTags(){
		echo '<p><a href="'.self::$urlBase.'?act=tag&re=1">重新获取已有标签</a></p>';
	}

	static public function renderGrid($data){
		$html = '<fieldset style="margin-top:20px">';
		$html .= '<legend>'.$data['title'].'</legend>';
		$html .= '<table width="100%" border="1">';
		$html .= '<thead><tr>';
		foreach($data['head'] as $k => $v){
			$html .= '<th>'.$v.'</th>';
		}
		$html .= '</tr></thead>';
		$html .= '<tbody>';
		foreach($data['body'] as $row){
			$html .= '<tr>';
			foreach($data['head'] as $k => $v){
				$html .= '<th>'.$row[$k].'</th>';
			}
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</fieldset>';
		echo $html;
	}

	static public function tags($list){
		self::menu('', 'newtag');
		foreach($list as $k => $v){
			$ops = array(
				'<a href="'.self::$urlBase.'?act=update&id='.$v['id'].'">编辑</a>',
				'<a href="'.self::$urlBase.'?act=delete&id='.$v['id'].'" onClick="javascript:return confirm(\'确定要删除此标签吗？\');">删除</a>',
			);
			$list[$k]['op'] = implode(' ', $ops);
		}
		$data = array(
			'title' => '标签列表',
			'head' => array('id'=>'ID', 'name'=>'名称', 'count'=>'粉丝数量', 'op'=>'操作'),
			'body' => $list,
		);
		self::renderGrid($data);
	}

	static public function newTag(){
		$url = self::$urlBase.'?act=new';
		echo <<<EOF
			<p>
				<form action="{$url}" method="post">
					<fieldset>
						<legend>创建新标签</legend>
						<div>
							<textarea name="name" rows="10" cols="50"></textarea><br />
							注：一行一个名称
						</div>
						<div>
							<input type="submit" name="btn" value="确定创建" />
						</div>
					</fieldset>
				</form>
			</p>
EOF;
	}

	static public function updateTag($data){
		$url = self::$urlBase.'?act=update';
		echo <<<EOF
			<p>
				<form action="{$url}" method="post">
					<input type="hidden" name="id" value="{$data[id]}" />
					<fieldset>
						<legend>修改标签</legend>
						<div>
							标签名：<input type="text" name="name" value="{$data[name]}" />
						</div>
						<div>
							<input type="submit" name="btn" value="确定修改" />
						</div>
					</fieldset>
				</form>
			</p>
EOF;
	}

	static public function uploadData(){
		$url = self::$urlBase.'?act=data';
		echo <<<EOF
			<p>
				<form action="{$url}" method="post" enctype="multipart/form-data">
					<fieldset>
						<legend>上传数据文件(csv文件)</legend>
						<div>
							<input type="file" name="file" />
						</div>
						<div>
							开始的行数：<input type="text" name="rs" value="2" />
						</div>
						<div>
							用户id所在列序号：<input type="text" name="ci" value="1" />
						</div>
						<div>
							用户名所在列序号：<input type="text" name="cu" value="2" />
						</div>
						<div>
							openid所在列序号：<input type="text" name="co" value="3" />
						</div>
						<div>
							金额所在列序号：<input type="text" name="cm" value="4" />
						</div>
						<div>
							<input type="submit" name="btn" value="上传" />
						</div>
					</fieldset>
				</form>
			</p>
EOF;
	}
}
?>