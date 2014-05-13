<html>
<head>
<meta charset="utf-8" />
<title>jQuery 实现鼠标经过提示效果</title>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery/jquery-1.4.min.js"></script>
<style>
.box{ width:600px; height:250px; margin:0 auto; padding-top:80px;}
#code{ margin-top:50px;}
#hide{ width:150px; height:150px; margin-top:20px; margin-left:20px; padding:30px; border:1px solid #E4E4E4; color:#333 }
</style>
</head>
<body>
<script>
$(function(){
	$("#hide").hide();
	$("#code").hover(function(){
		$("#hide").show(500);
		});
	$("#code").mouseout(function(){
		$("#hide").hide(1000);
		})
	})
</script>
<div class="box">
<a href="#" id="code">扫描微信</a>
<div id="hide">
这里是需要展示的内容，比如：微信二维码图片等
</div><!--end:hide-->
</div>
<!--以下为备注，可删除-->
<div style="width:960px; margin:0 auto;  padding-top:20px; line-height:20px; color:#666">
<script type="text/javascript">
/*通栏960*90，创建于2013-10-12*/
var cpro_id = "u1385918";
</script>
</div>
</body>
</html>
