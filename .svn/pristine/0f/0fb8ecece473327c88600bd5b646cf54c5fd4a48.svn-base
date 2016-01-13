{lang_get var="labels"
          s="title_nav_results,title_report_type,btn_print,test_plan,show_inactive_tplans"}

{assign var="cfg_section" value=$smarty.template|replace:".tpl":""}
{config_load file="input_dimensions.conf" section=$cfg_section}
{include file="inc_head.tpl" openHead="yes"}

<literal>

<script type="text/javascript">
function reportPrint(){
	parent["workframe"].focus();
	parent["workframe"].print();
}
//选择报告内容
function report_type_change(type){
   switch(type){
       case "build_report":{
	       document.getElementById("build_report").style.display="";
		   document.getElementById("build_compare").style.display="none";
		   document.getElementById("build_multi_compare").style.display="none";  
		   document.getElementById("case_topN").style.display="none";
		   document.getElementById("testplan_report").style.display="none";
	       break;
	   }
	   case "build_compare":{
	       document.getElementById("build_report").style.display="none";
		   document.getElementById("build_compare").style.display="";
		   document.getElementById("build_multi_compare").style.display="none";
		   document.getElementById("case_topN").style.display="none";
		   document.getElementById("testplan_report").style.display="none";
	       break;
	   }
	   case "build_multi_compare":{
	       document.getElementById("build_report").style.display="none";
		   document.getElementById("build_compare").style.display="none";
		   document.getElementById("build_multi_compare").style.display="";
		   document.getElementById("case_topN").style.display="none";
		   document.getElementById("testplan_report").style.display="none";
	       break;
	   }
	   case "case_topN":{
	       document.getElementById("build_report").style.display="none";
		   document.getElementById("build_compare").style.display="none";
		   document.getElementById("build_multi_compare").style.display="none";
		   document.getElementById("case_topN").style.display="";
		   document.getElementById("testplan_report").style.display="none";
	       break;
	   }
	   case "testplan_report":{
	       document.getElementById("build_report").style.display="none";
		   document.getElementById("build_compare").style.display="none";
		   document.getElementById("build_multi_compare").style.display="none";
		   document.getElementById("case_topN").style.display="none";
		   document.getElementById("testplan_report").style.display="";
	       break;
	   }
   }
}
//当选择计划发生改变 build和device的选项
function report_buildanddevice2testplan(testplan){
    var buildobj=document.getElementById('report_build_buildreport');
    removeAllOptions(buildobj);
    var option = document.createElement("option");
    option.text = "选择版本";
    option.value = "0";
    buildobj.add(option); 
    var option = document.createElement("option");
    option.text = "任意版本";
    option.value = "1";
    buildobj.add(option); 
    var builds = {$report_builds};

    for(m=0;m<{$report_build_total};m++){
        if(builds[m][2]==testplan && builds[m][1]!='Dynamic Create'){
              var option = document.createElement("option");
              option.text = builds[m][1];
              option.value = builds[m][0];
              buildobj.add(option);
       }
    }
    var build_num = document.getElementById("report_build_buildreport").options.length ;
	if(build_num == 2){
	    removeAllOptions(buildobj);
        var option = document.createElement("option");
        option.text = "测试计划内没有版本";
        option.value = "0";
        buildobj.add(option); 
	}
    var deviceobj=document.getElementById('report_device_buildreport');
    removeAllOptions(deviceobj);
    var option = document.createElement("option");
    option.text = "选择设备";
    option.value = "0";
    deviceobj.add(option); 
	var option = document.createElement("option");
    option.text = "所有设备";
    option.value = "1";
    deviceobj.add(option); 
    var devices = {$report_devices};
    for(m=0;m<{$report_device_total};m++){
       if(devices[m][2]==testplan){
                var option = document.createElement("option");
                option.text = devices[m][1];
                option.value = devices[m][0];
                deviceobj.add(option);
       }
    }
    var device_num = document.getElementById("report_device_buildreport").options.length ;
	if(device_num == 2){
	    removeAllOptions(deviceobj);
        var option = document.createElement("option");
        option.text = "测试计划没有添加设备型号";
        option.value = "0";
        deviceobj.add(option); 
	}
}

