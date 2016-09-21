<?php
if ( !defined('HN1') ) die("no permission");


class sys_loginBean
{
	// 通过用户名和密码获取用户的信息
	function get_user_info( $db, $username, $pwd )
	{
		return $db->get_row("select * from sys_login where loginname='".$username."' and  password = '".$pwd."'");
	}

	function search($db,$page,$per,$type=-1,$status=-1,$condition='',$keys='',$name='',$minfo='',$starttime=0,$endtime=0)
	{
		$sql = "select * from ".SYS_LOGIN_TABLE." where id>0";
		if($type>-1){
			$sql.=" and type ='".$type."'";
		}
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($name!=''){
			$sql.=" and name like '%".$name."%' ";
		}
		if($minfo!='邀请码搜索'){
			$sql.=" and minfo like '%".$minfo."%'";
		}
		if($starttime>0){
			$sql.=" and addTime >=".$starttime;
		}
		if($endtime>0){
			$sql.=" and addTime <=".$endtime;
		}
		//屏蔽掉超级管理员
		$sql .= " and id <> '1'";
		$sql.=" order by sorting asc,id desc";
		//echo $sql;
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function update_telphone($db,$userid,$telephone){
		$sql = "update ".SYS_LOGIN_TABLE." set tel='".$telephone."' where id='".$userid."'";
		$db->query($sql);
		return true;
	}
	function get_excel_results($db,$type,$status,$condition,$keys,$name='',$starttime,$endtime){
		$sql = "select * from ".SYS_LOGIN_TABLE." where id>0";
		if($type>-1){
			$sql.=" and type ='".$type."'";
		}
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($name!=''){
			$sql.=" and name like '%".$name."%'";
		}
		if($starttime>0){
			$sql.=" and addTime >=".$starttime;
		}
		if($endtime>0){
			$sql.=" and addTime <=".$endtime;
		}
		//屏蔽掉超级管理员
		$sql .= " and id <> '1'";
		$sql.=" order by sorting asc,id desc";
		return $db->get_results($sql);
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".SYS_LOGIN_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
	{
		$sql = "select * from ".SYS_LOGIN_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_usernames($db,$username,$pass){
		$sql = "select * from ".SYS_LOGIN_TABLE." where loginname='".$username."' and  password = '".$pass."'";
		//		echo $sql;
		return $db->get_row($sql);
	}

	// 根据用户名查看是否有该用户的记录
	function query_usernames($db,$username)
	{
		$sql = "SELECT count(*) as num  FROM ".SYS_LOGIN_TABLE." WHERE `loginname`='".$username."'";
		return $db->get_row($sql)->num;
	}

	function detail_minfo($db,$minfo=0){
		$sql = "select * from ".SYS_LOGIN_TABLE." where minfo='".$minfo."' order by id desc limit 0,1";
		return $db->get_row($sql);
	}

	/**
	 *	根据微信openid查找相应的用户信息
	 */
	function detail_openid( $db, $openid, $tel="", $unionid="" )
	{
		$strWhere = "";

		if ( $unionid != '' )
		{
			$strWhere .= " AND `unionid`='".$unionid. "' OR `openid`='".$openid."'";
		}
		else
		{
			$strWhere .= " AND `openid`='".$openid. "'";
		}

		if ( $tel != '' )
		{
			$strWhere .= " AND `loginname`='" . $tel . "'";
		}
		$sql = "SELECT * FROM `sys_login` WHERE 1=1 " . $strWhere;
		$rs  = $db->get_row($sql);
		return $rs;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".SYS_LOGIN_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create_openid($openid,$name,$sex,$minfo='',$fminfo='',$db)
	{
		if($name!=null)
		$name="";
		$sql = "insert into ".SYS_LOGIN_TABLE." (status,openid,name,create_by,type,status) values ('1','".$openid."','".$name."','".date('Y-m-d H:i',time())."','1','1',)";

		$KFile='user_txt.txt';
		$KContent=$sql."\n";
		file_put_contents($KFile,$KContent,FILE_APPEND);

		$db->query($sql);
		$uid = $db->insert_id;
		return $uid;
	}
	function create($type,$level,$status,$sorting,$username,$pass,$name,$sex,$birthday,$email,$tel,$phone,$lastaccess,$landing_num,$integral,$invitation_name,$isread,$openid,$addTime,$minfo,$privileges,$db)
	{
		$db->query("insert into ".SYS_LOGIN_TABLE." (type,level,status,sorting,username,pass,name,sex,birthday,email,tel,phone,lastaccess,landing_num,integral,invitation_name,isread,openid,addTime,minfo,privileges) values ('".$type."','".$level."','".$status."','".$sorting."','".$username."','".$pass."','".$name."','".$sex."','".$birthday."','".$email."','".$tel."','".$phone."','".$lastaccess."','".$landing_num."','".$integral."','".$invitation_name."','".$isread."','".$openid."','".$addTime."','".$minfo."','".$privileges."')");
		$uid = $db->insert_id;
		return $uid;
	}

	/*
	 * 	功能：创建用户信息
	 * */
	function create_account($username,$pass,$name,$openid,$type,$db)
	{
		$db->query("insert into ".SYS_LOGIN_TABLE." (loginname,password,name,openid,type,status,create_by,create_date) values ('".$username."','".$pass."','".$name."','".$openid."','".$type."','1','1','".date('Y-m-d h:i',time())."')");
		return true;
	}

	/*
	 * 	功能：创建微信用户信息(只添加openid、name)
	 * */
	function create_weixin_account($name,$openid,$create_by,$unionid,$db)
	{
		$db->query("insert into `sys_login` (name,openid,type,status,create_by,create_date,unionid) values ('".$name."','".$openid."','5','1','{$create_by}','".date('Y-m-d h:i',time())."','".$unionid."')");
		$uid = $db->insert_id;
		return $uid;
	}

	/**
	 * 功能：删除微信临时用户的信息（当用户绑定成功后删除临时信息）
	 */
	 function weixin_account_unbind($openid,$db)
	 {
		$db->query( "DELETE FROM ".SYS_LOGIN_TABLE." WHERE `openid` = '".$openid."' AND `type`='5'" );
		return true;
	 }

	 /**
	  * 功能：根据openid来更新用户的信息（用处：完善用户信息，使其从临时用户转换成普通用户）
	  */
	  function weixin_temp_account_change_public($userid,$loginname,$pwd,$name,$db)
	  {
	  	$sql = "UPDATE ".SYS_LOGIN_TABLE." SET `loginname`='".$loginname."',`password`='".$pwd."',`name`='".$name."',`type`='1' WHERE `id`='".$userid."' AND `type`='5'";
	  	$db->query($sql);
	  	return true;
	  }


	 /**
	  * 功能：根据openid来更新用户的信息（用处：扫描二维码完善用户信息）
	  */
	  function weixin_qrcode($openid,$loginname,$pwd,$name,$db)
	  {
	  	$sql = "UPDATE ".SYS_LOGIN_TABLE." SET `loginname`='".$loginname."',`password`='".$pwd."',`name`='".$name."',`type`='3' WHERE `openid`='".$openid."' AND `type`='5'";
	  	$db->query($sql);
	  	return true;
	  }


	function update($type=-1,$level=-1,$status=-1,$sorting=-1,$username=null,$pass=null,$name=null,$sex=-1,$birthday=null,$email=null,$tel=null,$phone=null,$lastaccess=-1,$landing_num=-1,$integral=-1,$invitation_name=null,$isread=-1,$openid=null,$addTime=-1,$privileges=null,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		if($level>0){
			$update_values.="level='".$level."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($sorting>0){
			$update_values.="sorting='".$sorting."',";
		}
		if($username!=null){
			$update_values.="username='".$username."',";
		}
		if($pass!=null){
			$update_values.="pass='".$pass."',";
		}
		if($name!=null){
			$update_values.="name='".$name."',";
		}
		if($sex>0){
			$update_values.="sex='".$sex."',";
		}
		if($birthday!=null){
			$update_values.="birthday='".$birthday."',";
		}
		if($email!=null){
			$update_values.="email='".$email."',";
		}
		if($tel!=null){
			$update_values.="tel='".$tel."',";
		}
		if($phone!=null){
			$update_values.="phone='".$phone."',";
		}
		if($lastaccess>0){
			$update_values.="lastaccess='".$lastaccess."',";
		}
		if($landing_num>0){
			$update_values.="landing_num='".$landing_num."',";
		}
		if($integral>0){
			$update_values.="integral='".$integral."',";
		}
		if($invitation_name!=null){
			$update_values.="invitation_name='".$invitation_name."',";
		}
		if($isread>0){
			$update_values.="isread='".$isread."',";
		}
		if($openid!=null){
			$update_values.="openid='".$openid."',";
		}
		if($addTime>0){
			$update_values.="addTime='".$addTime."',";
		}
		if($privileges!=null){
			$update_values.="privileges='".$privileges."',";
		}
		$db->query("update ".SYS_LOGIN_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".SYS_LOGIN_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function update_pass($db,$pass,$userid){
		$db->query("update ".SYS_LOGIN_TABLE." set pass='".$pass."' where id='".$userid."'");
		return true;
	}

	function update_integral($db,$integral,$userid){
		$sql = "update ".SYS_LOGIN_TABLE." set integral=integral+'".$integral."' where id='".$userid."'";
		$db->query($sql);
		return true;
	}
	function update_name($db,$name,$id){
		$sql="update ".SYS_LOGIN_TABLE." set name='".$name."' where id=".$id;
		//		echo $sql;
		$db->query($sql);
		return true;
	}

	function change_fminfo($db,$userid,$fminfo){
		$sql = "update ".SYS_LOGIN_TABLE." set fminfo='".$fminfo."' where id='".$userid."'";
		//		echo $sql;
		$db->query($sql);
		return true;
	}

	// 为指定用户绑定微信openid
	function bind_openid($db,$id,$openid,$unionid)
	{
		$sql="UPDATE ".SYS_LOGIN_TABLE." SET `openid`='".$openid."', `unionid`='". $unionid ."' where `id`=".$id;
		$db->query($sql);
		return true;
	}

	// 为指定用户取消绑定微信openid
	function unbind_openid($db,$uid)
	{
		$sql="UPDATE ".SYS_LOGIN_TABLE." SET `openid`='',`unionid`='' where `id`=" . $uid . " AND (`type`=1 OR `type`=3)";
		$db->query($sql);
		return true;
	}

	/**
	 * 修改密码
	 *
	 * @param object $db
	 * @param string $password 新密码
	 * @param string $mobile 手机号
	 * @return boolean
	 */
	public function modifyPassword($db, $password, $mobile){
		$sql = "UPDATE `".SYS_LOGIN_TABLE."` SET `password`='".md5($password)."' WHERE `loginname`='{$mobile}'";
		$db->query($sql);
		return true;
	}
}
?>
