{* 
TestLink Open Source Project - http://testlink.sourceforge.net/

Purpose: smarty template - show Test Results and Metrics

@filesource	resultsGeneral.tpl
@internal revisions

*}

{lang_get var="labels"
     s='generated_by_TestLink_on, th_progress,elapsed_seconds,important_notice,from, until'}

{include file="inc_head.tpl"}
<body>
<h1 class="title">DCN Test Report</h1>

<div class="workBack">
{include file="inc_result_tproject_tplan.tpl" 
         arg_tproject_name=$gui->tproject_name arg_tplan_name=$gui->tplan_name arg_build_name=$gui->build_by_id['name']}	

{if $gui->do_report.status_ok}

   <hr>
   {* ----summary------- *}
    <strong>测试结论:</strong>{$gui->testresult}
     <br><strong>分析与总结:</strong><br>
     {nl2br($gui->resultsummary)}
   <hr>
  {* ----- result items----------- *}
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
    {foreach item=device from=$gui->platformSet_flip}
		<tr>
		<td>{$gui->platformSet[$device]}</td>
		<td>{$gui->result_total[$device]}</td>
		<td>{$gui->result_pass[$device]}</td>
		<td>{if $gui->result_fail[$device] != 0}<span style="color:#E53333;">{/if}{$gui->result_fail[$device]}{if $gui->result_fail[$device] != 0}</span>{/if}</td>
	         <td>{$gui->result_accept[$device]}</td>
	         <td>{$gui->result_block[$device]}</td>
		<td>{$gui->result_skip[$device]}</td>
		<td>{$gui->result_warn[$device]}</td>
		<td>{$gui->result_na[$device]}</td>
		<td>{$gui->result_notrun[$device]}</td>
    {/foreach}
		</tr>
	</table>


  <br><strong>结果记录:</strong>
	<table class="simple_tableruler sortable" style="text-align:left; margin-left: 2px;">
		<tr>
			<th>Test Case</th>
			<th>Summary</th>
			<th>Platform</th>
			<th>Result</th>
			<th>tester</th>
			<th>notes</th>
		</tr>
    {foreach item=res from=$gui->testresults}
		<tr>
		<td><a href='/lib/execute/execHistory.php?tcase_id={$res.tcid}' target='{$res.tcid}_black'>{$res.name}</a></td>
		<td><a href='/lib/execute/execHistoryBuild.php?tplan_id={$gui->tplan_id}&build_id={$gui->build_id}&tcase_id={$res.tcid}' target='{$res.tcid}_black'>{$res.summary}</a></td>
		<td>{$res.platform_name}</td>
		<td>{if $res.status != 'Pass' }<span style="color:#E53333;">{/if}{$res.status}{if $res.status != 'Pass'}</span>{/if}</td>
		<td>{$res.login}</td>
		<td>{$res.notes}</td>
    {/foreach}
		</tr>
	</table>
  {* ----- result items end----------- *}
  <p class="italic">{$labels.info_gen_test_rep}</p>
	<p>{$labels.generated_by_TestLink_on} {$smarty.now|date_format:$gsmarty_timestamp_format}</p>
	<p>{$labels.elapsed_seconds} {$gui->elapsed_time}</p>

{else}
  	{$gui->do_report.msg}
{/if}  
</div>

</body>
</html>