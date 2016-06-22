{* 
TestLink Open Source Project - http://testlink.sourceforge.net/

Purpose: smarty template - show Test Results and Metrics

@filesource	resultsGeneral.tpl
@internal revisions

*}

{lang_get var="labels"
     s='trep_kw,trep_owner,trep_comp,generated_by_TestLink_on, priority,
       	 th_overall_priority, th_progress, th_expected, th_overall, th_milestone,
       	 th_tc_priority_high, th_tc_priority_medium, th_tc_priority_low,
         title_res_by_kw,title_res_by_owner,title_res_by_top_level_suites,
         title_report_tc_priorities,title_report_milestones,elapsed_seconds,
         title_metrics_x_build,title_res_by_platform,th_platform,important_notice,
         report_tcase_platorm_relationship, th_tc_total, th_completed, th_goal,
         th_build, th_tc_assigned, th_perc_completed, from, until,
         info_res_by_top_level_suites, info_report_tc_priorities, info_res_by_platform,
         info_report_milestones_prio, info_report_milestones_no_prio, info_res_by_kw,
         info_gen_test_rep'}

{include file="inc_head.tpl"}
{literal}
<link href="http://localhost/dcnReportCss/css/dcnReportBuildPlatform.css" type="text/css" rel="stylesheet" />

<SCRIPT type=text/javascript>
function selectTag(showContent,selfObj){
	// 操作标签
	var tag = document.getElementById("tags").getElementsByTagName("li");
	var taglength = tag.length;
	for(i=0; i<taglength; i++){
		tag[i].className = "";
	}
	selfObj.parentNode.className = "selectTag";
	// 操作内容
	for(i=0; j=document.getElementById("tagContent"+i); i++){
		j.style.display = "none";
	}
	document.getElementById(showContent).style.display = "block";
}
</SCRIPT>


{/literal}
<body>
<h1 class="title">DCN Test Report</h1>

<div class="workBack">
{include file="inc_result_tproject_tplan.tpl" 
         arg_tproject_name=$gui->tproject_name arg_tplan_name=$gui->tplan_name arg_build_name=$gui->build_by_id['name']}	

{if $gui->do_report.status_ok}

   <hr>
   <strong>结果统计:</strong><inpput type='button'><a href='/lib/results/dcnReportDownloadExcel.php?format={$selectedReportType}&amp;tplan_id={$gui->tplan_id}' target='_black'>点击下载Excel报告</a></input>
	<table class="simple_tableruler sortable" style="text-align:left; margin-left: 2px;">
		<tr>
			<th>Device</th>
			<th>Total</th>
			<th>Pass</th>
			<th>Failed</th>
			<th>Accept</th>
			<th>Block</th>
			<th>Skip</th>
			<th>Warn</th>
			<th>N/A</th>
			<th>NOT RUN</th>
		</tr>
    {foreach item=deviceid from=$gui->platformSet_flip}
		<tr>
		<td>{$gui->platformSet[$deviceid]}</td>
		<td>{$gui->result_total[$deviceid]}</td>
		<td>{$gui->result_pass[$deviceid]}</td>
		<td>{if $gui->result_fail[$deviceid] != 0}<span style="color:#E53333;">{/if}{$gui->result_fail[$deviceid]}{if $gui->result_fail[$deviceid] != 0}</span>{/if}</td>
	         <td>{$gui->result_accept[$deviceid]}</td>
	         <td>{$gui->result_block[$deviceid]}</td>
		<td>{$gui->result_skip[$deviceid]}</td>
		<td>{$gui->result_warn[$deviceid]}</td>
		<td>{$gui->result_na[$deviceid]}</td>
		<td>{$gui->result_notrun[$deviceid]}</td>
    {/foreach}
		</tr>
	</table>
       <br>
 {* ----- result items----------- *}

  <DIV id=con>
    <UL id=tags>
      {$index = 0}
      {foreach item=deviceid from=$gui->platformSet_flip}
      	<LI class=selectTag><A onClick="selectTag('tagContent{$index}',this)" href="javascript:void(0)">{$gui->platformSet[$deviceid]}</A></LI>
         {$index = $index+1}
     {/foreach}
    </UL>
  <DIV id=tagContent>
   {$index = 0}
   {foreach item=deviceid from=$gui->platformSet_flip}
   	<DIV  id=tagContent{$index}{if $index eq 0} class="tagContent selectTag" {else} style="display:none" {/if}>
  		<strong>资源环境:</strong><br>
		    <table border="2">
		         <tr>
			 <th>测试时间</th>
			 <td colspan="4" scope="col">{$gui->buildStartTime}至{$gui->buildStartTime}</td>
		         </tr>
			<tr>
				<th>&nbsp;</th>
				<th>设备角色</th>
				<th>设备名称</th>
				<th>资产编号</th>
				<th>板卡编号</th>
			</tr>
			<tr>
				<th rowspan="3" style="text-align:center">硬件特征</th>
				<td>主测设备</td>
				<td>{$gui->platformSet[$deviceid]}</td>
				<td>{$gui->test_env[$deviceid].s1sn}&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>辅测设备</td>
				<td>{$gui->test_env[$deviceid].s2device}&nbsp;</td>
				<td>{$gui->test_env[$deviceid].s2sn}&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>其他设备</td>
				<td>IXIA</td>
				<td>{$gui->test_env[$deviceid].ixia_ip}&nbsp;</td>
				<td><strong>TP1</strong>：{$gui->test_env[$deviceid].tp1}；<strong>TP2</strong>：{$gui->test_env[$deviceid].tp2}</td>
			</tr>
			<tr>
				<th rowspan="7" style="text-align:center">测试拓扑图</th>
				<td rowspan="7" colspan="2" style="text-align:center"><img src={$gui->test_topo}></td>
				<th rowspan="7" style="text-align:center">拓扑信息</th>
				<td><strong>S1P1</strong>：{$gui->test_env[$deviceid].s1p1}&nbsp;</td>
			</tr>
			<tr>
				<td><strong>S1P2</strong>：{$gui->test_env[$deviceid].s1p2}&nbsp;</td>
			</tr>
			<tr>
				<td><strong>S1P3</strong>：{$gui->test_env[$deviceid].s1p3}&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><strong>S2P1</strong>：{$gui->test_env[$deviceid].s2p1}&nbsp;</td>
			</tr>
			<tr>
				<td><strong>S2P2</strong>：{$gui->test_env[$deviceid].s2p2}&nbsp;</td>
			</tr>
			<tr>
				<td><strong>S2P3</strong>：{$gui->test_env[$deviceid].s2p3}&nbsp;</td>
			</tr>
		</table>
  <br><strong>结果记录:</strong><br>
    	<table class="simple_tableruler sortable" style="text-align:left; margin-left: 2px;">
		<tr>
			<th>Test Case</th>
			<th>Summary</th>
			<th>Result</th>
			<th>tester</th>
			<th>notes</th>
		</tr>
    	{foreach item=res from=$gui->testresults[$deviceid]}
		<tr>
			<td><a href='/lib/execute/execHistory.php?tcase_id={$res.tcid}' target='{$res.tcid}_black'>{$res.name}</a></td>
			<td><a href='/lib/execute/execHistoryBuildPlatform.php?tplan_id={$gui->tplan_id}&build_id={$gui->build_id}&device_id={$res.platform_id}&tcase_id={$res.tcid}' target='{$res.tcid}_black'>{$res.summary}</a></td>
			<td>{if $res.status != 'Pass' }<span style="color:#E53333;">{/if}{$res.status}{if $res.status != 'Pass'}</span>{/if}</td>
			<td>{$res.login}</td>
			<td>{$res.notes}</td>
		</tr>
		{/foreach}
	</table>
   	</DIV>
  {$index = $index+1}
  {/foreach}
  </DIV>
</DIV>

{else}
  	{$gui->do_report.msg}
{/if}  
</div>

</body>
</html>