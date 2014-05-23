<?php
/**
 * @file  VideoSiteDB.php
 * @author liwei
 * @date 2013/11/20
 * @description  create tables
 */
include ("DBHelper.class.php");
class VideoSiteDB{
    private $db = "";
    public function __construct($param){
        $this->db = new DBHelper();
        $this->db->selectDB("VideoSite");
        $this->createSite($param["site"]);
   	$this->createVideo($param["video"]);
    }

    public function createUser($tbName){
        $this->db->tableExist($tbName);
        $userSql = "create table ".$tbName."(
                userid int auto_increment not null primary key,
                username char(20) not null ,
                userpassword char(128) not null,
                unique (username),
                key userid (userid)
            )ENGINE=InnoDB default charset=utf8 auto_increment=1";
         $this->db->query($userSql);
    }
    public function createSite($tbName){
        $this->db->tableExist($tbName);
        $siteSql="create table ".$tbName."(
            siteid int auto_increment not null primary key,
            sitename varchar(100) not null,
            siteurl varchar(100) not null,
            sitefetch bool  default false,
            unique (sitename),
            key  (siteid)
        )ENGINE=InnoDB default charset=utf8 auto_increment=1";
        $this->db->query($siteSql);
    }
    public function createVideo($tbName){
        $this->db->tableExist($tbName);
        $videoSql="create table ".$tbName."(
            videoid int auto_increment not null primary key,
            videoname varchar(100)  null,
	    videourl varchar(100) not null,
	    videosource varchar(100)  null,
	    siteid int not null,
            key (videoid),
            foreign key (siteid) references site (siteid)
            on delete cascade
            on update cascade
        )ENGINE=InnoDB default charset=utf8 auto_increment=1";
        $this->db->query($videoSql);
    }
    public function createOrder($tbName){
        $this->db->tableExist($tbName);
        $orderSql = "create table ".$tbName."(
            orderid int auto_increment not null primary key,
            userid int not null,
            foodid int not null,
            key (orderid),
            foreign key (userid) references user (userid) 
            on delete cascade 
            on update cascade,
            foreign key (foodid) references food (foodid)
            on delete cascade
            on update cascade
        )ENGINE=InnoDB default charset=utf8 auto_increment=1";
         $this->db->query($orderSql);
    }
    
}
 $videoSite = new VideoSiteDB(array("site"=>"site","video"=>"video"));

?>
