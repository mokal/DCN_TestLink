{include file="inc_head.tpl"}
</head>
<body>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<form name='form1' action='/lib/dcnResult/dcnResultDetails.php?save=1&tplanid={$tplanid}&deviceid={$deviceid}&buildid={$buildid}&topotype={$topotype}&suite={$suite}' method="post" onsubmit="">
<div align="center">
{if $gui->saveresult==1}<span style="color:Red">保存成功</span>{elseif $gui->saveresult==0}<span style="color:Red">保存失败</span>{/if}
</div>
<p align='center'>
<table class="simple_tableruler" align="center">
<thead></thead>
<tbody>
	<tr>
		<th>测试结论</th>
		<td>
		{if $result['result_summary'] != '###没有被执行过###'}<a href="./lib/results/dcnReport.php?format=0&tplan_id={$tplanid}&device_id={$deviceid}&stack={if $deviceid!=1 && $topotype != 999}1{else}0{/if}&build_id={$buildid}" target="_black">查看详细测试报告</a>{/if} <input type="text" id="result_report" name="result_report" style="width:450px;" value={$result['result_report']}></input>
		<select id="result" name="result" >
  	    <option value ='none'>未分析</option>
	    <option value ='pass' {if $result['result'] =='pass'}selected='selected'{/if}>通过</option>
	    <option value ='fail' {if $result['result'] =='fail'}selected='selected'{/if}>不通过</option>
	    <option value ='verify' {if $result['result'] =='verify'}selected='selected'{/if}>检验后通过</option>
	</select>
	
	</td>
	</tr>
	<tr>
		<th>结论详细描述</th>
		<td><textarea id="result_summary" name="result_summary" rows=15 cols=150 >{$result['result_summary']|escape}</textarea></td>
	</tr>
	<tr>
		<th>审 核 人</th>
		<td><select name="reviewer" id="reviewer">
              <option value=''  {if $result->reviewer == NULL} selected="selected" {/if}>None</option>
                    {foreach from=$gui->reviewers item=user}
                        <option value={$user['login']}  {if $result['reviewer'] == $user['login']} selected="selected" {/if} >{$user['login']}</option>
                    {/foreach}
                </select>
      </td>
	</tr>
	<tr>
		<th>审核意见</th>
		<td><textarea id="review_summary" name="review_summary" rows=4 cols=150 >{$result['review_summary']|escape}</textarea></td>
	</tr>
</tbody>
</table>
</p>
<div align="center">
<input type='submit' align="center" value='保存测试结论'>
</div>
</form>
</body>
</html>