function removeAllOptions(selectbox){
    var i;
    for(i=selectbox.options.length-1;i>=0;i--){
      selectbox.remove(i);
    }
}

function build_setsubmit()
{
   var tplan=document.getElementById('report_tplan_buildreport').value;
   var device=document.getElementById('report_device_buildreport').value;
   var build=document.getElementById('report_build_buildreport').value;
   var stack_check=document.getElementById('report_stack_buildreport');
   if(stack_check.checked){   var stack = 1;   }else{   var stack = 0 ;  } 
   window.parent['workframe'].location.href='/lib/results/dcnReport.php?format=0&tplan_id='+tplan+'&device_id='+device+'&build_id='+build+'&stack='+stack ;
}

//build_compare当选择计划发生改变 build和device的选项
function compare_buildanddevice2testplan(testplan){
    var buildobj=document.getElementById('report_build_buildcompare');
    removeAllOptions(buildobj);
   
    var builds = {$report_builds};
    var top_build = 0 ;
    for(m=0;m<{$report_build_total};m++){
        if(builds[m][2]==testplan && builds[m][1]!='Dynamic Create'){
              var option = document.createElement("option");
              option.text = builds[m][1];
              option.value = builds[m][0];
              if( top_build<5 ) { option.selected = 'selected' ; }
              buildobj.add(option);
              top_build++ ;
       }
    }
    var build_num = document.getElementById("report_build_buildcompare").options.length ;
	if(build_num == 0){
	    removeAllOptions(buildobj);
        var option = document.createElement("option");
        option.text = "该测试计划没有版本";
        option.value = "0";
        buildobj.add(option); 
	}

    var deviceobj=document.getElementById('report_device_buildcompare');
    removeAllOptions(deviceobj);
    var option = document.createElement("option");
    option.text = "选择测试设备";
    option.value = "0";
    deviceobj.add(option); 
    
    option.text = "任意设备";
    option.value = "1";
    deviceobj.add(option); 
    
    var devices = {$report_devices};
    for(m=0;m<{$report_device_total};m++){
       if(devices[m][2]==testplan){
                var option = document.createElement("option");
                option.text = devices[m][1];
                option.value = devices[m][0];
                deviceobj.add(option);
       }
    }
    var device_num = document.getElementById("report_device_buildcompare").options.length ;
	if(device_num == 2){
	    removeAllOptions(deviceobj);
        var option = document.createElement("option");
        option.text = "该测试计划没有设备型号";
        option.value = "0";
        deviceobj.add(option); 
	}
}

function multicompare_buildanddevice2testplan(testplan){
    var buildobj=document.getElementById('report_multi_build_buildcompare');
    removeAllOptions(buildobj);
    var option = document.createElement("option");
    option.text = "选择版本";
    option.value = "0";
    buildobj.add(option); 

    var builds = {$report_builds};

    for(m=0;m<{$report_build_total};m++){
        if(builds[m][2]==testplan && builds[m][1]!='Dynamic Create'){
              var option = document.createElement("option");
              option.text = builds[m][1];
              option.value = builds[m][0];
              buildobj.add(option);
       }
    }
    var build_num = document.getElementById("report_multi_build_buildcompare").options.length ;
	if(build_num == 1){
	    removeAllOptions(buildobj);
        var option = document.createElement("option");
        option.text = "测试计划内没有版本";
        option.value = "0";
        buildobj.add(option); 
	}
    var deviceobj=document.getElementById('report_multi_device_buildcompare');
    removeAllOptions(deviceobj);
    var option = document.createElement("option");
    option.text = "选择设备";
    option.value = "0";
    deviceobj.add(option); 
	var option = document.createElement("option");
    option.text = "任意设备";
    option.value = "1";
    deviceobj.add(option); 
    var devices = {$report_devices};
    for(m=0;m<{$report_device_total};m++){
       if(devices[m][2]==testplan){
                var option = document.createElement("option");
                option.text = devices[m][1];
                option.value = devices[m][0];
                deviceobj.add(option);
       }
    }
    var device_num = document.getElementById("report_multi_device_buildcompare").options.length ;
	if(device_num == 2){
	    removeAllOptions(deviceobj);
        var option = document.createElement("option");
        option.text = "测试计划没有添加设备型号";
        option.value = "0";
        deviceobj.add(option); 
	}
}

