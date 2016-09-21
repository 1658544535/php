<?php
if ( !defined('HN1') ) die("no permission");


class feedbackBean extends Db
{
	public function __construct( $db, $table )
    {
        parent::__construct( $db, $table );
        $this->conn = $db;
    }

    public function __get( $key )
    {
        return $this->$key;
    }

    public function __set( $key, $val )
    {
        $this->$key = $val;
    }

//	function create($type,$content,$emall,$telephone,$db)
//	{
//		$sql=$db->query("insert into ".FEEDBACK_TABLE." (type,content,emall,telephone,create_time) values ('".$type."','".$content."','".$emall."','".$telephone."','".time()."')");
//		return true;
//	}

}
?>
