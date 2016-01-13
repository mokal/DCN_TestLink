{include file="inc_head.tpl" jsValidate="yes" openHead="no"}

<body>
<h1 class="title">DCN大数据分析 之 测试例:{$gui->data_type_name}</h1>
<div class="workBack">
{if $gui->do_report.status_ok}

{if $gui->data_type == 0 || $gui->data_type == 1 || $gui->data_type == 2 || $gui->data_type == 3 }
<table class="simple_tableruler sortable" style="text-align:left; margin-left: 2px;table-layout:fixed;">
    <tHead>
    <tr><th align="center" valign="middle" width="150">TestCase</th>
        <th align="center" valign="middle" >Summary</th>
        <th style="text-align:center;" width="90">共执行(次)</th>
        <th style="text-align:center;" width="80">{if $gui->data_type==0}非Pass{elseif $gui->data_type==1}Fail{elseif $gui->data_type==2}Accept{elseif $gui->data_type==3}N/A{/if}(次)</th>
        <th style="text-align:center;" width="50">%</th>
    </tr>
    </tHead>
    <tbody>
    {foreach from=$gui->topn item=case key=caseid}
     <tr><td align="center" valign="middle"><a href='/lib/execute/execHistory.php?tcase_id={$gui->tplan_tc[$caseid]['tcid']}' target='{$gui->tplan_tc[$caseid]['tcid']}_black'>{$gui->tplan_tc[$caseid]['name']}</a></td>
        <td >{$gui->tplan_tc[$caseid]['summary']}</td>
        <td style="text-align:center;">{$gui->allcase[$caseid]['total']}</td>
        <td style="text-align:center;">{$case['filter']}</td>
        <td style="text-align:center;">{math equation="x*100/y" y=$gui->allcase[$caseid]['total'] x=$case['filter'] format="%.2f"}%</td>
    </tr>
    {/foreach}
    </tbody>
</table>
{/if}
{if $gui->data_type == 4 }
<table class="simple_tableruler sortable" style="text-align:left; margin-left: 2px;table-layout:fixed;">
    <tHead>
    <tr><th align="center" valign="middle" width="150">TestCase</th>
        <th align="center" valign="middle" >Summary</th>
        <th style="text-align:center;" width="150">Script</th>
        <th style="text-align:center;" width="200">Create Time</th>
    </tr>
    </tHead>
    <tbody>
    {foreach from=$gui->topn item=case key=caseid}
     <tr>
        <td align="center" valign="middle">{$case['name']}</td>
        <td >{$case['summary']}</td>
        <td >{$case['preconditions']}</td>
        <td style="text-align:center;">{$case['creation_ts']}</td>
    </tr>
    {/foreach}
    </tbody>
</table>
{/if}


</body>

{else}
  	{$gui->do_report.msg}
{/if}  
</div>

</body>
</html>