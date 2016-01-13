{include file="inc_head.tpl" jsValidate="yes" openHead="yes" enableTableSorting="yes"}
{literal}

<script type="text/javascript" src="/lib/dcnMonthReport/js/DatePicker.js"></script>
<script type="text/javascript">
function checkDate(){
  var fromdate=document.getElementById('fromdate').value;
  var todate=document.getElementById('todate').value;
  if( fromdate == '' || fromdate == null || todate == '' || todate == null ){
        alert("请先选择查询月份起始区间!");
        return false;
  }
  if( todate < fromdate){
        alert("结束月份必须大于等于开始月份!");
        return false;
  }
}
</script>

<script language="JavaScript" type="text/javascript">
function ChangeDiv(divID,totalDiv){
   for(i=0;i<=totalDiv;i++){
       document.getElementById(i).style.display="none";
       document.getElementById('span'+i).style.color="#000000";
       document.getElementById('span'+i).style.backgroundColor="#eeeeee";
   }
   document.getElementById(divID).style.display="block";
   document.getElementById('span'+divID).style.color="#ffffff";
   document.getElementById('span'+divID).style.backgroundColor="#005599";
}
</script>

<script src="third_party/jquery/jquery1.3.2.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
   $("#filterName").keyup(function(){
        $("table tbody tr")
               .hide()
               .filter(":contains('"+( $(this).val() )+"')")
               .show();
   }).keyup();
})
</script>

<script type="text/javascript">
function editNotes(element,job_id,endtime)
{  
  var oldnote = element.innerHTML;
 var temp =  /^(<textarea rows.*?)$/;
 if(!temp.test(oldnote)){
  var newnote = document.createElement('textarea'); //创建文本域元素
  var reg = new RegExp("<br>" , "g");
  newnote.value = oldnote.replace(reg, "\r");

  newnote.rows = 2;
  newnote.cols = 30;
  newnote.onblur = function(){  //文本域失去焦点时保存，如果为空则恢复原值  
    element.innerHTML = this.value ? this.value : oldnote ;
    var newnotes = encodeURIComponent(element.innerHTML);
    self.dcnframe.location.href='/lib/dcnJobs/jobEditNotes.php?id='+job_id+'&note='+newnotes+'&time='+endtime;
  }

  element.innerHTML = '' ;

  element.appendChild(newnote);
  newnote.focus();
}
}
</script>

<script type="text/javascript" src="/third_party/jquery/jquery1.3.2.js"></script>
<script type="text/javascript">
//jQuery加载完以后，分组行高亮背景，分组明细隐藏
$(document).ready(function () {
    $("tr[group]").css("background-color", "#ff9");
    $("tr[parent]").hide();
});

//点击分组行时，切换分组明细的显示/隐藏
function showSub(a) {
    var groupValue = $(a).parent().parent().attr("group");
    var subDetails = $("tr[parent='" + groupValue + "']");
    subDetails.toggle();
}
    
