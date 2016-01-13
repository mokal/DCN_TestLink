{*
TestLink Open Source Project - http://testlink.sourceforge.net/ 

@filesource planView.tpl

@internal development hint:
some smarty and javascript variables are created on the inc_*.tpl files.
     
@internal revisions
@since 1.9.10
*}
{$cfg_section=$smarty.template|basename|replace:".tpl":""}
{config_load file="input_dimensions.conf" section=$cfg_section}

{* Configure Actions *}
{$managerURL="lib/plan/planEdit.php"}
{$editAction="$managerURL?do_action=edit&amp;tplan_id="}
{$deleteAction="$managerURL?do_action=do_delete&tplan_id="}
{$createAction="$managerURL?do_action=create"}
{$exportAction="lib/plan/planExport.php?tplan_id="}
{$importAction="lib/plan/planImport.php?tplan_id="}


{lang_get var="labels" 
          s='testplan_title_tp_management,testplan_txt_empty_list,sort_table_by_column,
          testplan_th_name,testplan_th_notes,testplan_th_active,testplan_th_delete,
          testplan_alt_edit_tp,alt_active_testplan,testplan_alt_delete_tp,public,
          btn_testplan_create,th_id,error_no_testprojects_present,btn_export_import,
          export_import,export,import,export_testplan_links,import_testplan_links,build_qty,
          testcase_qty,platform_qty,active_click_to_change,inactive_click_to_change,
          testcase_number_help,platform_number_help,build_number_help'}


{lang_get s='warning_delete_testplan' var="warning_msg"}
{lang_get s='delete' var="del_msgbox_title"}

{include file="inc_head.tpl" openHead="yes" enableTableSorting="yes"}
{include file="inc_del_onclick.tpl"}

<script type="text/javascript">
/* All this stuff is needed for logic contained in inc_del_onclick.tpl */
var del_action=fRoot+'{$deleteAction}';
</script>

</head>

<body {$body_onload}>

<h1 class="title">{$gui->main_descr|escape}</h1>
{if $gui->user_feedback ne ""}
  <div>
    <p class="info">{$gui->user_feedback}</p>
  </div>
{/if}

<div class="workBack">
 {if $gui->grants->testplan_create && $gui->tproject_id > 0}
 <div class="groupBtn">
    <form method="post" action="{$createAction}">
      <input type="submit" name="create_testplan" value="添加测试计划" />
    </form>
  </div>
 {/if}


<div id="testplan_management_list">
{if $gui->tproject_id <= 0}
  {$labels.error_no_testprojects_present}
{elseif $gui->tplans eq ''}
  {$labels.testplan_txt_empty_list}
{else}
  <form method="post" id="testPlanView" name="testPlanView" action="{$managerURL}">
    <input type="hidden" name="do_action" id="do_action" value="">
    <input type="hidden" name="tplan_id" id="tplan_id" value="">

&nbsp;1. <strong>设备覆盖</strong>表示该测试计划已经定义的设备覆盖数量，点击数字可进入设备引用管理界面；</br>
&nbsp;2. <strong>测试例覆盖</strong>表示该测试计划已经定义的总测试例数量，点击数字可进入测试例引用管理界面；</br>
&nbsp;3. <strong>版本</strong>表示该测试计划上已经存在的版本数量，点击数字可进入版本管理界面；</br>

  <table id='item_view'class="simple_tableruler sortable">
    <thead>
    <tr>
      <th style="width:200px;" align="center">{$tlImages.toggle_api_info}{$tlImages.sort_hint}{$labels.testplan_th_name}</th>
      <th class="{$noSortableColumnClass}">脚本流</th>      
      <th class="{$noSortableColumnClass}">{$labels.testplan_th_notes}</th>
      <th title="{$labels.testcase_number_help}" style="width:60px;" align="center">{$tlImages.sort_hint}测试例覆盖</th>
      <th title="{$labels.build_number_help}" style="width:50px;" align="center">{$tlImages.sort_hint}版本</th>
      {if $gui->drawPlatformQtyColumn}
        <th title="{$labels.platform_number_help}" style="width:50px;" align="center">{$tlImages.sort_hint}设备覆盖</th>
      {/if} 
      <th class="{$noSortableColumnClass}">{$labels.testplan_th_active}</th>
      <th class="{$noSortableColumnClass}">{$labels.public}</th>
      <th class="{$noSortableColumnClass}">{$labels.testplan_th_delete}</th>
    </tr>
    </thead>
    <tbody>
    {foreach item=testplan from=$gui->tplans}
    <tr>
      <td style="width:200px;" align="left"><span class="api_info" style='display:none'>{$tlCfg->api->id_format|replace:"%s":$testplan.id}</span>
          <a href="{$editAction}{$testplan.id}"> 
             {$testplan.name|escape} 
             {if $gsmarty_gui->show_icon_edit}
                 <img title="{$labels.testplan_alt_edit_tp}"  alt="{$labels.testplan_alt_edit_tp}" 
                      src="{$tlImages.edit}"/>
             {/if}  
          </a>
      </td>
      <td>
        {$testplan.script_tag}
      </td>
      <td>
        {$testplan.notes}
      </td>
      <td style="width:60px;" align="center">
        <a href="/lib/dcnTplanCase/tplanCaseView.php?id={$testplan.id}&name={$testplan.name}">{$testplan.tcase_qty}</a>
      </td>
      <td style="width:50px;" align="center">
        <a href="/lib/plan/buildView.php?id={$testplan.id}">{$testplan.build_qty}</a>
      </td>
      {if $gui->drawPlatformQtyColumn}
      <td style="width:50px;" align="center">
          <a href="/lib/platforms/platformsAssign.php?tplan_id={$testplan.id}">{$testplan.platform_qty}</a>
        </td>
      {/if} 

      <td class="clickable_icon">
        {if $testplan.active==1} 
            <input type="image" style="border:none" 
                   title="{$labels.active_click_to_change}" alt="{$labels.active_click_to_change}" 
                   onClick = "do_action.value='setInactive';tplan_id.value={$testplan.id};"
                   src="{$tlImages.on}"/>
          {else}
            <input type="image" style="border:none" 
                 title="{$labels.inactive_click_to_change}" alt="{$labels.inactive_click_to_change}" 
                 onClick = "do_action.value='setActive';tplan_id.value={$testplan.id};"
                 src="{$tlImages.off}"/>
          {/if}
      </td>
      <td class="clickable_icon">
        {if $testplan.is_public eq 1} 
            <img style="border:none" title="{$labels.public}"  alt="{$labels.public}" src="{$tlImages.checked}"/>
          {else}
            &nbsp;        
          {/if}
      </td>
      <td class="clickable_icon">
          <img style="border:none;cursor: pointer;" 
               alt="{$labels.testplan_alt_delete_tp}"
             title="{$labels.testplan_alt_delete_tp}" 
             onclick="delete_confirmation({$testplan.id},'{$testplan.name|escape:'javascript'|escape}',
                                          '{$del_msgbox_title}','{$warning_msg}');"
             src="{$tlImages.delete}"/>
      </td>
    </tr>
    {/foreach}
    </tbody>
  </table>
</form>

{/if}
</div>


</div>

</body>
</html>