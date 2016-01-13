{*
TestLink Open Source Project - http://testlink.sourceforge.net/

Purpose: smarty template - View all platforms

@filesource platformsView.tpl

@internal revisions
20110409 - franciscom - BUGID 4368: Provide WYSIWYG Editor for platform notes
20100119 - Eloff	- added ability to show/hide platform id for API
*}
{include file="inc_head.tpl" jsValidate="yes" openHead="yes" enableTableSorting="yes"}
{include file="inc_del_onclick.tpl"}

{lang_get var='labels'
          s='th_notes,th_platform,th_delete,btn_import,btn_export,
             menu_manage_platforms,alt_delete_platform,warning_delete_platform,
             warning_cannot_delete_platform,delete,
             menu_assign_kw_to_tc,btn_create_platform'}

{lang_get s='warning_delete_platform' var="warning_msg" }
{lang_get s='warning_cannot_delete_platform' var="warning_msg_cannot_del" }
{lang_get s='delete' var="del_msgbox_title" }

{assign var="viewAction" value="lib/platforms/platformsView.php"}
{assign var="dummy" value="lib/platforms/platformsImport.php?goback_url="}
{assign var="importAction" value="$basehref$dummy$basehref$viewAction"}


<script type="text/javascript">
<!--
	/* All this stuff is needed for logic contained in inc_del_onclick.tpl */
	var del_action=fRoot+'lib/platforms/platformsEdit.php?doAction=do_delete&id=';
//-->
</script>
 
</head>
<body {$body_onload}>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<h1 class="title">{$labels.menu_manage_platforms}</h1>
{include file="inc_feedback.tpl" user_feedback=$gui->user_feedback}
<div class="workBack">
	<div class="groupBtn">	
   		<form style="float:left" name="platform_view" id="platform_view" method="post" action="lib/platforms/platformsEdit.php">
	  		<input type="hidden" name="doAction" value="" />
		  	{if $gui->canManage ne ""}
		    	<input type="submit" id="create_platform" name="create_platform" 	value="{$labels.btn_create_platform}"
		           	 onclick="doAction.value='create'"/>
			  {/if}
		</form>
    </div>

{if $gui->platforms != ''}
	<table class="simple_tableruler sortable">
		<tr>
			<th width="30%">{$tlImages.toggle_api_info}{$tlImages.sort_hint}{$labels.th_platform}</th>
			<th>{$tlImages.sort_hint}确认2.0分支</th>
			<th>{$tlImages.sort_hint}确认3.0分支</th>
			<th>{$tlImages.sort_hint}功能测试分支</th>
			<th>{$tlImages.sort_hint}支持三层功能</th>
			<th>{$tlImages.sort_hint}设备类型</th>
			<th>{$tlImages.sort_hint}端口线速</th>
			<th>{$tlImages.sort_hint}性能参数组</th>
			<th>{$tlImages.sort_hint}{$labels.th_notes}</th>
			{if $gui->canManage != ""}
				<th>删</th>
			{/if}
		</tr>
		{section name=platform loop=$gui->platforms}
		<tr>
			<td>
				<span class="api_info" style='display:none'>{$tlCfg->api->id_format|replace:"%s":$gui->platforms[platform].id}</span>
				{if $gui->canManage != ""}
					<a href="lib/platforms/platformsEdit.php?doAction=edit&amp;id={$gui->platforms[platform].id}">
				{/if}
				{$gui->platforms[platform].name|escape}
				{if $gui->canManage != ""}
					</a>
				{/if}
			</td>
			<td>{$gui->platforms[platform].affirm2_var_name|escape}</td>
			<td>{$gui->platforms[platform].affirm3_var_name|escape}</td>
			<td>{$gui->platforms[platform].function_var_name|escape}</td>
			<td>{if $gui->platforms[platform].supportl3==1}支持{else}不支持{/if}</td>
			<td>{if $gui->platforms[platform].isboxswitch==1}盒式{else}机架{/if}</td>
			<td>{$gui->platforms[platform].linespeed|escape}Mbps</td>
			<td>{$gui->platforms[platform].performance_name|escape}</td>
			{* when using rich webeditor strip_tags is needed - franciscom *}
			<td>{$gui->platforms[platform].notes|strip_tags|strip|truncate:#PLATFORM_NOTES_TRUNCATE_LEN#}</td>
			
			{if $gui->canManage != ""}
			<td class="clickable_icon">
				{if $gui->platforms[platform].linked_count eq 0}
				<img style="border:none;cursor: pointer;"	alt="{$labels.alt_delete_platform}"
						title="{$labels.alt_delete_platform}"	src="{$tlImages.delete}"
						onclick="delete_confirmation({$gui->platforms[platform].id},
							      '{$gui->platforms[platform].name|escape:'javascript'|escape}', '{$del_msgbox_title|escape:'javascript'}','{$warning_msg|escape:'javascript'}');" />
				{else}
					<img style="border:none;cursor: pointer;" 	alt="{$labels.alt_delete_platform}"
						title="{$labels.alt_delete_platform}"	src="{$tlImages.delete_disabled}"
						onclick="alert_message_html('{$del_msgbox_title|escape:'javascript'}','{$warning_msg_cannot_del|replace:'%s':$gui->platforms[platform].name|escape:'javascript'}');" />
				{/if}
			</td>
			{/if}
		</tr>
		{/section}
	</table>
 {/if}
	
</div>
</body>
</html>