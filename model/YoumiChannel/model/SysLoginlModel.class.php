<?php

class SysLoginlModel extends Model{

    public function __construct($db, $table=''){
        $table = 'sys_login';
        parent::__construct($db, $table);
    }


}
?>