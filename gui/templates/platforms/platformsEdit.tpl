{*
TestLink Open Source Project - http://testlink.sourceforge.net/
@filesource	platformsEdit.tpl
Purpose: smarty template - View all platforms

@internal revisions
*}
{assign var="url_args" value="lib/platforms/platformsEdit.php"}
{assign var="platform_edit_url" value="$basehref$url_args"}

{lang_get var="labels"
          s="warning,warning_empty_platform,show_event_history,
             th_platform,th_notes,btn_cancel"}


{include file="inc_head.tpl" jsValidate="yes" openHead="yes"}
{include file="inc_del_onclick.tpl"}

{literal}
<script type="text/javascript">
{/literal}
var alert_box_title = "{$labels.warning|escape:'javascript'}";
var warning_empty_platform = "{$labels.warning_empty_platform|escape:'javascript'}";
{literal}
function validateForm(f)
{
	if (isWhitespace(f.name.value))
  {
    alert_message(alert_box_title,warning_empty_platform);
    selectField(f, 'name');
    return false;
  }
	return true;
}
</script>
{/literal}
</head>

<body>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<h1 class="title">{$gui->action_descr|escape}</h1>

{include file="inc_feedback.tpl" user_feedback=$gui->user_feedback}

{if $gui->canManage ne ""}
  <div class="workBack">
  
  	<form id="addPlatform" name="addPlatform" method="post" action="{$platform_edit_url}"
 		      onsubmit="javascript:return validateForm(this);">

  	<div class="groupBtn">	
	  	<input type="hidden" name="doAction" value="" />
	    <input type="submit" id="submitButton" name="submitButton" value="{$gui->submit_button_label}"
		         onclick="doAction.value='{$gui->submit_button_action}'" />
	  	<input type="button" value="{$labels.btn_cancel}"
		         onclick="javascript:location.href=fRoot+'lib/platforms/platformsView.php'" />
  	</div>
  	
  	<table class="common" style="width:50%">
  		<tr>
  			<th>{$labels.th_platform}</th>
  			{assign var="input_name" value="name"}
  			<td><input type="text" name="{$input_name}"
  			           size="{#PLATFORM_SIZE#}" maxlength="{#PLATFORM_MAXLEN#}"
  				         value="{$gui->name|escape}" required />
			  		{include file="error_icon.tpl" field="$input_name"}
			  </td>
  		</tr>
        <tr>
  			<th>支持三层功能</th>
			{assign var="input_supportl3" value="supportl3"}
  			<td><select name="{$input_supportl3}">
  				        <option value ='1' {if $gui->supportl3==1} selected='selected'{/if} >支持</option>
						<option value ='0'  {if $gui->supportl3==0} selected='selected'{/if} >不支持</option>
				</select>
			</td>
  		</tr>
        <tr>
  			<th>设备类型</th>
			{assign var="input_isboxswitch" value="isboxswitch"}
 			<td><select name="{$input_isboxswitch}">
  				        <option value ='0' {if $gui->isboxswitch==0} selected='selected'{/if} >机架设备</option>
						<option value ='1'  {if $gui->isboxswitch==1} selected='selected'{/if} >盒式设备</option>
				</select>
			</td>
  		</tr>
        <tr>
  			<th>端口线速</th>
			{assign var="input_linespeed" value="linespeed"}
 			<td><select name="{$input_linespeed}">
  				        <option value ='100' {if $gui->linespeed==100} selected='selected'{/if} >100 Mbps</option>
						<option value ='1000'  {if $gui->linespeed==1000} selected='selected'{/if} >1000 Mbps</option>
				</select>
			</td>
  		</tr>
  		  		
        <tr>
  			<th>确认2.0分支</th>
			{assign var="input_affirm2devicegroup" value="affirm2devicegroup"}
 			<td><select name="{$input_affirm2devicegroup}">
 			    <option value=0 selected='selected'>unDefined</option>
 			    {foreach from=$gui->vars item=name}
 			    {if $name[1]==3959}
                 <option value={$name[0]} {if $gui->affirm2devicegroup==$name[0]}selected='selected' {/if}>{$name[2]}</option>
                {/if}
                {/foreach}
            </select>
			</td>
  		</tr>
  		
        <tr>
  			<th>确认3.0分支</th>
			{assign var="input_affirm3devicegroup" value="affirm3devicegroup"}
 			<td><select name="{$input_affirm3devicegroup}">
 			    <option value=0 selected='selected'>unDefined</option>
 			    {foreach from=$gui->vars item=name}
 			    {if $name[1]==4944}
                 <option value={$name[0]} {if $gui->affirm3devicegroup==$name[0]}selected='selected' {/if}>{$name[2]}</option>
                {/if}
                {/foreach}
            </select>
			</td>
  		</tr>
 
         <tr>
  			<th>功能测试分支</th>
			{assign var="input_functiondevicegroup" value="functiondevicegroup"}
 			<td><select name="{$input_functiondevicegroup}">
 			    <option value=0 selected='selected'>unDefined</option>
 			    {foreach from=$gui->vars item=name}
 			    {if $name[1]==67}
                 <option value={$name[0]} {if $gui->functiondevicegroup==$name[0]}selected='selected' {/if}>{$name[2]}</option>
                {/if}
                {/foreach}
            </select>
			</td>
  		</tr>

        <tr>
  			<th>性能参数组</th>
			{assign var="input_performance_id" value="performance_id"}
 			<td><select name="{$input_performance_id}">
 			    <option value=0 selected='selected'>unDefined</option>
 			    {foreach from=$gui->allPerformance item=p}
                 <option value={$p['id']} {if $gui->performance_id==$p['id']}selected='selected' {/if}>{$p['name']}</option>
                {/foreach}
            </select>
			</td>
  		</tr>
  		 		  		
  		<tr>
  			<th>{$labels.th_notes}</th>
  			<td>{$gui->notes}</td>
  		</tr>
  	</table>
  	</form>
  </div>
{/if}
{* --------------------------------------------------------------------------------------   *}

</body>
</html>
