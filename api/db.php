<?php
session_start();
class DB{
    protected $dsn = "mysql:host=localhost; charset=utf8; dbname=db13";
    protected $pdo;
    protected $table;
    static public $type=[
        1 =>'健康新知',  
        2 =>'菸害防治',
        3 =>'癌症防治',
        4 =>'慢性病防治'
    ];

    function __construct($table){
        $this -> table = $table;
        $this -> pdo = new PDO($this->dsn,'root','');
    }

    /**
     * 撈出全部資料
     * 1. 整張資料表
     * 2. 有條件
     * 3. 其他SQL功能
     */
    function all(...$arg){
        $sql = "SELECT * FROM $this->table";
        
        // 有內容
        if(!empty($arg[0])){
            // 是否是陣列
            if (is_array($arg[0])){
                $where = $this->a2s($arg[0]);
                $sql = $sql . " WHERE " . join(" && ",$where);
            } else {
                // $sql = $sql.$arg[0];
                $sql .= $arg[0];
            }
            
        }

        if(!empty($arg[1])){
            $sql = $sql . $arg[1];
        }
        // return $this -> q("SELECT * FROM $this->table");
        return $this->fetchALL($sql);
    }

    function find($id){
        $sql = "SELECT * FROM $this->table ";

        if(is_array($id)){
            $where = $this->a2s($id);
            $sql = $sql . " WHERE " . join(" && ", $where);
        } else {
            $sql .= " WHERE `id` = '$id' ";
        }
        return $this->fetchOne($sql);
    }

    function save($array){
        if(isset($array['id'])){
            //update
            //update table set `欄位1`='值1',`欄位2`='值2' where `id`='值' 
            $id = $array['id'];
            unset($array['id']);
            $set = $this -> a2s($array);
            $sql = "UPDATE $this->table SET " . join(",",$set) . " WHERE `id` = '$id'";
        } else {
            // insert
            $cols = array_keys($array);
            // $values = array_values($array);
            $sql = "INSERT INTO $this->table (`" . join("`,`",$cols) . "`) VALUES ('" . join("','",$array) . "')";
        }
        // dd($array);
        // echo $sql;
        return $this->pdo->exec($sql);
    }


    function del($id){
        $sql = "DELETE FROM $this->table ";

        if(is_array($id)){
            $where = $this->a2s($id);
            $sql = $sql . " WHERE " . join(" && ", $where);
        } else {
            $sql .= " WHERE `id` = '$id' ";
        }
        echo $sql;
        return $this->pdo->exec($sql);
    }

    /**
     * 把陣列轉成條件字串陣列
     */
    function a2s($array){
        $tmp=[];
        foreach ($array as $key => $value) {
            $tmp[]="`$key`='$value'";
            // $tmp[]=sprintf("%s='%s'",$key,$value);
        }
        return $tmp;
    }

    // protected or private 保護但還是能使用
    /**
     * 取得單筆資料
     */
    protected function fetchOne($sql){
        // echo $sql 看對不對
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    
    protected function fetchAll($sql){
        // echo $sql 看對不對
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    }

    // 241202 內建函式可以在class裡面重複
    function max($col,$where=[]){
        return $this->math('max',$col,$where);
    }
    function min($col,$where=[]){
        return $this->math('min',$col,$where);
    }
    function sum($col, $where=[]){
        return $this->math('sum',$col,$where);
    }
    function count($where=[]){
        return $this->math('count','*',$where);
    }
    function avg($col,$where=[]){
        return $this->avg('avg',$col,$where);
    }

    /** 241202
     * math() - 方便使用各種聚合函式
     * @param $math string 要用的函式名稱
     * @param $col string 要獲取的欄位
     * @param $where string 是否有其他條件
     */
    protected function math($math, $col='id',$where=[]){
        $sql = "SELECT $math($col) FROM $this->table";
        if(!empty($where)){
            // $tmp=[];
            $tmp = $this->a2s($where);
            $sql = $sql . " WHERE " . join(" && ", $tmp);
        }
        // echo $sql."<br>";
        // return $this->pdo->query($sql)->fetch();
        return $this->pdo->query($sql)->fetchColumn();
    }
}

// 最萬用的 但要打sql語法
function q($sql){
    $pdo = new PDO("mysql:host=localhost; charset=utf8; dbname=db13",'root','');
    return $pdo -> query($sql) -> fetchAll();
}

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function to($url){
    header("location:$url");
}

// 宣告db
$TOTAL = new DB('total');
$USER = new DB('users');
$NEWS = new DB('news');
$QUE = new DB('que');
$LOG = new DB('log');


if(!isset($_SESSION['view'])){
    if($TOTAL->count(['date'=>date("Y-m-d")])>0){
        $total = $TOTAL->find(['date'=>date("Y-m-d")]);
        $total['total']++;
        $TOTAL->save($total);
    } else {
        $TOTAL->save(['date'=>date("Y-m-d"),'total'=>1]);
    }
    $_SESSION['view']=1;
} 






?>