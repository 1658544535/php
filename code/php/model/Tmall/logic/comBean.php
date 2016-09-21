<?php
if ( !defined('HN1') ) die("no permission");

require_once APP_INC . 'db.php';

class comBean extends Db{
    public function __construct( $db, $table='' )
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
}