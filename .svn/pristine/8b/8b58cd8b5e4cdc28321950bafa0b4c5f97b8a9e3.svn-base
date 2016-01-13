{include file="inc_head.tpl" jsValidate="yes" openHead="yes" enableTableSorting="yes"}
{include file="inc_del_onclick.tpl"}

{lang_get var='labels'
          s='th_notes,th_platform,th_delete,btn_import,btn_export,
             menu_manage_platforms,alt_delete_platform,warning_delete_platform,
             warning_cannot_delete_platform,delete,
             menu_assign_kw_to_tc,btn_create_platform'}

{lang_get s='warning_delete_platform' var="warning_msg" }
{lang_get s='warning_cannot_delete_platform' var="warning_msg_cannot_del" }
{lang_get s='delete' var="del_msgbox_title" }

{assign var="viewAction" value="lib/dcnIssue/issueView.php"}

<script type="text/javascript">
<!--
	/* All this stuff is needed for logic contained in inc_del_onclick.tpl */
	var del_action=fRoot+'lib/dcnIssue/issueEdit.php?doAction=do_delete&id=';
//-->
</script>
<script type="text/javascript" src="{$basehref}/lib/dcnMonthReport/js/DatePicker.js"></script>
<script type="text/javascript">
function checkDate(){
  var mydate=document.getElementById('mydate').value;
  if( mydate== '' || mydate == null ){
        alert("请先选择所需查阅的月份！");
        return false;
  }
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
</head>
<body {$body_onload}>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<h1 class="title">自动化测试月度报告</h1>
{include file="inc_feedback.tpl" user_feedback=$gui->user_feedback}

<div class="workBack">
<div class="groupBtn">	
<form name='form1' action="lib/dcnMonthReport/viewMonthReport.php" method="post" onsubmit="return checkDate()">
    <p align='center'>默认为Job维度，若需查看项目维度报告，请勾选"项目维度”</p>
    <p align='center'>查阅年月:<input type="text" id="mydate" name="mydate" onclick="setmonth(this)" readonly="readonly" value="{$gui->nowdate}" />项目维度<input name="testplan_monthreport" type="checkbox" {if $gui->tpreport == 1}checked="checked"{/if} value="1" /><input type='submit' value='查看月度报告' /></p>
    <p align='center' style="color:red"><strong>模糊过滤(键入任意列值)：</strong><input id="filterName" /></p>
</form>
</div>
{if $gui->postdate != 0 }
   {if $gui->num_monthJobs == 0}
        </br><p align='center'><strong>该月份内没有执行记录，请重新选择年月!</strong></p>
   {else}
	<table class="simple_tableruler sortable">
		<tr>
		{if $gui->tpreport == 0}
			<th align="center">Job_ID(查阅详情)</th>
			<th align="center">测试计划</th>
			<th align="center">拓扑类型</th>
			<th align="center">测试人员</th>
			<th align="center">执行设备</th>
			<th align="center">执行时间</th>
			<th align="center">执行模块</th>
			<th align="center">待执行</th>
			<th align="center">已执行</th>
			<th align="center">Fail</th>
			<th align="center">失败率</th>
			<th align="center">交换机Bug</th>
			<th align="center">已知缺陷</th>
			<th align="center">售后未合入</th>
			<th align="center">脚本问题</th>
			<th align="center">产品差异</th>
			<th align="center">版本差异</th>
			<th align="center">方案问题</th>
			<th align="center">环境问题</th>
			<th align="center">无效测试</th>
			<th align="center">未分析</th>
			<th align="center">差异未处理</th>
		{/if}
		{if $gui->tpreport == 1 }
			<th align="center">测试计划</th>
			<th align="center">Fail</th>
			<th align="center">交换机Bug</th>
			<th align="center">已知缺陷</th>
			<th align="center">售后未合入</th>
			<th align="center">脚本问题</th>
			<th align="center">产品差异</th>
			<th align="center">版本差异</th>
			<th align="center">方案问题</th>
			<th align="center">环境问题</th>
			<th align="center">无效测试</th>
			<th align="center">未分析</th>
			<th align="center">差异未处理</th>
		{/if}
		</tr>
		{foreach item=job from=$gui->monthJobs}
		<tr>
		{if $gui->tpreport == 0}
			<td align="center"><a href="lib/dcnMonthReport/jobDetailReport.php?id={$job['job_id']}" target="_blank">{$job['job_id']}</a></td>
			<td align="center">{$job['tplan_name']}</td>
			<td align="center">{if $job.topo_type==0}一般独立{/if}{if $job.topo_type==1}一般堆叠{/if}{if $job.topo_type==2}独立跨板卡{/if}{if $job.topo_type==3}堆叠跨机架{/if}</td>
			<td align="center">{$job['user']}</td>
			<td align="center">{$job['device']}</td>
			<td align="center">{$job['job_startTime']}</td>
			<td align="center">{$job['job_type']}</td>
			<td align="center">{$job['total']}</td>
			<td align="center">{$job['runend']}</td>
			<td align="center">{$job['fail']}</td>
			<td align="center">{math equation="x*100/(y+0.01)" x=$job['fail'] y=$job['runend']  format="%.2f"}%</td>
			<td align="center">{$job['switch']}</td>
			<td align="center">{$job['accept']}</td>
			<td align="center">{$job['nomerge']}</td>
			<td align="center">{$job['script']}</td>
			<td align="center">{$job['productdiff']}</td>
			<td align="center">{$job['versiondiff']}</td>
			<td align="center">{$job['checklist']}</td>
			<td align="center">{$job['environment']}</td>
			<td align="center">{$job['na']}</td>
			<td align="center">{$job['none']}</td>
			<td align="center">{$job['olddiff']}</td>
		{/if}
		{if $gui->tpreport == 1 }
			<td align="center">{$job['tplan']}</td>
			<td align="center">{$job['fail']}</td>
			<td align="center">{$job['switch']}</td>
			<td align="center">{$job['accept']}</td>
			<td align="center">{$job['nomerge']}</td>
			<td align="center">{$job['script']}</td>
			<td align="center">{$job['productdiff']}</td>
			<td align="center">{$job['versiondiff']}</td>
			<td align="center">{$job['checklist']}</td>
			<td align="center">{$job['environment']}</td>
			<td align="center">{$job['na']}</td>
			<td align="center">{$job['none']}</td>
			<td align="center">{$job['olddiff']}</td>
		{/if}
		</tr>
		{/foreach}
	</table>
    {/if}
{/if}
</div>
</body>
</html>