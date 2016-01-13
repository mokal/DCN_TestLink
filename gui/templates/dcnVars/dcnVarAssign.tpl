{include file="inc_head.tpl" jsValidate="yes" openHead="yes" enableTableSorting="yes"}

</head>
<body>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<h1 class="title">测试例分支管理</h1>

<div class="workBack" align="center">

<div class="groupBtn" align=center>
<p align=center><a href='/lib/dcnVars/viewVar.php?var_id={$gui->var_id}&suite_id={$gui->suite_id}'>返    回</p>
</div>

<table class="simple_tableruler">
  <tr>
    <th align="center">添加测试例</th><th align="center">删除测试例</th>
  </tr>
  <tr>
    <td><table class="simple_tableruler">
          {foreach item=case from=$gui->needadd}
          <tr><td align="center">{$case}</td></tr>
          {/foreach}
          <tr><td>&nbsp</td></tr>
        </table>
    </td>

    <td><table class="simple_tableruler">
         {foreach item=case from=$gui->needdelete}
         <tr><td align="center">{$case}</td></tr>
         {/foreach}
         <tr><td>&nbsp</td></tr>
       </table>
    </td>
  </tr>
</table>
</div>
</body>
</html>