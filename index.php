<?php
include("./db/DBHelper.class.php");
	$url = $_GET["url"];
	$db = new DBHelper();
	$db->selectDB("VideoSite");
	if($url){
		try{
		    $selSql = "select videoname,videosource from video where videourl='".$url."'";
		    $source = $db->select($selSql);
		    if(!$source) {
			$querys = explode(" ", $url);
			foreach($querys as $key=>$val) {
		    	    $selSql = "select videoname,videosource from video where videoname like '%".$val."%'";
		    	    $source = $db->select($selSql);
			    if($source){
			    	break;
			    }	
		       	}
		    }
		}
		catch(Exception $e){
		}
	}
?>
<!DOCTYPE>
<html>
<head>
	<meta charset="utf-8" />
	<title>视频嗅探</title>

<style type="text/css">
	form{	
	    width:984px;
	    margin:50px auto;	
	}
	.urlContent{
	    width:500px;
	    height:30px;
	    text-indent:10px;
	}
	.submit{
	    width:100px;
	    height:30px;
	    cursor:pointer;
            font:16px/30px "微软雅黑";
	}
	.player{
	    width:980px;
	    margin: 0 auto;	
	}
	.video-title{
	   width:980px;
           margin:0 auto 20px auto;
	   overflow:hidden;
	   text-overflow:ellipsis;
	   white-space:nowrap;
	}
</style>
</head>
<body>
	<form action="/VideoSpider/index.php" method="get" onsubmit="return getSource()">
	<input name="url" class="urlContent" type="text"
	<?php 
		if($url){ 
	?> value="<?php
	 echo ($url);
	 ?>"
	<?php 
		}
	 ?> />
		<input class="submit" type="submit" value="搜一下"/>	
	</form>
	<?php
	    if(isset($source) && $source){
	?>
		<h2 class="video-title"><?php echo($source[0]["videoname"]);?></h2>
	<div class="player">
		<video autoplay controls src=<?php echo($source[0]["videosource"]); ?>></video>
	</div>
	<?php
	    }
	?>
	<script>
		
		
	</script>
</body>
</html>
