<?php
/**
 * @file webspider.php
 * @author liwei
 * @date 2013/11/20
 * @description get all the links in the website 
 */



    include("../common/env.php");
    include("../db/DBHelper.class.php");
    class WebSpider{
	private $db;
        private $urls = array();
        private $links = array();
        public function __construct(){
	    $this->db = new DBHelper();
	     $this->db->selectDB("VideoSite");	
	    $this->getAllsites();
          //  $this->getAllLinks();
                
           // $this->filterLinks();
            // $this->printValue();    
        
        }
        //从配置文件获取所有站点信息
        public function getAllSites(){
            $file =fopen(WEBSITE_PATH,"r");
            while(!feof($file)){
                $line = fgets($file);
		if($line != NULL){
		//去除conf中的多余空格
		$line = preg_replace('/\s+/'," ",$line);	
		$this->urls=explode(" ",$line);
		$selSql ="select siteid from site where siteurl='".$this->urls[0]."'";
		var_dump($this->db->select($selSql));
		if(!$this->db->select($selSql)){
			echo $selSql;
			$addSql ="insert into site (sitename,siteurl) values('".$this->urls[1]."','".$this->urls[0]."')";
			$this->db->query($addSql);
		}
		} 
	    }
        }
        //获取所有url链接
        public function getAllLinks(){
            for ($i = 0, $len = count($this->urls); $i < $len; $i++){
            
                //gzip乱码解决办法
                $html = file_get_contents("compress.zlib://".$this->urls[$i]);
                //links with '/' first
             //   preg_match_all('/href="\/([a-zA-Z\-]+)"[^>]*>([^<]*)</',$html,$this->links[]);
		$html = iconv("gbk","UTF-8",$html); 
	      	preg_match_all("/<a.*title=\"(.*)\".*href=\"(http:\/\/tv\.sohu\.com\/\d+\/n\d*\.shtml)\"/U",$html,$match);	
		for($j = 0, $length = count($match[0]); $j < $length; $j++){
			$sql = "insert into video (videoname,videourl,siteid) values('".$match[1][$j]."','".$match[2][$j]."',".$sites[$i]['siteid'].")";
			$this->db->query($sql);
		}
	    }
	    

        }

        //过滤器
        public function filterLinks(){
            $filter =array("gift", "feedback", "login", "register", "kaidian", "sitemap");
            $db = new DBHelper();
            $db->selectDB("FoodOrder");

            for($i=0,$len=count($this->links[0][0]);$i<$len;$i++){
                if($this->links[0][2][$i] =="" || in_array($this->links[0][1][$i], $filter)){
                    unset ($this->links[0][0][$i]);
                    unset ($this->links[0][1][$i]);
                    unset ($this->links[0][2][$i]);
                }else{
                    $this->links[0][1][$i]="http://".$this->links[0][1][$i].".ele.me/";
                    $sql = "insert into site (sitename,siteurl) values ('".$this->links[0][2][$i]."','".$this->links[0][1][$i]."')";
                    $db->query($sql);
                }
            }
        }
        //链接绝对路径化
        //todo
        public function linkPathHandler(){
            $path = dirname($this->urls[0]);
        
        }
        public function returnLinks(){
            return $this->links;
        }
        public function printValue(){
            foreach($this->links as $key=>$value) {
                echo "<pre>";
                print_r($value);
                echo "</pre>"; 
            }
       
        }
    }
    $webspider = new WebSpider();
?>
