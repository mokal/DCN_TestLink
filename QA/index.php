<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>DCN 测试中心QA管理系统---执行统计工具</title>
<link rel="stylesheet" type="text/css" href="../css/main.css" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
<style type="text/css">
a{color:#007bc4/*#424242*/; text-decoration:none;}
a:hover{text-decoration:underline}
ol,ul{list-style:none}
body{height:100%; font:12px/18px Tahoma, Helvetica, Arial, Verdana, "\5b8b\4f53", sans-serif; color:#51555C;}
img{border:none}
.demo{width:800px; margin:20px auto}
.demo h4{height:32px; line-height:32px; font-size:14px}
.demo h4 span{font-weight:500; font-size:12px}
.demo p{line-height:28px;}
input{width:200px; height:20px; line-height:20px; padding:2px; border:1px solid #d3d3d3}

.ui-timepicker-div .ui-widget-header { margin-bottom: 8px;}
.ui-timepicker-div dl { text-align: left; }
.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
.ui-timepicker-div td { font-size: 90%; }
.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
.ui_tpicker_hour_label,.ui_tpicker_minute_label,.ui_tpicker_second_label,.ui_tpicker_millisec_label,.ui_tpicker_time_label{padding-left:20px}
</style>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery-ui-slide.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
$(function(){$('#time_start').datetimepicker();});
$(function(){$('#time_stop').datetimepicker();});

function checkTime(){
  var time_start=document.getElementById('time_start').value;
  var time_stop=document.getElementById('time_stop').value;
  if( time_start == '' || time_start == null ){
        alert("开始时间不能为空！");
        return false;
  }
  if( time_stop == '' || time_stop == null ){
       alert("结束时间不能为空！");
       return false;
  }
  if( time_stop < time_start ){
      alert("结束时间必须在开始时间之后！");
      return false;
  }else{
         return ture; 
  }
}
</script>

</head>

<body>
<div id="main">
<div class="demo">
<form name='form1' action="doCreateExcel.php" method="post" onsubmit="return checkTime()">
    <p align='center'>说明：选择起止时间后，点击查询按钮，可将所查询到的结果直接导出为Excel文件。若时间跨度较大，可能因数据量较多时间较长。</p>
    <p align='center'>开始时间:<input type="text" id="time_start" name="time_start" />  结束时间:<input type="text" id="time_stop" name="time_stop" /></p>
    <p align='center'>测试计划(留空为全部):<input type="text" id="tplanname" name="tplanname" /></p>
    <p align='center'><input type='submit' value='生成查询结果' /></p>
</form>
</div>
</div>

</body>

</html>