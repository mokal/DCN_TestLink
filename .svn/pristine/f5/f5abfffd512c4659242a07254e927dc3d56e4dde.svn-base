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

{assign var="viewAction" value="lib/dcnIssue/issueView.php"}

<script type="text/javascript">
<!--
	/* All this stuff is needed for logic contained in inc_del_onclick.tpl */
	var del_action=fRoot+'lib/dcnIssue/issueEdit.php?doAction=do_delete&id=';
//-->
</script>
 
</head>
<body {$body_onload}>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<h1 class="title">缺陷库管理</h1>
{include file="inc_feedback.tpl" user_feedback=$gui->user_feedback}

<div class="workBack">
<div class="groupBtn">	
   		<form style="float:left" name="issue_view" id="issue_view" method="post" action="lib/dcnIssue/issueEdit.php">
	  		<input type="hidden" name="doAction" value="" />
		    	<input type="submit" id="create_issue" name="create_issue" 	value="添加已知缺陷"
		           	 onclick="doAction.value='create'"/>
		</form>
</div>
	<table class="simple_tableruler sortable">
		<tr>
			<th>测试例</th>
			<th>步骤</th>
			<th>产品流</th>
			<th>脚本流</th>
			<th>缺陷描述</th>
			<th>删除</th>
		</tr>
		{foreach item=dcnissue from=$gui->issues}
		<tr>
			<td><a href="lib/dcnIssue/issueEdit.php?doAction=edit&amp;id={$dcnissue.id}">{$dcnissue.testcase|escape}</td>
			<td>{$dcnissue.failedsteps|escape}</td>
			<td>{$dcnissue.product|escape}</td>
			<td>{$dcnissue.script_version|escape}</td>
			<td>{nl2br($dcnissue.comment)}</td>
			<td class="clickable_icon">
				<img style="border:none;cursor: pointer;" alt="删除已知缺陷"
						title="删除"	src="/gui/themes/default/images/trash.png"
						onclick="delete_confirmation({$dcnissue.id},
							      '{$gui->issues[dcnissue].testcase|escape:'javascript'|escape}', '{$del_msgbox_title|escape:'javascript'}','这个动作无法恢复，<br/>是否确定？');" />
			</td>
		</tr>
		{/foreach}
	</table>
</div>
</body>
</html>