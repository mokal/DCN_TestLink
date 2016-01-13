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
<literal>
<script type="text/javascript">
window.onload=function(){
	var suiteid = {$gui->current_suite};
	var varid = {$gui->current_var};
	if(suiteid != 0){
	    var varobj=document.getElementById('var_id');
    	removeAllOptions(varobj);
    	var option = document.createElement("option");
    	option.text = "Select Device Group";
    	option.value = "0";
    	varobj.add(option);
    	var vars = {$vars};
    	for(m=0;m<{$total_vars};m++){
        	if(vars[m][1]==suiteid){
     	        var option = document.createElement("option");
         	   	option.text = vars[m][2];
              	option.value = vars[m][0];
              	varobj.add(option);
              	if( vars[m][0] == varid ){
              	    varobj.options[varobj.options.length-1].selected='selected';
              	}
       		}
    	}
	}
}

function change_suite(suite){
    var mydiv=document.getElementById('upload');
    if(mydiv){ 
        mydiv.style.display="none" ;
    }
    var varobj=document.getElementById('var_id');
    removeAllOptions(varobj);
    var option = document.createElement("option");
    option.text = "Select Device Group";
    option.value = "0";
    varobj.add(option);
    var vars = {$vars};
    for(m=0;m<{$total_vars};m++){
        if(vars[m][1]==suite){
              var option = document.createElement("option");
              option.text = vars[m][2];
              option.value = vars[m][0];
              varobj.add(option);
       }
    }
}

function removeAllOptions(selectbox){
    var i;
    for(i=selectbox.options.length-1;i>=0;i--){
      selectbox.remove(i);
    }
}

function delete_case(script_name){  
   var varid = {$gui->current_var};
   var suiteid = {$gui->current_suite};
   
   this.location.href='/lib/dcnVars/viewVar.php?var_id='+varid+'&suite_id='+suiteid+'&deletecase='+script_name ;
}

function export_var(){
   var varid = {$gui->current_var};
   var suiteid = {$gui->current_suite};

   this.location.href='/lib/dcnVars/viewVar.php?var_id='+varid+'&suite_id='+suiteid+'&exportvar=1' ;
}

function add_var(){
   var varid = {$gui->current_var};
   var suiteid = {$gui->current_suite};
   var var_name = document.getElementById('new_var_name').value;
   this.location.href='/lib/dcnVars/viewVar.php?suite_id='+suiteid+'&var_id='+varid+'&add_var_name='+var_name ;
}

function add_case(){
   var varid = {$gui->current_var};
   var suiteid = {$gui->current_suite};
   var script_name = document.getElementById('need_add_case_name').value;
   this.location.href='/lib/dcnVars/viewVar.php?suite_id='+suiteid+'&var_id='+varid+'&add_case_script='+script_name ;
}

</script>
</literal>
 
</head>
<body {$body_onload}>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<h1 class="title">测试例分支管理</h1>
{include file="inc_feedback.tpl" user_feedback=$gui->user_feedback}

<div class="workBack">
1. 查看分支：选择自动化模块，然后选择分支名称，点击"查看";<br />
2. 添加分支：选择自动化模块，然后再后方输入新分支名称，点击"添加分支"即可(不提供删除分支功能);<br />
3. 导出分支用例：选择自动化模块，然后选择分支名称，先点击查看，查阅后若需导出请点击"导出";<br />
4. 维护分支中的测试例：<br />
1>删除单个:请用ctrl+F查找所需删除的用例，然后点击最后的删除图标;<br />
2>添加单个:输入待添加的<span style="color:red">测试例脚本名</span>;<br />
3>批量添加删除:本地编辑好var文件后上传，testlink上数据将以文件为准进行添加删除;
<div class="groupBtn">	
<form name='form1' action="lib/dcnVars/viewVar.php" method="get">
  自动化模块:<select name="suite_id" onChange="change_suite(this.value)">
 	<option value='0' selected='selected'>Select Module</option>
 	    {foreach from=$gui->suites item=su}
            <option value={$su['id']} {if $gui->current_suite==$su['id']} selected='selected' {/if}>{$su['name']}</option>
        {/foreach}
    </select>
    用例分支:
    <select name="var_id" id="var_id">
    <option value=0 selected='selected'>Select Module First</option>
    {if $gui->current_var != 0 }
        {foreach from=$gui->vars item=var}
        {if $var[1]=$gui->current_suite && $var[0]!=0 && $var[2]!='undefined'}
           <option value={$var[0]} {if $var[0]==$gui->current_var}selected='selected'{/if}>{$var[2]}</option>
        {/if}
        {/foreach}
    {/if}
    </select>
    <input type='submit' value='查看' />
    {if $gui->current_var != 0}
    	<input type='button' onclick="export_var()"  value='导出为var文件' /> |  
    	<span id="varupload">
    	  添加分支：<input type='text' id="new_var_name" value='' /><input type='button' onclick="add_var()" value='添加分支' />
    	</span>
    {/if}
    </form>
    <hr>

</div>

{if $gui->current_var != 0}
<div class="groupBtn" id="upload">
<form enctype="multipart/form-data" action="lib/dcnVars/dcnVarAssign.php?varid={$gui->current_var}&suiteid={$gui->current_suite}" method="post">

<input type="hidden" name="MAX_FILE_SIZE" value="8000000">
添加测试例：<input type='text' id="need_add_case_name" value='' /><input type='button' onclick="add_case()" value='添加测试例' />
上传var文件批量添加/删除<input name="varfile" type="file"><input type="submit" value="提交分析"> <此功能以所上传的文件为准进行数据覆盖，So除新建分支 请慎用！>
</form>

<form name='form1' action="lib/dcnVars/assign2AllPlan.php?varid={$gui->current_var}&suiteid={$gui->current_suite}&all=1" method="post">
<input type="submit" value="应用到所有测试计划中"> <点击后将刷新所有引用了该测试分支下任意设备的测试计划的该模块用例！>
</form>

<form name='form2' action="lib/dcnVars/assign2AllPlan.php?varid={$gui->current_var}&suiteid={$gui->current_suite}&all=0" method="post">
<input type="submit" value="应用到非售后测试计划中"> <点击后将刷新所有引用了该测试分支下任意设备的非售后测试计划的该模块用例！>
</form>
</div>

	<table class="simple_tableruler sortable">
		<tr>
			<th align="center">Test Case</th>
			<th align="center">Summary</th>
			<th align="center">Author</th>
			<th align="center">Modify Date</th>
			<th align="center">DELETE</th>
		</tr>
		{foreach item=tcversion from=$gui->var_tcversion['var']}
		<tr>
			<td align="center">{$tcversion['name']}</td>
			<td align="center">{$tcversion['summary']}</td>
			<td align="center">{$tcversion['user']}</td>
			<td align="center">{$tcversion['time']}</td>
			<td align="center"><img style="border:none;cursor: pointer;" src="{$tlImages.delete}" onclick="delete_case('{$tcversion['name']}')" /></td>
		</tr>
		{/foreach}
	</table>
{/if}
</div>

</body>
</html>