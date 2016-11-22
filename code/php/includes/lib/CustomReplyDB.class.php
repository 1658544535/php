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

    public $pageSize    = ''; //单页数据显示
    public $totalPage   = ''; //总页数
    public $currentPage = ''; //当前页数

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
INSERT INTO CustomReply (id,event,[key],content,create_time) VALUES (1,'subscribe','sub','{&quot;text&quot;:{&quot;msg&quot;:&quot;欢迎关注我的公众号哟哟哟&quot;}}',1479282098); 
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

    public function update($array, $condition_arr = array())
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

    public function like($array, $type='', $id='')
    {
        foreach ($array as $key=>$val){
            $sql = 'SELECT * FROM ' . $this->table_name . ' WHERE ' . $key . ' like ' . '"% ' . $val . ' %"' ;
        }
        if ($type) $sql.= ' AND event=' . '"' . $type . '"';
        if ($id)   $sql.= ' AND id!=' . '"' . $id . '"';

            $result = $this->query($sql)->fetchArray(SQLITE3_ASSOC);

        return $result;
    }

    /*
     * 分页
     * sql = "select * from tabName where "+条件+" order by "+排序+" limit "+要显示多少条记录+" offset "+跳过多少条记录;
     * $page_size 每页数据数
     * $condition_arr 条件数组
     * 条件查询尚未完成
     */
    public function page($pageSize, $condition_arr = array())
    {
        $sql_condition = createConditionSql($condition_arr); //生成查询条件部分sql

        $this->pageSize    = $pageSize; //单页数据
        $this->totalPage   = $this->getTotalPage(); //总页数
        $this->currentPage = (!isset($_GET['p'])) ? 1 : $_GET['p']; //如果没有接收到p 则设置默认页为1

        if ($this->currentPage > $this->totalPage) $this->currentPage = $this->totalPage;
        if ($this->currentPage < 1) $this->currentPage = 1;

        $sql = 'SELECT * FROM ' . $this->table_name . $sql_condition . ' LIMIT ' . $this->pageSize . ' OFFSET ' . ($this->currentPage-1)*$this->pageSize;

        $result = $this->query($sql);
        while ($row = $result->fetchArray(SQLITE3_ASSOC)){
            $array[] = $row;
        }

        return $array;
    }

    public function getTotalPage()
    {
        $sql    = 'SELECT count(id) FROM ' . $this->table_name;
        $result = $this->query($sql)->fetchArray();
        $count  = $result['count(id)']; //总数据数
        return ceil($count/$this->pageSize);
    }

    public function getPageNav()
    {
        $beforeUrl = $_SERVER["REQUEST_URI"]; //之前的url
        $check = strpos($beforeUrl, '?');
        if ($check) {
            if (substr($beforeUrl, $check+1) == '') {
                $firstUrl = $beforeUrl . 'p=1';
            } else {
                if (isset($_GET['p'])) {
                    unset($_GET['p']);
                    $beforeUrl ='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.http_build_query($_GET);
                }
                $firstUrl = $beforeUrl . '&p=1'; //首页
                $preUrl   = $beforeUrl . '&p=' . ($this->currentPage-1);
                $nextUrl  = $beforeUrl . '&p=' . ($this->currentPage+1);
                $endUrl   = $beforeUrl . '&p=' . $this->totalPage;
            }
        } else {
            $firstUrl = $beforeUrl . '?p=1'; //首页
            $preUrl   = $beforeUrl . '?p=' . ($this->currentPage-1);
            $nextUrl  = $beforeUrl . '?p=' . ($this->currentPage+1);
            $endUrl   = $beforeUrl . '?p=' . $this->totalPage;
        }

        //分页样式
        return '  
        <div class="page">  
            <a>【共'.$this->totalPage.'页，第'.$this->currentPage.'页】</a>  
            <a href="' . $firstUrl .'">首页</a>  
            <a href="' . $preUrl   .'">上一页</a>  
            <a href="' . $nextUrl  .'">下一页</a>  
            <a href="' . $endUrl   .'">末页</a>  
        </div>  
        ';
    }

    public function count()
    {
        
    }
    /*
     * 获取指定种类的自定义回复内容
     */
    public function getSpecifyData($type)
    {

    }

}