$(function() {
$('tr.myparent')
.css("cursor","pointer")
.attr("title","click to open")
.click(function(){
$(this).siblings('.child-'+this.id).toggle();
});

});
</script>
{/literal}
</head>
<body {$body_onload}>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<h1 class="title">任务管理</h1>
&nbsp;&nbsp;&nbsp;&nbsp;<span id='span0' onclick="JavaScript:ChangeDiv(0,2)" {if $gui->div=='now'}style="cursor:pointer;color:#ffffff;background-color:#005599; font-size:14px;border:solid 1px black"{else}style="cursor:pointer;font-size:14px;border:solid 1px black"{/if}>执行中...</span>
<span id='span1' onclick="JavaScript:ChangeDiv(1,2)" {if $gui->div=='history'}style="cursor:pointer;color:#ffffff;background-color:#005599; font-size:14px;border:solid 1px black"{else}style="cursor:pointer;font-size:14px;border:solid 1px black"{/if}>历史任务</span>
<span id='span2' onclick="JavaScript:ChangeDiv(2,2)" {if $gui->div=='cloud'}style="cursor:pointer;color:#ffffff;background-color:#005599; font-size:14px;border:solid 1px black"{else}style="cursor:pointer;font-size:14px;border:solid 1px black"{/if}>云端任务</span>
<span style="color:red"><strong>过滤(键入任意列值)：</strong><input id="filterName" /></span>
<div class="workBack" id="0" {if $gui->div=='now'}style="display:block"{else}style="display:none"{/if}>
&nbsp;1. 状态列播放图标表示正在执行，暂停图标表示已暂停；点击状态列 job_id 可以查看任务详情，包括详细的执行环境参数；</br>
&nbsp;2. 在过滤框内输入任意字符，可过滤出任意列值包含该字符的行；</br>
&nbsp;3. 任务异常需重跑，如moni/dauto异常退出、SVN忘记更新、拓扑检查不过但任务还显示为"执行中...":</br>
&nbsp;&nbsp;&nbsp;若所填写的CCM/port/ixia等执行环境参数无需修改，请准备好环境后在浏览器访问dcnrdc://job_id 重新开始；</br>
&nbsp;&nbsp;&nbsp;若所填写的环境参数有误，请点击表格最后的清理按钮将任务归档到历史任务后重新点击“执行测试”菜单；
	<table class="simple_tableruler sortable">
        <thead>
		<tr><th>状态(查看详情)</th>
			<th>拓 扑</th>
			<th>模块</th>
			<th>任务开始时间</th>
			<th>执行人</th>
			<th>执行机IP</th>
			<th>测试计划</th>
			<th>版 本</th>
			<th>设 备</th>
			<th>用例数</th>
			<th>进度</th>
			<th>正在执行</th>
			<th>用例开始时间</th>
            <th>清理</th>
		</tr></thead><tbody>
		{foreach item=jobindex from=$gui->runningjobs}
		<tr>
			<td>
				<a href="lib/dcnJobs/jobsDetail.php?id={$jobindex.job_id}">
				{if $jobindex.status==1}<img src='/gui/templates/dcnJobs/running.png' >{/if}
				{if $jobindex.status==0}<img src='/gui/templates/dcnJobs/pause.png' >{/if}
				{$jobindex.job_id|escape}</a>
			</td>
			<td>{if $jobindex.topo_type==0}一般独立{/if}{if $jobindex.topo_type==1}一般堆叠{/if}{if $jobindex.topo_type==2}独立跨板卡{/if}{if $jobindex.topo_type==3}堆叠跨机架{/if}</td>
			<td>{$jobindex.jobtype|escape}</td>
			<td>{$jobindex.job_startTime|escape}</td>
			<td>{$jobindex.user|escape}</td>
			<td>{$jobindex.running_vdi|escape}</td>
			<td>{$jobindex.tplan|escape}</td>
			<td>{$jobindex.build|escape}</td>
			<td>{$jobindex.device|escape}</td>
			<td>{$jobindex.total_case|escape}</td>
			<td>{$jobindex.process}</td>
			<td>{$jobindex.running_case|escape}</td>
			<td>{$jobindex.run_time|escape}</td>
	        <td><a href="lib/dcnJobs/jobtrash.php?id={$jobindex.job_id}"><img src="/gui/templates/dcnJobs/endJob.png" /></a></td>
		</tr>
		{/foreach}
	</tbody></table>
</div>

