{include file="inc_head.tpl" jsValidate="yes" openHead="yes" enableTableSorting="yes"}

</head>
<body>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<h1 class="title">测试计划-用例引用管理</h1>

<div class="workBack" align="center">

<table class="simple_tableruler">
  <tr>
    <th align="center">待添加测试例</th><th align="center">添加成功测试例</th><th align="center">待删除测试例</th><th align="center">删除成功测试例</th><th align="center">已被执行禁用</th>
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
         {foreach item=case from=$gui->added}
         <tr><td align="center">{$case}</td></tr>
         {/foreach}
         <tr><td>&nbsp</td></tr>
       </table>
    </td>
    <td><table class="simple_tableruler">
         {foreach item=case from=$gui->candelete}
         <tr><td align="center">{$case}</td></tr>
         {/foreach}
         <tr><td>&nbsp</td></tr>
       </table>
    </td>
    <td><table class="simple_tableruler">
         {foreach item=case from=$gui->deleted}
         <tr><td align="center">{$case}</td></tr>
         {/foreach}
         <tr><td>&nbsp</td></tr>
       </table>
    </td>
    <td><table class="simple_tableruler">
         {foreach item=case from=$gui->deactived}
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