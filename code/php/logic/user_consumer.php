<?php
if ( !defined('HN1') ) die("no permission");


class user_consumerBean
{
	/*
	 *
	 * */
	function qrcode($user_id,$phone,$db)
	{
		$date = date('Y-m-d H:i:s', time());
		$db->query("insert into `user_consumer` (`user_id`,`contact`,`tel`,`phone`,`create_by`,`create_date`) values ('".$user_id."','".$phone."','".$phone."','".$phone."','".$user_id."',NOW())");
		$uid = $db->insert_id;
		return $uid;
	}

	function abc($db,$id)
	{
		$sql = "select * from ".USER_CONSUMER_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function search($db,$page,$per,$type=-1,$status=-1,$condition='',$keys='',$name='',$minfo='',$starttime=0,$endtime=0)
	{
		$sql = "select * from ".USER_CONSUMER_TABLE." where id>0";
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
		$sql = "update ".USER_CONSUMER_TABLE." set tel='".$telephone."' where id='".$userid."'";
		$db->query($sql);
		return true;
	}
	function get_excel_results($db,$type,$status,$condition,$keys,$name='',$starttime,$endtime){
		$sql = "select * from ".USER_CONSUMER_TABLE." where id>0";
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
		$sql = "select * from ".USER_CONSUMER_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
	{
		$sql = "select * from ".USER_CONSUMER_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_username($db,$username,$phone,$email){
		$sql = "select * from ".USER_CONSUMER_TABLE." where (username='".$username."' or phone='".$phone."' or email='".$email."')";
		return $db->get_row($sql);
	}

	function detail_minfo($db,$minfo=0){
		$sql = "select * from ".USER_CONSUMER_TABLE." where minfo='".$minfo."' order by id desc limit 0,1";
		return $db->get_row($sql);
	}

	function detail_openid($db,$openid){
		$sql = "select * from ".USER_CONSUMER_TABLE." where openid='".$openid."'";
		return $db->get_row($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".USER_CONSUMER_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create_openid($openid,$name,$sex,$minfo='',$fminfo='',$db)
	{
		if($name!=null)
			$name="";
		$sql = "insert into ".USER_CONSUMER_TABLE." (status,openid,name,sex,addTime,minfo,fminfo) values ('1','".$openid."','".$name."','".intval($sex)."','".time()."','".$minfo."','".$fminfo."')";

			$KFile='user_txt.txt';
			$KContent=$sql."\n";
			file_put_contents($KFile,$KContent,FILE_APPEND);

		$db->query($sql);
		$uid = $db->insert_id;
		return $uid;
	}

	function create($type,$level,$status,$sorting,$username,$pass,$name,$sex,$birthday,$email,$tel,$phone,$lastaccess,$landing_num,$integral,$invitation_name,$isread,$openid,$addTime,$minfo,$privileges,$db)
	{
		$db->query("insert into ".USER_CONSUMER_TABLE." (type,level,status,sorting,username,pass,name,sex,birthday,email,tel,phone,lastaccess,landing_num,integral,invitation_name,isread,openid,addTime,minfo,privileges) values ('".$type."','".$level."','".$status."','".$sorting."','".$username."','".$pass."','".$name."','".$sex."','".$birthday."','".$email."','".$tel."','".$phone."','".$lastaccess."','".$landing_num."','".$integral."','".$invitation_name."','".$isread."','".$openid."','".$addTime."','".$minfo."','".$privileges."')");
		$uid = $db->insert_id;
		return $uid;
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
		$db->query("update ".USER_CONSUMER_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_CONSUMER_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function update_pass($db,$pass,$userid){
		$db->query("update ".USER_CONSUMER_TABLE." set pass='".$pass."' where id='".$userid."'");
		return true;
	}

	function update_integral($db,$integral,$userid){
		$sql = "update ".USER_CONSUMER_TABLE." set integral=integral+'".$integral."' where id='".$userid."'";
		$db->query($sql);
		return true;
	}
function update_name($db,$name,$id){

		$sql="update user set name='".$name."' where id=".$id;
		$db->query($sql);
		return true;
	}
	function change_fminfo($db,$userid,$fminfo){
		$sql = "update ".USER_CONSUMER_TABLE." set fminfo='".$fminfo."' where id='".$userid."'";
//		echo $sql;
		$db->query($sql);
		return true;
	}


}
?>