function multicompare_buildanddevice2testplan2(testplan){
    var buildobj=document.getElementById('report_multi_build_buildcompare2');
    removeAllOptions(buildobj);
    var option = document.createElement("option");
    option.text = "选择版本";
    option.value = "0";
    buildobj.add(option); 

    var builds = {$report_builds};

    for(m=0;m<{$report_build_total};m++){
        if(builds[m][2]==testplan && builds[m][1]!='Dynamic Create'){
              var option = document.createElement("option");
              option.text = builds[m][1];
              option.value = builds[m][0];
              buildobj.add(option);
       }
    }
    var build_num = document.getElementById("report_multi_build_buildcompare2").options.length ;
	if(build_num == 1){
	    removeAllOptions(buildobj);
        var option = document.createElement("option");
        option.text = "测试计划内没有版本";
        option.value = "0";
        buildobj.add(option); 
	}
    var deviceobj=document.getElementById('report_multi_device_buildcompare2');
    removeAllOptions(deviceobj);
    var option = document.createElement("option");
    option.text = "选择设备";
    option.value = "0";
    deviceobj.add(option); 
	var option = document.createElement("option");
    option.text = "任意设备";
    option.value = "1";
    deviceobj.add(option); 
    var devices = {$report_devices};
    for(m=0;m<{$report_device_total};m++){
       if(devices[m][2]==testplan){
                var option = document.createElement("option");
                option.text = devices[m][1];
                option.value = devices[m][0];
                deviceobj.add(option);
       }
    }
    var device_num = document.getElementById("report_multi_device_buildcompare2").options.length ;
	if(device_num == 2){
	    removeAllOptions(deviceobj);
        var option = document.createElement("option");
        option.text = "测试计划没有添加设备型号";
        option.value = "0";
        deviceobj.add(option); 
	}
}

function compare_setsubmit()
{
   var tplan=document.getElementById('report_tplan_buildcompare').value;
   var device=document.getElementById('report_device_buildcompare').value;
   var topo=document.getElementById('report_device_topo_buildcompare').value;

   var obj = document.getElementById('report_build_buildcompare') ;
   var url = 'format=0&tplan_id='+tplan+'&device_id='+device+'&stack='+topo ;
   var totalbuild = 0 ;
   var j = 0 ;
   for( var i=0 ; i<obj.options.length ; i++ ){
        if( obj.options[i].selected ) {
             totalbuild++ ; 
             url = url + '&build' + j + '=' + obj.options[i].value ;
             j++;
        }
   }
   url = url + '&totalbuild=' + totalbuild ;
   window.parent['workframe'].location.href='/lib/dcnBuildCompare/dcnBuildCompare.php?'+url ;
}


function multicompare_setsubmit()
{
   var tplan1=document.getElementById('report_multi_tplan_buildcompare').value;
   var device1=document.getElementById('report_multi_device_buildcompare').value;
   var build1=document.getElementById('report_multi_build_buildcompare').value;
   var stack1=document.getElementById('report_device_multi_topo_buildcompare').value;
   
   var tplan2=document.getElementById('report_multi_tplan_buildcompare2').value;
   var device2=document.getElementById('report_multi_device_buildcompare2').value;
   var build2=document.getElementById('report_multi_build_buildcompare2').value;
   var stack2=document.getElementById('report_device_multi_topo_buildcompare2').value;
   window.parent['workframe'].location.href='/lib/dcnBuildCompare/dcnBuildCompare_multi.php?format=0&tplan1='+tplan1+'&device1='+device1+'&build1='+build1+'&stack1='+stack1+'&tplan2='+tplan2+'&device2='+device2+'&build2='+build2+'&stack2='+stack2 ;
}


