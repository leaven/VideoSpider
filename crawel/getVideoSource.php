<?php
/**
 *  @file getVideoSource
 *  @author liwei
 *  @date 2014/05/08
 *  @function get source from each url in table video
 */

   	 include("../db/DBHelper.class.php");
	class getVideoSource{
            private $db;
	    public function __construct(){
		 $this->db = new DBHelper();
		 $this->db->selectDB("VideoSite");
		 $this->getSource();
	    }
    	    public function getUnFetchUrl(){
		 $selSql ="select videoid,videourl from video where videosource is null";
		 $unFetchUrls = $this->db->select($selSql);
		 return $unFetchUrls;
	    }	    
	    public function getSource(){
	    	$urls = $this->getUnFetchUrl();
		for($i = 0, $len = count($urls); $i < $len; $i++){
		    $html = @file_get_contents("compress.zlib://".$urls[$i]["videourl"]);	
		    
		    //获取其中的vid，通过vid获取视频资源
		    preg_match("/vid\s*[:=]\s*\"(\d*)\"/",$html,$match);
		    
		    //json url 
		   if($match && $match[1]){
		    	$jsonurl = "http://api.tv.sohu.com/v4/video/info/".$match[1].".json?site=1&callback=initLoadVideoCallback&api_key=695fe827ffeb7d74260a813025970bd5&plat=17&sver=1.0&partner=1";
		  	$videojson = @file_get_contents("compress.zlib://".$jsonurl);
		//	$videojson=iconv("gbk","UTF-8",$html);
			preg_match("/initLoadVideoCallback\((.*)\)/",$videojson,$data);
			
			if($data && $data[1]){
				$vdata = json_decode($data[1],true);
			}
			$updateSql = "update video set videosource ='".$vdata["data"]["url_high_mp4"]."' where videoid=".$urls[$i]["videoid"];
		   	$this->db->query($updateSql);
		   }

		 }
	    }
            public function getVideoVid(){
	    	
	    }	    
	}	
	$getsource = new getVideoSource();
?>

