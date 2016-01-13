{assign var="url_args" value="lib/dcnIssue/issueEdit.php"}
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

  <div class="workBack">
  	<form id="addPlatform" name="addPlatform" method="post" action="{$platform_edit_url}"
 		      onsubmit="javascript:return validateForm(this);">

  	<table class="common" style="width:50%">
  		<tr>
  			<th>测试例</th>
  			{assign var="input_testcase" value="testcase"}
  			<td><input type="text" name="{$input_testcase}"
  				         value="{$gui->testcase|escape}" required />
			  		{include file="error_icon.tpl" field="$input_testcase"}
			  </td>
  		</tr>
  		<tr>
  			<th>缺陷步骤</th>
  			{assign var="input_step" value="step"}
  			<td><input type="text" name="{$input_step}"
  				         value="{$gui->step|escape}" required />
			  		{include file="error_icon.tpl" field="$input_step"}
			  </td>
  		</tr>
  		<tr>
  			<th>产品流</th>
  			{assign var="input_product" value="product"}
  			<td><input type="text" name="{$input_product}"
  				         value="{$gui->product|escape}" required />
			  		{include file="error_icon.tpl" field="$input_product"}
			  </td>
  		</tr>
  		<tr>
  			<th>脚本流</th>
  			{assign var="input_script" value="script"}
  			<td><select name="{$input_script}">
  				        <option value ='6.3' {if $gui->script=='6.3'} selected='selected'{/if} >6.3</option>
  				        <option value ='7.0patch' {if $gui->script=='7.0patch'} selected='selected'{/if} >7.0patch</option>
  				        <option value ='7.2' {if $gui->script=='7.2'} selected='selected'{/if} >7.2</option>
  				        <option value ='7.3' {if $gui->script=='7.3'} selected='selected'{/if} >7.3</option>
				</select>
			</td>
  		</tr>
  		<tr>
  			<th>缺陷描述</th>
  			{assign var="input_comment" value="comment"}
  			<td><textarea name='{$input_comment}' rows='5' cols='80'>{$gui->comment}</textarea>
			  		{include file="error_icon.tpl" field="$input_comment"}
			  </td>
  		</tr>
  	</table>
  	<div class="groupBtn">	
	  	<input type="hidden" name="doAction" value="" />
	    <input type="submit" id="submitButton" name="submitButton" value="{$gui->submit_button_label}"
		         onclick="doAction.value='{$gui->submit_button_action}'" />
	  	<input type="button" value="{$labels.btn_cancel}"
		         onclick="javascript:location.href=fRoot+'lib/dcnIssue/issueView.php'" />
  	</div>
  	</form>
  </div>

{* --------------------------------------------------------------------------------------   *}

</body>
</html>
