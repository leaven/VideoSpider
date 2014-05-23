<?php
/**
 * @file DBHelper.class.php
 * @author liwei
 * @date 2013/11/20
 * function db help
 */

	class DBHelper{
		public $dbhosts = "cq01-ocean-centos-001.cq01.baidu.com:8043";
		public $username = "liwei";
		public $userpassword = "videofe";
		public $con ;
		public $dbname;
		public function  __construct(){
			$this->con = mysql_connect($this->dbhosts, $this->username, $this->userpassword);
			if (!$this->con){
				die("Counld not connect: ".mysql_error());
			}
		}
		public function selectDB($name){
			if(!mysql_select_db($name,$this->con)){
				$sql = "create database ".$name;
				if(!$this->query($sql)){
					echo "create failed\n";
				}
			}
        }
        public function tableExist($tbName){
            $sql = "drop table if exists ".$tbName;
            $this->query($sql);
        }
        //增
        public function add($arrayValue,$tbName,$dbName=NULL){
            if($dbName)
                selectDB($dbName);
           // foreach($arrayValue as $k=>$v){
           //     $key =$k.',';
           // }
           // $sql = "insert into ".$tbName;
        }
        //删
        public function del($arrayValue,$tbName,$dbName=NULL){
        
        }
        //改
        public function set($arrayValue,$tbName,$dbName=NULL){
        
        }
        //查
        //public function select($arrayValue,$tbName,$dbName=NULL){
        
        
        //}
        public function select($sql){
            $result = $this->query($sql);
            if ($result){
                $results = array();
                while($row = mysql_fetch_assoc($result)){
                    $results[] =$row;
                }
            }
            return $results;
        }
        public function query($sql){
            $result = mysql_query($sql,$this->con);
            if ($result){
                return $result;
            }else{
                echo mysql_error();
                return null;
            }
        } 
        public function close(){
            mysql_close($this->con);
        }
	}
?>
