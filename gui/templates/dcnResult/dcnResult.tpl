{include file="inc_head.tpl" jsValidate="yes" openHead="yes" enableTableSorting="yes"}
<literal>
<script type="text/javascript">
//当选择计划发生改变 build和device的选项
function change_tplan(testplan){
    var buildobj=document.getElementById('buildid_select');
    var deviceobj=document.getElementById('deviceid_select');
    var topoobj=document.getElementById('topotype_select');
    var suiteobj=document.getElementById('suite_select');
    
    removeAllOptions(buildobj);
    removeAllOptions(deviceobj);
    removeAllOptions(topoobj);
    removeAllOptions(suiteobj);
    
    if(testplan != 0){
        var option = document.createElement("option");
        option.text = "不区分版本";
        option.value = "1";
        buildobj.add(option);
        var builds = {$builds};

	    var option = document.createElement("option");
        option.text = "不区分设备型号";
        option.value = "1";
        deviceobj.add(option);
        
        var option = document.createElement("option");
        option.text = "不区分拓扑类型";
        option.value = "999";
        topoobj.add(option);
    
        var option = document.createElement("option");
        option.text = "不区分模块(测试计划结论)";
        option.value = "1";
        suiteobj.add(option);
        var project = {$project};
        if( project == 1 ){
        	var option = document.createElement("option");
        	option.text = "功能测试";
        	option.value = "67";
        	suiteobj.add(option);
        	var option = document.createElement("option");
        	option.text = "确认测试2.0";
        	option.value = "3959";
        	suiteobj.add(option);
        	var option = document.createElement("option");
        	option.text = "确认测试3.0";
        	option.value = "4944";
        	suiteobj.add(option);
        	var option = document.createElement("option");
        	option.text = "软件性能测试";
        	option.value = "18556";
        	suiteobj.add(option);
        	var option = document.createElement("option");
        	option.text = "MemoryCrash";
        	option.value = "41008";
        	suiteobj.add(option);
        	var option = document.createElement("option");
        	option.text = "命令行测试";
        	option.value = "31886";
        	suiteobj.add(option);
        }
        if( project == 2 ){
        	var option = document.createElement("option");
        	option.text = "waffirm";
        	option.value = "5119";
        	suiteobj.add(option);
        	var option = document.createElement("option");
        	option.text = "waffirm_X86";
        	option.value = "7736";
        	suiteobj.add(option);
        }
	}
}

function change_suite(suiteid){
   var buildobj=document.getElementById('buildid_select');
   var deviceobj=document.getElementById('deviceid_select');
   var topoobj=document.getElementById('topotype_select');
    
   removeAllOptions(buildobj);
   removeAllOptions(deviceobj);
   removeAllOptions(topoobj);
        
   var testplan=document.getElementById('tplanid_select').value;
   var option = document.createElement("option");
   option.text = "不区分版本";
   option.value = "1";
   buildobj.add(option);
   if( suiteid != '67' ){ //非功能测试，版本可选
       var builds = {$builds};
       for(m=0;m<{$build_total};m++){
           if(builds[m][2]==testplan && builds[m][1]!='Dynamic Create'){
               var option = document.createElement("option");
               option.text = builds[m][1];
               option.value = builds[m][0];
               buildobj.add(option);
           }
       }
   }

   var devices = {$devices};
   for(m=0;m<{$device_total};m++){
       if(devices[m][2]==testplan){
           var option = document.createElement("option");
           option.text = devices[m][1];
           option.value = devices[m][0];
           deviceobj.add(option);
       }
    }
    
    var option = document.createElement("option");
    option.text = "不区分拓扑类型";
    option.value = "999";
    topoobj.add(option);

    var option = document.createElement("option");
    option.text = "独立模式不跨板卡";
    option.value = "0";
    topoobj.add(option);
    var option = document.createElement("option");
    option.text = "堆叠模式不跨机架";
    option.value = "1";
    topoobj.add(option);
    var option = document.createElement("option");
    option.text = "机架独立模式跨板卡";
    option.value = "2";
    topoobj.add(option);
    var option = document.createElement("option");
    option.text = "机架堆叠模式跨机架";
    option.value = "3";
    topoobj.add(option);
}

