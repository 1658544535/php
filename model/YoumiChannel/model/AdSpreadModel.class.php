<?php

class AdSpreadModel extends Model{

    public function __construct($db, $table='')
    {
        $table = 'ad_spread';
        parent::__construct($db, $table);
    }


}
?>