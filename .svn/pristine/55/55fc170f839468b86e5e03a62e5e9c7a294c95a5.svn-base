{*
TestLink Open Source Project - http://testlink.sourceforge.net/
$Id: buildEdit.tpl,v 1.22 2010/11/06 11:42:47 amkhullar Exp $

Purpose: smarty template - Add new build and show existing

@internal revisions

*}
{assign var="managerURL" value="lib/plan/buildEdit.php"}
{assign var="cancelAction" value="lib/plan/buildView.php"}

{lang_get var="labels"
          s="warning,warning_empty_build_name,enter_build,enter_build_notes,active,
             open,builds_description,cancel,release_date,closure_date,closed_on_date,
             copy_tester_assignments, assignment_source_build,show_event_history,
             show_calender,clear_date"}

{include file="inc_head.tpl" openHead="yes" jsValidate="yes" editorType=$gui->editorType}
{include file="inc_ext_js.tpl" bResetEXTCss=1}
{include file="inc_del_onclick.tpl"}

<script src="/third_party/jquery/jquery-1.11.1.min.js"></script>
<script>
var build_devices = {$build_devices};
var device_topo = {$device_topo};
var device_topo_all = {$device_topo_all};
{literal}
function removeAllOptions(selectbox){
    var i;
    for(i=selectbox.options.length-1;i>=0;i--){
      selectbox.remove(i);
    }
}

$(document).ready(function(){
    $("#build_device_select").change(function(){
        var device = $("#build_device_select option:selected").val();
        $("#device_build_result")[0].value = build_devices[device].result;
        $("#device_result_summary")[0].value = build_devices[device].result_summary;
        $("#device_build_reviewer")[0].value = build_devices[device].reviewer;
        $("#device_review_summary")[0].value = build_devices[device].review_summary;

        var topoobj=document.getElementById('build_device_topo_select');
        removeAllOptions(topoobj);
        var option = document.createElement("option");
        option.text = '请选择拓扑' ;
        option.value = 999;
        topoobj.add(option);

         for(m=0;m<device_topo_all[device][999] ;m++){
              var option = document.createElement("option");
              option.text = device_topo_all[device][m][1] ;
              option.value = device_topo_all[device][m][0];
              topoobj.add(option);
        }
     });

    $("#build_device_topo_select").change(function(){
        var device = $("#build_device_select option:selected").val();
         if( device == 0 ){  
            alert("选择拓扑类型前，请先选择设备！");
        }else{
          var topo = $("#build_device_topo_select option:selected").val();
          $("#device_topo_build_result")[0].value = device_topo[device][topo].result;
          $("#device_topo_result_summary")[0].value = device_topo[device][topo].result_summary;
          $("#device_topo_build_reviewer")[0].value = device_topo[device][topo].reviewer;
          $("#device_topo_review_summary")[0].value = device_topo[device][topo].review_summary;
         }
   });

});
</script>

<script type="text/javascript">
{/literal}
var alert_box_title = "{$labels.warning|escape:'javascript'}";
var warning_empty_build_name = "{$labels.warning_empty_build_name|escape:'javascript'}";
{literal}
function validateForm(f)
{
  if (isWhitespace(f.build_name.value))
  {
      alert_message(alert_box_title,warning_empty_build_name);
      selectField(f, 'build_name');
      return false;
  }
  return true;
}
</script>

{/literal}
</head>


<body onload="showOrHideElement('closure_date',{$gui->is_open})">
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":""}
{config_load file="input_dimensions.conf" section=$cfg_section}

<h1 class="title">{$gui->main_descr|escape}</h1>

<div class="workBack">
{include file="inc_update.tpl" user_feedback=$gui->user_feedback 
         result=$sqlResult item="build"}

<div> 
  <h2>{$gui->operation_descr|escape}
    {if $gui->mgt_view_events eq "yes" && $gui->build_id > 0}
        <img style="margin-left:5px;" class="clickable" 
             src="{$smarty.const.TL_THEME_IMG_DIR}/question.gif" onclick="showEventHistoryFor('{$gui->build_id}','builds')" 
             alt="{$labels.show_event_history}" title="{$labels.show_event_history}"/>
    {/if}
  </h2>
  <form method="post" id="create_build" name="create_build" 
        action="lib/plan/buildEdit.php" onSubmit="javascript:return validateForm(this);">
   
  <table class="common" style="width:80%">
    <tr>
      <th style="background:none;">版本<br>名称</th>
      <td><input type="text" name="build_name" id="build_name" 
                 maxlength="{#BUILD_NAME_MAXLEN#}" 
                 value="{$gui->build_name|escape}" size="80" required />
                {include file="error_icon.tpl" field="build_name"}
      </td>

       <td>分设备填写测试结论, 请在下方填写<br>选择设备:<select id="build_device_select" name="build_device_select" >
              <option value=0  {if $gui->build_device_selected == NULL} selected="selected" {/if}>请选择设备</option>
                    {foreach from=$gui->build_device key=device_id item=device}
                        {if $device['run'] == 1}<option value={$device_id}  {if $gui->build_device_selected == $device_id} selected="selected" {/if} >{$device['name']}</option>{/if}
                    {/foreach}
	</select>
	</td>

       <td>分设备拓扑填写结论, 请在下方填写<br>选择拓扑:<select id="build_device_topo_select" name="build_device_topo_select" >
             <option value=999  selected="selected">请选择拓扑</option>
	</select>
	</td>

    </tr>

    <tr><th style="background:none;">版本<br>结论</th>
  	<td><select name="build_result">
  	    <option value ='none' {if $gui->build_result=='none'} selected='selected'{/if} >未分析</option>
	    <option value ='pass'  {if $gui->build_result=='pass'} selected='selected'{/if} >通过</option>
	    <option value ='fail'  {if $gui->build_result=='fail'} selected='selected'{/if} >不通过</option>
	    <option value ='verify'  {if $gui->build_result=='verify'} selected='selected'{/if} >检验后通过</option>
	</select>
	</td>

  	<td>设备结论<select id="device_build_result" name="device_build_result" >
  	    <option value ='none' selected='selected'>未分析</option>
	    <option value ='pass'>通过</option>
	    <option value ='fail'>不通过</option>
	    <option value ='verify'>检验后通过</option>
	</select>
	</td>

	<td>设备拓扑结论<select id="device_topo_build_result" name="device_topo_build_result" >
  	    <option value ='none' selected='selected'>未分析</option>
	    <option value ='pass'>通过</option>
	    <option value ='fail'>不通过</option>
	    <option value ='verify'>检验后通过</option>
	</select>
	</td>
    </tr>

    <tr><th style="background:none;">分析<br>与<br>总结</th>
      <td><textarea name="result_summary" rows=6 cols=80  >{$gui->result_summary|escape}</textarea></td>
      <td><textarea id="device_result_summary" name="device_result_summary" rows=6 cols=42  ></textarea></td>
     <td><textarea id="device_topo_result_summary" name="device_topo_result_summary" rows=6 cols=42  ></textarea></td>
    </tr>

    <tr><th style="background:none;">审核人</th>
      <td><select name="build_reviewer">
              <option value=''  {if $gui->build_reviewer == NULL} selected="selected" {/if}>None</option>
                    {foreach from=$gui->reviewers item=user}
                        <option value={$user['login']}  {if $gui->build_reviewer == $user['login']} selected="selected" {/if} >{$user['login']}</option>
                    {/foreach}
                </select>
      </td>
      <td>审核人<select id="device_build_reviewer" name="device_build_reviewer">
              <option value=0 selected="selected" >None</option>
                    {foreach from=$gui->reviewers item=user}
                        <option value={$user['login']} >{$user['login']}</option>
                    {/foreach}
                </select>
      </td>

    <td>审核人<select id="device_topo_build_reviewer" name="device_topo_build_reviewer">
              <option value=0 selected="selected" >None</option>
                    {foreach from=$gui->reviewers item=user}
                        <option value={$user['login']} >{$user['login']}</option>
                    {/foreach}
                </select>
      </td>
    </tr>

    <tr><th style="background:none;">审核<br>意见</th>
      <td><textarea name="review_summary" rows=3 cols=80 >{$gui->review_summary|escape}</textarea></td>
      <td><textarea id="device_review_summary" name="device_review_summary" rows=3 cols=42 ></textarea></td>
     <td><textarea id="device_topo_review_summary" name="device_topo_review_summary" rows=3 cols=42 ></textarea></td>
    </tr>

    <tr><th style="background:none;">show<br>version</th>
      <td>{$gui->notes}</td>
	  <td  colspan="2">{foreach from=$gui->build_device key=device_id item=device}
           {if $device['run'] == 1}
             {if $gui->device_topo_all[$device_id][999] == 1}
                <a href="/lib/results/dcnReport.php?format=0&tplan_id={$gui->tplan_id}&device_id={$device_id}&build_id={$gui->build_id}" target="_black">
              {/if}
              {if $gui->device_topo_all[$device_id][999] != 1}
                <a href="/lib/results/dcnReport.php?format=0&stack=1&tplan_id={$gui->tplan_id}&device_id={$device_id}&build_id={$gui->build_id}" target="_black">
              {/if}
           {$device['name']}
           {if $gui->build_devices[$device_id]['result'] == 'none'}未分析{/if}
		   {if $gui->build_devices[$device_id]['result'] == 'pass'}通过{/if}
		   {if $gui->build_devices[$device_id]['result'] == 'fail'}不通过{/if}
		   {if $gui->build_devices[$device_id]['result'] == 'verify'}验证后通过{/if}
		   </a>  此设备已执行如下拓扑类型:
           {foreach from=$gui->device_topo_all[$device_id] item=device_topo key=key}
              {if is_array($device_topo)}
                <br>{$device_topo[1]}:
                {if $gui->device_topo[$device_id][$device_topo[0]]['result'] == 'none'}未分析{/if}
		        {if $gui->device_topo[$device_id][$device_topo[0]]['result'] == 'pass'}通过{/if}
		        {if $gui->device_topo[$device_id][$device_topo[0]]['result'] == 'fail'}不通过{/if}
		        {if $gui->device_topo[$device_id][$device_topo[0]]['result'] == 'verify'}验证后通过{/if}
              {/if}
           {/foreach}
		   <br>{/if}
		   {if $device['run'] == 0}{$device['name']}:未曾执行<br>{/if}
           <br>{/foreach}</td>
    </tr>
    {* ====================================================================== 
    {if $gui->cfields2 != ''}
    <tr>
      <td  colspan="2">
        <div id="custom_field_container" class="custom_field_container">
        {$gui->cfields}
        </div>
      </td>
    </tr>
    {/if}
    *}

    {if $gui->cfields != ''}
      {foreach key=accessKey item=cf from=$gui->cfields}
      <tr>
        <th style="background:none;">{$cf.label}</th>
        <td>{$cf.input}</td>
      </tr>
      {/foreach}
    {/if}

    <tr><th style="background:none;">激活</th>
        <td><input type="checkbox"  name="is_active" id="is_active"  
                   {if $gui->is_active eq 1} checked {/if} />
        </td>
    </tr>

    <tr>
        <th style="background:none;">{$labels.open}</th>
        <td  colspan="2"><input type="checkbox"  name="is_open" id="is_open"  
                   {if $gui->is_open eq 1} checked {/if} 
                   onclick="showOrHideElement('closure_date',this.checked)"/>
            <span id="closure_date" style="display:none;">{$labels.closed_on_date}: {localize_date d=$gui->closed_on_date}</span>
            <input type="hidden" name="closed_on_date" value={$gui->closed_on_date}>
        Tip：请审核人填写完审核意见后勾掉此选项(关闭意味着版本测试工作结束)</td>
    </tr>

    <tr>
        <th style="background:none;">发布<br>日期</th>
        <td>
        {* BUGID 3716, BUGID 3930 *}
                <input type="text" 
                       name="release_date" id="release_date" 
               value="{$gui->release_date}" />
        <img title="{$labels.show_calender}" src="{$smarty.const.TL_THEME_IMG_DIR}/calendar.gif"
             onclick="showCal('release_date-cal','release_date','{$gsmarty_datepicker_format}');" >
        <img title="{$labels.clear_date}" src="{$smarty.const.TL_THEME_IMG_DIR}/trash.png"
               onclick="javascript:var x = document.getElementById('release_date'); x.value = '';" >
        <div id="release_date-cal" style="position:absolute;width:240px;left:300px;z-index:1;"></div>
        Tip: 若未选择日期，系统创建时默认为当前日期</td>
    </tr>
    
  </table>
  <p>{$labels.builds_description}</p>
  <div class="groupBtn">  

    {* BUGID 628: Name edit Invalid action parameter/other behaviours if Enter pressed. *}
    <input type="hidden" name="do_action" value="{$gui->buttonCfg->name}" />
    <input type="hidden" name="build_id" value="{$gui->build_id}" />
    
    <input type="submit" name="{$gui->buttonCfg->name}" value="{$gui->buttonCfg->value|escape}"
           onclick="do_action.value='{$gui->buttonCfg->name}'"/>
    <input type="button" name="go_back" value="{$labels.cancel}" 
           onclick="javascript: location.href=fRoot+'{$cancelAction}';"/>

  </div>
  </form>
</div>
</div>
</body>
</html>