function removeAllOptions(selectbox){
    var i;
    for(i=selectbox.options.length-1;i>=0;i--){
      selectbox.remove(i);
    }
}

function setsubmit2(){
   var tplan=document.getElementById('tplanid_select').value;
   var build_num = document.getElementById('buildid_select').options.length;
   var device_num = document.getElementById('deviceid_select').options.length;
   var topo=document.getElementById('topotype_select').value;
   var suite=document.getElementById('suite_select').value;
   if(tplan == 0 || suite == 0 ){
   	    alert('Error:请选择测试计划后填写');
   }else if(build_num==0 || device_num==0){
        alert('Error:测试计划内没有版本或没有设备,请核实!');
   }else{
        var device=document.getElementById('deviceid_select').value;
        var build=document.getElementById('buildid_select').value;
   	    workframe.location.href='/lib/dcnResult/dcnResultDetails.php?tplanid='+tplan+'&deviceid='+device+'&buildid='+build+'&topotype='+topo+'&suite='+suite ;
   }
}

function setsubmit(){
   var tplan=document.getElementById('tplanid_select').value;
   if(tplan == 0){
   	   alert('Error:请选择测试计划后查看');
   }else{
   	   workframe.location.href='/lib/dcnResult/dcnResultAll.php?tplanid='+tplan ;
   }
}

</script>
</literal>
</head>
<body>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}
<div align="center">
<h1 class="title">测试结论填写/查看</h1>
<form action="" method="post">
&nbsp;项目计划:<select id="tplanid_select" onChange="change_tplan(this.value)">
 <option selected value="0">选择测试计划</option>
 {foreach from=$plans item=plan}
   <option value='{$plan[0]}' {if $plan[0]==$tplanid}selected="selected"{/if}>{$plan[1]}</option>
 {/foreach}
</select>
&nbsp;脚本模块:<select id='suite_select' onChange="change_suite(this.value)">
{if $fromlink==1}<option value={$suite}>{$suitename}</option>{/if}
</select>
&nbsp;测试版本:<select id='buildid_select'>
{if $fromlink==1}<option value={$buildid}>{$buildname}</option>{/if}
</select>
&nbsp;产品型号:<select id='deviceid_select'>
{if $fromlink==1}<option value={$deviceid}>{$devicename}</option>{/if}
</select>
&nbsp;拓扑结构:<select id='topotype_select'>
{if $fromlink==1}<option value={$topotype}>{$topotypename}</option>{/if}
</select>
&nbsp;<input type='button' value='撰写/修改测试结论' onclick="setsubmit2()"></br>
<input type='button' value='查看测试计划全部结论' onclick="setsubmit()">
</form>
</div>
<div align="left">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tips: 1. 不同维度的结论请选择上述各字段组合后，点击'撰写/修改测试结论'按钮;</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 若结论详细描述中显示为<b>'###没有被执行过###'</b>则所选组合的维度没有执行记录，此时填写结论没有意义，保存会提示失败;</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. 修改或撰写结论，请填写后点击下方'保存测试结论'按钮;</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. 选择测试计划后，点击"查看测试计划全部结论"按钮，可以查看该测试计划内所有填写了结论的维度的结论以及报告名称;
</div>
<iframe {if $fromlink==1}src="./lib/dcnResult/dcnResultDetails.php?tplanid={$tplanid}&buildid={$buildid}&deviceid={$deviceid}&topotype={$topotype}&suite={$suite}"{else}src=""{/if} scrolling="auto" align="center" name="workframe" id="workframe" width='100%' height="600"></iframe></iframe>
</body>
</html>