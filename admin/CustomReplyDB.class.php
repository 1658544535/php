<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/12 0012
 * Time: 11:42
 */
define('DATA_DIR', '../data/wx/'); //数据保存的位置

include_once('functions.php');

class CustomReplyDB extends SQLite3
{
    private $CustomReply_db = DATA_DIR . 'CustomReply.db'; // text 类型的自定义回复数据文件
    private $DB_TableName_arr = array
    (
        'text'  => 'CustomTextReply',
        'image' => 'CustomImgReply',
        'event' => 'CustomEventReply',
    );

    function __construct()
    {
        //判断数据文件是否存在，不存在则进行创建
        if (!file_exists($this->CustomReply_db)){ //初始化新建
            $this->open($this->CustomReply_db);
            $this->createTextReplyDB();
            $this->createEventReplyDB();
        } else {
            $this->open($this->CustomReply_db);
        }
    }

    /*
     * 初始化创建数据表
     * 目前只有text event
     */
    private function createTextReplyDB()
    {
        $sql = <<<EOF
--
-- 由SQLiteStudio v3.1.1 产生的文件 周一 十一月 14 17:06:09 2016
--
-- 文本编码：System
--
PRAGMA foreign_keys = off;
BEGIN TRANSACTION;

-- 表：CustomTextReply
CREATE TABLE CustomTextReply (
    id          INTEGER   PRIMARY KEY AUTOINCREMENT
                          NOT NULL,
    keyword     CHAR (80) NOT NULL,
    content     TEXT,
    create_time INT       NOT NULL
);


COMMIT TRANSACTION;
PRAGMA foreign_keys = on;

EOF;
        $this->exec($sql);
    }
    private function createEventReplyDB()
    {
        $sql = <<<EOF
--
-- 由SQLiteStudio v3.1.1 产生的文件 周一 十一月 14 17:05:49 2016
--
-- 文本编码：System
--
PRAGMA foreign_keys = off;
BEGIN TRANSACTION;

-- 表：CustomEventReply
CREATE TABLE CustomEventReply (
    id          INTEGER      PRIMARY KEY AUTOINCREMENT
                             NOT NULL,
    event       VARCHAR (60) NOT NULL,
    content     TEXT,
    create_time INT          NOT NULL
);


COMMIT TRANSACTION;
PRAGMA foreign_keys = on;
EOF;
        $this->exec($sql);
    }

    /*
     * 判断自动回复表中是否存在相同关键字
     * $type 是接收到的关键字类型
     * 若有存在则返回
     */
//    public function checkExistKeyword($condition_arr, $type)
//    {
//        $sql_condition = createConditionSql($condition_arr); //查询条件部分sql
//        $table_name = $this->DB_TableName_arr[$type];
//        $sql = 'SELECT * FROM ' . $table_name . $sql_condition;
//        $result = $this->query($sql);
//        var_dump($result);
//        if ($result) {
//            return array('status'=>1,'info'=>'已存在相同关键字');
//        }
//    }

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

    public function update($array, $type, $condition_arr = '')
    {
        $sql_condition = createConditionSql($condition_arr); //查询条件部分sql
        $table_name = $this->DB_TableName_arr[$type];
        $lastArr = getLastArr($array);
        array_pop($array); //最后的值出栈

        $sql_part = '';
        foreach ($array as $k => $v) {
            $sql_part = $sql_part . $k . '=' . '"' . $v . '",';
        }
        $sql_part = $sql_part . $lastArr["key"] . '=' . '"' . $lastArr["val"] . '"';

        $sql = 'UPDATE '. $table_name . ' SET ' . $sql_part . $sql_condition;
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

    /*
     * 搜索方法 传入数组
     * $array = array('要搜索的字段名' => '要搜索的字段的值');
     */
    public function find($condition_arr, $type)
    {
        $sql_condition = createConditionSql($condition_arr); //查询条件部分sql
        $table_name = $this->DB_TableName_arr[$type];
        $sql = 'SELECT * FROM ' . $table_name . $sql_condition;
        $result = $this->query($sql)->fetchArray(SQLITE3_ASSOC);
        return $result;
    }

}

