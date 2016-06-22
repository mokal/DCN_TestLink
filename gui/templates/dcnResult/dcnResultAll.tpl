{include file="inc_head.tpl"}
</head>
<body>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<p align='center'>
<table class="simple_tableruler" align="center">
<thead></thead>
<tbody>
	<tr>
	<th>测试报告</th>
	<th>测试结论</th>
	</tr>
	 {foreach from=$result item=myresult}
           <tr>
<td align="center">
{if $myresult['device_id']=='device_id'}<a href="./lib/dcnResult/dcnResult.php?fromlink=1&tplanid={$myresult['tplan_id']}&buildid=1&deviceid=1&topotype=999&suite=1" target="mainframe">{$myresult['result_report']}(点击编辑结论)</a>
{else}<a href="./lib/dcnResult/dcnResult.php?fromlink=1&tplanid={$myresult['tplan_id']}&deviceid={$myresult['device_id']}&buildid={$myresult['build_id']}&suite={$myresult['suite_id']}&topotype={$myresult['topo_type']}&devicename={$myresult['devicename']}&buildname={$myresult['buildname']}&suitename={$myresult['suitename']}&topotypename={$myresult['topotypename']}" target="mainframe">{$myresult['result_report']}(点击编辑结论)</a>{/if}
				</td>
				<td align="center">{if $myresult['device_id']!='device_id'}<a href="./lib/results/dcnReport.php?format=0&tplan_id={$myresult['tplan_id']}&device_id={$myresult['device_id']}&stack={if $myresult['device_id']!=1 && $myresult['topo_type'] != 999}1{else}0{/if}&build_id={$myresult['build_id']}" target="_black">{/if}
                {if $myresult['result']=='none'}>>未分析<<{/if}
           		   {if $myresult['result']=='pass'}>>通过<<{/if}
           		   {if $myresult['result']=='fail'}>>不通过<<{/if}
           		   {if $myresult['result']=='verify'}>>检验后通过<<{/if}{if $myresult['device_id']!='device_id'}(点击查看报告)</a>{/if}
           		</td>
           </tr>                                                
     {/foreach}
</tbody>
</table>
</p>
</body>
</html>