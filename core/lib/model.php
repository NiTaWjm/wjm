<?php
/**
 * 总的model类
 */
namespace core\lib;
class model extends \PDO {
    protected $field = '*';
    protected $where = '';
    protected $table;
    protected $limit = '';
    protected $orderBy = '';
    protected $group = '';
    protected $link = [];
    protected $fieldInfo = array();


    public function __construct()
    {
        $config = new \core\lib\config();
        $config = $config->get('db');
        $dsn = "mysql:host=$config[HOST];dbname=$config[DATABASE]";
        $username = $config['USER'];
        $passwd = $config['PASSWD'];
        try {
            parent::__construct($dsn, $username, $passwd);
            \PDO::exec("SET NAMES 'utf8';");
        } catch (\PDOException $e) {
            dd($e->getMessage());
        }
    }
    /**
     *
     * 连贯方法操作只获取一些字段
     *
     */
    public function field ($field) {
        $this -> field = $field;
        return $this;
    }
/*
 *
 * where条件
 */
    public function where ($where) {
        $this -> where = ' where ' . $where;
        return $this;
    }

    /*
     *
     * limit 限制
     */
    public function limit($limit)
    {
        $this -> limit = ' limit '.$limit;
        return $this;
    }

    /*
     *
     * 排序
     */
    public function order($field,$sc = 'asc') {
        $this -> orderBy = ' order by ' . $field . ' ' .$sc;
        return $this;

    }

    /*
     * 分组
     *
     */
    public function group($group)
    {
        $this -> group = ' group by '.$group;
        return $this;

    }

    public function having ($where) {
        $this -> where = ' having ' . $where;
        return $this;
    }

    /*
    *
    * 连表的东西，在父类的构造函数中调用
    */
    protected function link($table , $cfield , $pfield)
    {

        $bool = \core\lib\config::get('db','LINK');
        if ($bool == true) {
            $table = '\app\model\\' . $table;
            $this->link[] = new $table();
            $this->fieldInfo[] = array('pfield' => $pfield, 'cfield' => $cfield);
        }
    }


    /*
     *
     * 每次调用增删该查都会调用这个方法
     */


    public function _link($link) {
        foreach ($this -> fieldInfo as $key => $value) {
            $sql = $sql = 'select ' . $value['pfield'] . ' from ' . $link[$key]->table;
            $sql1 = 'select ' . $value['cfield'] . ' from ' . $this->table . $this->group . $this->where . $this->orderBy . $this->limit;
            $data[] =
                array('pfield' => $link[$key]->query($sql)->fetchAll(\PDO::FETCH_COLUMN))
                    +
                array('cfield' => $this->query($sql1)->fetchAll(\PDO::FETCH_COLUMN));
        }

        foreach ($data as $key => $value) {
            $cfield = array_unique($value['cfield']);
            foreach ($cfield as $ke => $val) {
                if (!in_array($val,$value['pfield'])) {
                    return false;
                }
            }
            return true;
        }
    }


    /*
     *
     * 获取所有结果
     */
    public function findAll()
    {
        $sql = 'select ' . $this->field . ' from ' . $this->table .$this -> group. $this->where. $this->orderBy . $this->limit;
        echo $sql."<br />";
        $data = $this->query($sql);
        $fetchAll = $data->fetchAll(\PDO::FETCH_ASSOC);
        if (!empty($this ->fieldInfo)) {
            if ($this->_link($this->link)) {
               return $fetchAll;
            } else {
                throw new \Exception('数据库不完整');
            }
        }
    }

    /*
     * 获取一个
     */
    public function find()
    {
        $sql = 'select ' . $this->field . ' from ' . $this->table  . $this->where . $this->orderBy . $this->limit;
        $data = $this -> query($sql);
        return $data -> fetch(\PDO::FETCH_ASSOC);
    }

}