function topN_setsubmit()
{
   var tplan=document.getElementById('topn_tplan_select').value;
   var typeobj=document.getElementById('topn_type_select');
   var type=typeobj.value;
   var typename=typeobj.options[typeobj.options.selectedIndex].text;
   var suite=document.getElementById('topn_suite_select').value;
   window.parent['workframe'].location.href='/lib/dcnBuildCompare/dcnTopN.php?format=0&tplan='+tplan+'&type='+type+'&typename='+typename+'&suite='+suite ;
}

function testplan_report_setsubmit()
{
   var tplan=document.getElementById('report_testplan_report').value;
   window.parent['workframe'].location.href='/lib/results/resultsGeneral.php?format=0&tplan_id='+tplan ;
}
</script>
</literal>
</head>

<body>

<h1 class="title">报告展示内容:<select id="report_type" onChange="report_type_change(this.value)" >
 <option selected value="build_report">版本详细报告</option>
  <option value="testplan_report">测试计划统计数据</option>
 <option value="build_compare">版本质量趋势</option>
 <option value="build_multi_compare">版本质量对比(跨计划/设备/拓扑对比)</option>
 <option value="case_topN">测试例TopN分析</option>
</select></h1>
<br>

<div style="margin:3px; padding: 5px 0px">
{if $gui->do_report.status_ok}
<div id="build_report" >
<h2>提示：</h2>
&nbsp;&nbsp;1.请选择测试计划、产品型号、测试版本后点击“查看报告”；
</br>&nbsp;&nbsp;2."任意版本"的应用举例：case 4.1.1 周一在versionA上pass，周三在versionB上Block，则4.1.1最终在报告中体现为Block；
</br>&nbsp;&nbsp;3.选择"所有设备"，报告将列出该测试计划中所有被覆盖产品型号的结果。注意，如果测试计划覆盖设备较多，报告展现将需要更多时间，如非必要，请分设备查询；

<hr>
<form action="" method="post">
&nbsp;项目计划:<select id="report_tplan_buildreport" onChange="report_buildanddevice2testplan(this.value)">
 <option selected value="0">选择测试计划</option>
 {foreach from=$report_plans item=plan}
   <option value='{$plan[0]}'>{$plan[1]}</option>
 {/foreach}
</select>
</br>提示：若需区分设备拓扑，请勾选"区分拓扑"
</br>&nbsp;产品型号:<select id='report_device_buildreport'><option selected value="0">选择设备</option></select>&nbsp;区分拓扑?<input type="checkbox"  id="report_stack_buildreport" />
</br>&nbsp;测试版本:<select id='report_build_buildreport'><option selected value="0">选择版本</option></select>
</br>
</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='查看测试报告'  onclick="build_setsubmit()">
</br>
</form>
</div>

<div id="testplan_report" style="display:none" >
<h2>提示：</h2>
&nbsp;&nbsp;1.请选择测试计划后点击“查看统计”；

<hr>
<form action="" method="post">
&nbsp;项目计划:<select id="report_testplan_report">
 <option selected value="0">选择测试计划</option>
 {foreach from=$report_plans item=plan}
   <option value='{$plan[0]}'>{$plan[1]}</option>
 {/foreach}
</select>
</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='查看统计'  onclick="testplan_report_setsubmit()">
</br>
</form>
</div>


<div id="build_compare" style="display:none">
<h2>提示：</h2>
&nbsp;&nbsp;1.请选择测试计划、产品型号、拓扑类型和多个测试版本后点击“查看质量趋势”；
<hr>
<form action="" method="post">
&nbsp;项目计划:<select id="report_tplan_buildcompare" onChange="compare_buildanddevice2testplan(this.value)">
 <option selected value="0">选择测试计划</option>
 {foreach from=$report_plans item=plan}
   <option value='{$plan[0]}'>{$plan[1]}</option>
 {/foreach}
</select>
</br>&nbsp;产品型号:<select id='report_device_buildcompare'><option selected value="0">选择设备</option></select>
</br>&nbsp;设备拓扑:<select id='report_device_topo_buildcompare'>
                         <option selected value="0">0-基本独立模式(包含非堆叠img)</option>
                         <option value="1">1-基本堆叠模式</option>
                         <option value="2">2-机架独立模式跨板卡</option>
                         <option value="3">3-机架堆叠模式跨机架</option>
                   </select>