<div class="workBack" id="1" {if $gui->div=='history'}style="display:block"{else}style="display:none"{/if}>
&nbsp;1. 点击任务ID链接可查阅该任务的执行报告；</br>
&nbsp;2. 点击日志文件可以查看该任务的所有log文件；</br>
&nbsp;3. 在过滤框内输入任意字符，可过滤出任意列值包含该字符的行；</br>
&nbsp;4. 默认查询最近3个月的任务，若需查阅其他区段任务，请选择月份起止后点击查询；</br>

	<form name='form1' action="lib/dcnJobs/jobsView.php?div=history" method="post" onsubmit="return checkDate()">
    	<p align='center'>从:<input type="text" id="fromdate" name="fromdate" onclick="setmonth(this)" readonly="readonly" value="{$gui->fromdate}" />至:<input type="text" id="todate" name="todate" onclick="setmonth(this)" readonly="readonly" value="{$gui->todate}" /><input type='submit' value='查看历史任务' /></p>
	</form>
	<table class="simple_tableruler sortable">
		<thead><tr>
			<th>任务ID(查阅报告)</th>
			<th>notes</th>
			<th>拓 扑</th>
			<th>模 块</th>
			<th>开始时间</th>
			<th>结束时间</th>
			<th>执行人</th>
			<th>测试计划</th>
			<th>版 本</th>
			<th>设 备</th>
			<th>待执行</th>
			<th>已执行</th>
			<th>Pass</th>
			<th>Fail</th>
			<th>差异未处理</th>
			<th>Invalid</th>
			<th>Accept</th>
			<th>日志</th>
			<th>删</th>
		</tr></thead><tbody>
		{foreach item=jobindex from=$gui->runendjobs}
		<tr>
            <td>{if $jobindex.status==1}<img src='/gui/templates/dcnJobs/complete.png' ><a href="./lib/results/dcnReport.php?format=0&tplan_id={$jobindex.tplan_id}&device_id={$jobindex.device_id}&topo_type={$jobindex.topo_type}&build_id={$jobindex.build_id}" target="_black">{/if}
            {if $jobindex.status==0}<img src='/gui/templates/dcnJobs/fail.png' >{/if}
            {$jobindex.job_id|escape}{if $jobindex.status == 1}</a>{/if}</td>
			<td ondblclick = "editNotes(this,'{$jobindex.job_id}','{$jobindex.job_endTime}')">{$jobindex.endwhy}</td>
			<td>{if $jobindex.topo_type==0}一般独立{/if}{if $jobindex.topo_type==1}一般堆叠{/if}{if $jobindex.topo_type==2}独立跨板卡{/if}{if $jobindex.topo_type==3}堆叠跨机架{/if}</td>
			<td>{$jobindex.job_type|escape}</td>
			<td>{$jobindex.job_startTime|escape}</td>
			<td>{$jobindex.job_endTime|escape}</td>
			<td>{$jobindex.user|escape}</td>
			<td>{$jobindex.tplan|escape}</td>
			<td>{$jobindex.build|escape}</td>
			<td>{$jobindex.device|escape}</td>
			<td>{$jobindex.total_case|escape}</td>
			<td>{$jobindex.runend_case|escape}</td>
			<td>{$jobindex.pass_case|escape}</td>
			<td>{$jobindex.fail_case|escape}</td>
			<td>{$jobindex.olddiff_case|escape}</td>
			<td>{$jobindex.na_case|escape}</td>
			<td>{$jobindex.accept_case|escape}</td>
		<td><a href="./upload_area/exec_logs/{$jobindex.job_id}" target='_black'>浏览</a></td>
		<td>{if $gui->userCanDeleteJob}<a href="./deletejob.php?jobid={$jobindex.job_id}" target='_black'>删</a>{/if}</td>
		</tr>
		{/foreach}
	</tbody></table>
</div>

<div class="workBack" id="2" {if $gui->div=='cloud'}style="display:block"{else}style="display:none"{/if}>
&nbsp;1. 在过滤框内输入任意字符，可过滤出任意列值包含该字符的行；</br>
	<table class="simple_tableruler">
		<thead><tr>
			<th>job_id</th>
			<th>status</th>
			<th>topo_type</th>
			<th>total_case</th>
			<th>tplan</th>
			<th>build</th>
			<th>device</th>
			<th>start_time</th>
			<th>env_id</th>
			<th>worker</th>
			<th>user</th>
		</tr></thead><tbody>
		{foreach item=parent_job key=parent_jobid from=$gui->cloudjobs}
		<tr group='gp{$parent_jobid}'><td colspan='4' style="cursor:pointer"><a onclick="showSub(this)">{$parent_jobid}</td>
			<td>{$parent_job[0]['tplan']}</td><td>{$parent_job[0]['build']}</td><td>{$parent_job[0]['device']}</td>
			<td></td><td></td><td></td><td>{$parent_job[0]['user']}</td>
			</tr>
			{foreach item=jobindex key=module from=$gui->cloudjobs[$parent_jobid]}
 			{if $module != '0'}
			<tr parent='gp{$parent_jobid}'>
            	<td>{if $jobindex.status=='wait'}<img src='/gui/templates/dcnJobs/wait.png' >{/if}
            	{if $jobindex.status=='pause'}<img src='/gui/templates/dcnJobs/pause.png' >{/if}
            	{if $jobindex.status=='running'}<img src='/gui/templates/dcnJobs/running.png' >{/if}
            	{if $jobindex.status=='complete'}<img src='/gui/templates/dcnJobs/complete.png' >{/if}{$jobindex.job_id}</td>
				<td>{$jobindex.status}</td>
				<td>{$jobindex.topo_type}</td>
				<td>{$jobindex.total_case}</td>
				<td>{$jobindex.tplan}</td>
				<td>{$jobindex.build}</td>
				<td>{$jobindex.device}</td>
				<td>{$jobindex.start_time}</td>
				<td>{$jobindex.env_id}</td>
				<td>{$jobindex.worker}</td>
				<td>{$jobindex.user}</td>
			</tr>
			{/if}
			{/foreach}
		{/foreach}
	</tbody></table>
</div>
<iframe src="" name="dcnframe" width=0 height=0 frameborder=0></iframe>
</body>
</html>