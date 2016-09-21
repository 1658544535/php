<?php

class UmengChannelModel extends Model
{
     public function __construct($db, $table=''){
        $table = 'umeng_channel';
        parent::__construct($db, $table);
    }

}
?>