</br>&nbsp;测试版本:<select id='report_build_buildcompare' multiple="multiple" size="10"><option selected value="0">选择版本&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option></select>
</br>
</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='查看质量趋势'  onclick="compare_setsubmit()">
</form>
</div>

{*--跨计划跨设备跨拓扑--*}
<div id="build_multi_compare" style="display:none">
<h2>提示：</h2>
&nbsp;&nbsp;1.请分别选择测试计划、产品型号、拓扑类型、测试版本后点击“查看质量对比”；
<hr>
<form action="" method="post">
&nbsp;项目计划:<select id="report_multi_tplan_buildcompare" onChange="multicompare_buildanddevice2testplan(this.value)">
 <option selected value="0">选择测试计划</option>
 {foreach from=$report_plans item=plan}
   <option value='{$plan[0]}'>{$plan[1]}</option>
 {/foreach}
</select>
</br>&nbsp;产品型号:<select id='report_multi_device_buildcompare'><option selected value="0">选择设备</option></select>
</br>&nbsp;设备拓扑:<select id='report_device_multi_topo_buildcompare'>
                         <option selected value="0">0-基本独立模式(包含非堆叠img)</option>
                         <option value="1">1-基本堆叠模式</option>
                         <option value="2">2-机架独立模式跨板卡</option>
                         <option value="3">3-机架堆叠模式跨机架</option>
                   </select>
</br>&nbsp;测试版本:<select id='report_multi_build_buildcompare'><option selected value="0">选择版本&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option></select>

<hr>
&nbsp;项目计划:<select id="report_multi_tplan_buildcompare2" onChange="multicompare_buildanddevice2testplan2(this.value)">
 <option selected value="0">选择测试计划</option>
 {foreach from=$report_plans item=plan}
   <option value='{$plan[0]}'>{$plan[1]}</option>
 {/foreach}
</select>
</br>&nbsp;产品型号:<select id='report_multi_device_buildcompare2'><option selected value="0">选择设备</option></select>
</br>&nbsp;设备拓扑:<select id='report_device_multi_topo_buildcompare2'>
                         <option selected value="0">0-基本独立模式(包含非堆叠img)</option>
                         <option value="1">1-基本堆叠模式</option>
                         <option value="2">2-机架独立模式跨板卡</option>
                         <option value="3">3-机架堆叠模式跨机架</option>
                   </select>
</br>&nbsp;测试版本:<select id='report_multi_build_buildcompare2'><option selected value="0">选择版本&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option></select>
<hr>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='查看质量对比'  onclick="multicompare_setsubmit()">

</form>
</div>

{*-topN-*}
<div id="case_topN" style="display:none" >
<form action="" method="post">
<h2>提示：</h2>
&nbsp;&nbsp;1.若需查看单个测试计划内的统计，请选择具体测试计划，否则请选择"所有测试计划"；<br>
&nbsp;测试计划:<select id="topn_tplan_select" >
 <option selected value="0">所有测试计划</option>
 {foreach from=$report_plans item=plan}
   <option value='{$plan[0]}'>{$plan[1]}</option>
 {/foreach}
</select>
<br>
&nbsp;自动模块:<select id="topn_suite_select" >
 <option selected value="0">所有自动化模块</option>
 {foreach from=$report_suites item=suite}
   <option value='{$suite[0]}'>{$suite[1]}</option>
 {/foreach}
</select>

<br>
<br>&nbsp;&nbsp;2.请选择具体的数据维度，然后点击"查看Top100数据"按钮;<br>

&nbsp;Top100维度:<select id="topn_type_select">
 <option selected value="0">未能Pass最多的</option>
 <option value="1">Fail最多的</option>
 <option value="2">Accept最多的</option>
 <option value="3">N/A最多的</option>
 <option value="4">All NoRun</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='查看Top100数据'  onclick="topN_setsubmit()">
</form>
</div>

<hr>
{else}
  {$gui->do_report.msg}
{/if}
</div>

<script type="text/javascript">
{if $gui->workframe != ''}
	parent.workframe.location='{$gui->workframe}';
{/if}
</script>

</body>
</html>