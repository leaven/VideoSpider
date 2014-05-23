<?php
/**
 *  @file fetchUrl
 *  @author liwei
 *  @date 2013/11/21
 *  @function fetch every url in table site
 */

    include("../db/DBHelper.class.php");
    class fetchUrl{
        private $db;
        public function __construct(){
            $this->db = new DBHelper();
            $this->db->selectDB("VideoSite");
            $this->fetchSite();
        }
        //获取未爬取的站点
        public function getUnFetchUrl(){
            $selSql = "select siteid, siteurl from site where sitefetch=0";
            $unFetchSites = $this->db->select($selSql);
            return $unFetchSites;
        }
        //爬取站点获取视频url
	public function fetchSite(){
	    $sites = $this->getUnFetchUrl();
	    for($i = 0, $len = count($sites); $i < $len; $i++){
		$html = @file_get_contents("compress.zlib://".$sites[$i]["siteurl"]);
		$html=iconv("gbk","UTF-8",$html);
		 preg_match_all("/<a.*title=\"(.*)\".*href=\"(http:\/\/tv\.sohu\.com\/\d{8}\/n\d*\.shtml)\"/U",$html,$match);
		for($j = 0, $length = count($match[0]); $j < $length; $j++){
			$sql = "insert into video (videoname,videourl,siteid) values('".$match[1][$j]."','".$match[2][$j]."',".$sites[$i]['siteid'].")";
			$this->db->query($sql);
		}
	    }
	/* $sites = $this->getUnFetchUrl();
	    $foods =array();
	    for ($i = 0, $len = count($sites); $i < $len; $i++) {
                $html = @file_get_contents($sites[$i]["siteurl"]);
		//preg_match("/var\s*menu\s*=(.*\];)/u",$html,$match);
		$match[1] = substr($match[1],0,strlen($match[1])-1);  //去除逗号
		$match[1] = preg_replace("/\&quot;*//*","",$match[1]);
		$foods[] = json_decode($match[1],true);
		for($j = 0, $length = count($foods[$i]);$j < $length; $j++){
		foreach($foods[$i][$j]["foods"] as $foodskey=>$foodsitem){	
                if ($foodsitem["name"] && $foodsitem["price"]){
                    $foodsitem["siteid"] = $sites[$i]["siteid"];
	 	    //img 标签绝对路径化   
		    if ($foodsitem["img"] != ""){
			    $foodsitem["img"] ="http://fuss10.elemecdn.com".$foodsitem["img"];
			}
                $sql = 'insert into food (foodname,foodprice,foodrating,foodratingCount,foodDescription,foodsales,foodImg,siteid) values("'
.$foodsitem["name"].'",'.$foodsitem["price"].','.$foodsitem["rating"].','.$foodsitem["ratingCount"].',"'.$foodsitem["description"].'",'.$foodsitem["sales"].',"'.$foodsitem["img"].'",'.$foodsitem["siteid"].')';
                $this->db->query($sql);
                $siteupdateSql ="update site set sitefetch=1 where siteid=".$foodsitem["siteid"];
                $this->db->query($siteupdateSql);       
		}else{
                    unset($foodsitem);
		}
		}
		}
	    }*/
	}
    
    }
    $fetchsite = new fetchUrl();
?>
