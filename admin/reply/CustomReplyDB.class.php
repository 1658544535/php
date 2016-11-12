<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/12 0012
 * Time: 11:42
 */
define('DATA_DIR', '../../data/wx/'); //数据保存的位置

class CustomReplyDB extends SQLite3
{
    private $CustomReply_db = DATA_DIR . 'CustomReply.db'; // text 类型的自定义回复数据文件
    private $DB_TableName_arr = array
    (
        'text' => 'CustomTextReply',
        'image' => 'CustomImgReply',
    );

    public $keyword = '';
    public $content = '';

    function __construct()
    {
        if (!file_exists($this->CustomReply_db)){ //初始化新建
            $this->open($this->CustomReply_db);
            $sql = <<<EOF
                CREATE TABLE CustomTextReply (
                    id          INTEGER   PRIMARY KEY AUTOINCREMENT
                                          NOT NULL,
                    keyword     CHAR (80) NOT NULL,
                    content     TEXT      NOT NULL,
                    create_time INT       NOT NULL
                );
                COMMIT TRANSACTION;
                PRAGMA foreign_keys = on;
EOF;
            $this->exec($sql);
        }
        $this->open($this->CustomReply_db);
    }

    /*
     * 判断自动回复表中是否存在相同关键字
     * $type 是接收到的关键字类型
     * 若有存在则返回
     */
    public function checkExistKeyword($keyword, $type)
    {
        $table_name = $this->DB_TableName_arr[$type];
        $sql = 'SELECT * FROM ' . $table_name . ' WHERE keyword = "' . $keyword .'"' ;
        $result = $this->exec($sql);
        if ($result) {
            return array('status'=>1,'info'=>'已存在相同关键字');
        }
    }

    public function insert($array, $type)
    {
        $lastArr = getLastArr($array); //获得最后的键和值
        array_pop($array); //最后的值出栈

        $column_val_sql = '';
        $column_key_sql = '';
        $table_name = $this->DB_TableName_arr[$type];

        //循环创建sql部分语句
        foreach ($array as $k => $v) {
            $column_key_sql = $column_key_sql . $k . ",";
        }
        foreach ($array as $k => $v) {
            $column_val_sql = $column_val_sql . '"' . $v . '"' . ",";
        }

        //sql 语句组装
        $column_key_sql = $column_key_sql . $lastArr['key'];
        $column_val_sql = $column_val_sql . '"' . $lastArr['val']. '"';
        $sql = 'INSERT INTO ' . $table_name . ' ('. $column_key_sql .') values ('. $column_val_sql .')';

        if ($this->exec($sql)) {
            return array('status'=>1,'info'=>'insert success!');
        } else {
            return array('status'=>0,'info'=>$this->lastErrorMsg());
        }
    }

    public function update($id, $array, $type)
    {
        $table_name = $this->DB_TableName_arr[$type];

        $lastArr = getLastArr($array);
        array_pop($array); //最后的值出栈

        $sql_part = '';
        foreach ($array as $k => $v) {
            $sql_part = $sql_part . $k . '=' . '"' . $v . '",';
        }
        $sql_part = $sql_part . $lastArr["key"] . '=' . '"' . $lastArr["val"] . '"';

        $sql = 'UPDATE '. $table_name . ' SET ' . $sql_part . " WHERE ID=" . $id;
        $result = $this->exec($sql);

        if ($result) {
            return array('status'=>1,'info'=>'操作成功');
        } else {
            return array('status'=>0,'info'=>$this->lastErrorMsg());
        }

    }

    public function getAll($type)
    {
        $table_name = $this->DB_TableName_arr[$type];
        $sql = 'SELECT * FROM ' . $table_name;

        $result = $this->query($sql);
        $array = '';
        //处理sqlite数据
        while ($result->fetchArray(SQLITE3_ASSOC)){
            $arrays[] = $result;
        }
        if (!empty($arrays)){
            foreach ($arrays as $k => $v) {
                $array[] = $v->fetchArray(SQLITE3_ASSOC);
            }
        }
        return $array;
    }

    public function delete($id, $type)
    {
        $table_name = $this->DB_TableName_arr[$type];
        $sql = 'DELETE from ' . $table_name . ' WHERE id=' .$id;
        $result = $this->exec($sql);
        if ($result) {
            return array('status'=>1,'info'=>'操作成功');
        } else {
            return array('status'=>0,'info'=>$this->lastErrorMsg());
        }
    }

    public function find($id, $type)
    {
        $table_name = $this->DB_TableName_arr[$type];
        $sql = 'SELECT * FROM ' . $table_name . ' WHERE id=' .$id;
        echo $sql;
        $result = $this->query($sql)->fetchArray(SQLITE3_ASSOC);
        return $result;
    }

}


/*
 * 获取传过来的数组的最后的键值
 */
function getLastArr($array){
    $val = end($array);
    $key = key($array);
    return array('key' => $key, 'val'=>$val);
}
