<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/11/12 0012
 * Time: 11:42
 */
class CustomReplyDB extends SQLite3
{
    protected $CustomReply_db; // sqlite数据库文件
    protected $DB_TableName_arr = array
    (
        'text'  => 'CustomTextReply',
        'image' => 'CustomImgReply',
        'event' => 'CustomEventReply',
    );
    protected $table_name = 'CustomReply';

    function __construct()
    {
        $this->CustomReply_db = DATA_DIR . 'CustomReply.db';
        //判断数据文件是否存在，不存在则初始化并新建数据库
        if (!file_exists($this->CustomReply_db)){
            $this->open($this->CustomReply_db);
            $this->initializeDB();
        } else {
            $this->open($this->CustomReply_db);
        }
    }

    /*
     * 初始化创建数据表
     */
    private function initializeDB()
    {
        $sql = <<<EOF
        --
-- 由SQLiteStudio v3.1.1 产生的文件 周四 十一月 17 14:43:40 2016
--
-- 文本编码：System
--
PRAGMA foreign_keys = off;
BEGIN TRANSACTION;
-- 表：CustomReply
CREATE TABLE CustomReply (
    id          INTEGER      PRIMARY KEY AUTOINCREMENT,
    event       VARCHAR (60) NOT NULL,
    [key]       VARCHAR (60) NOT NULL,
    content     TEXT         NOT NULL,
    create_time INT          NOT NULL
);
-- 插入默认的订阅回复
INSERT INTO CustomReply (id,event,[key],content,create_time) VALUES (1,'subscribe','sub','欢迎关注我的公众号',1479282098); 
COMMIT TRANSACTION;
PRAGMA foreign_keys = on;

EOF;
        $this->exec($sql);
    }


    public function insert($array)
    {
        $lastArr = getLastArr($array); //获得最后的键和值
        array_pop($array); //最后的值出栈

        $column_val_sql = '';
        $column_key_sql = '';

        //循环创建sql部分语句
        foreach ($array as $k => $v) {
            $column_key_sql = $column_key_sql . $k . ',';
        }
        foreach ($array as $k => $v) {
            $column_val_sql = $column_val_sql . '"' . $v . '"' . ",";
        }

        //sql 语句组装
        $column_key_sql = $column_key_sql . $lastArr['key'];
        $column_val_sql = $column_val_sql . '"' . $lastArr['val']. '"';
        $sql = 'INSERT INTO ' . $this->table_name . ' ('. $column_key_sql .') values ('. $column_val_sql .')';

        if ($this->exec($sql)) {
            return array('status'=>1,'info'=>'insert success!');
        } else {
            return array('status'=>0,'info'=>$this->lastErrorMsg());
        }
    }

    public function update($array, $condition_arr = '')
    {
        $sql_condition = createConditionSql($condition_arr); //查询条件部分sql
        $lastArr = getLastArr($array);
        array_pop($array); //最后的值出栈

        $sql_part = '';
        foreach ($array as $k => $v) {
            $sql_part = $sql_part . $k . '=' . '"' . $v . '",';
        }
        $sql_part = $sql_part . $lastArr["key"] . '=' . '"' . $lastArr["val"] . '"';

        $sql = 'UPDATE '. $this->table_name . ' SET ' . $sql_part . $sql_condition;
        $result = $this->exec($sql);

        if ($result) {
            return array('status'=>1,'info'=>'操作成功');
        } else {
            return array('status'=>0,'info'=>$this->lastErrorMsg());
        }

    }

    public function getAll($type='')
    {
        $sql = 'SELECT * FROM ' . $this->table_name;
        if ($type) $sql = $sql . ' WHERE "event"=' . '"' . $type . '"';;

        $result = $this->query($sql);
        $array = array();
        //处理sqlite数据
        while ($row = $result->fetchArray(SQLITE3_ASSOC)){
            $array[] = $row;
        }
        return $array;
    }

    public function delete($id)
    {
        $sql = 'DELETE from ' . $this->table_name . ' WHERE id=' .$id;
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
    public function find($condition_arr)
    {
        $sql_condition = createConditionSql($condition_arr); //查询条件部分sql
        $sql = 'SELECT * FROM ' . $this->table_name . $sql_condition;
        $result = $this->query($sql)->fetchArray(SQLITE3_ASSOC);
        return $result;
    }

    /*
     * 获取指定种类的自定义回复内容
     */
    public function getSpecifyData($type)
    {

    }

}

