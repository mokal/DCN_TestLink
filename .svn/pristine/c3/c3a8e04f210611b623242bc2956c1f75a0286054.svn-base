{include file="inc_head.tpl" jsValidate="yes" openHead="yes"}
{literal}
<script type="text/javascript">
function editNotes(element,exe_id)
{
  var oldnote = element.innerHTML;
 var temp =  /^(<textarea rows.*?)$/;
 if(!temp.test(oldnote)){
  var newnote = document.createElement('textarea'); //创建文本域元素
  var reg = new RegExp("<br>" , "g");
  newnote.value = oldnote.replace(reg, "\r");

  newnote.rows = 6;
  newnote.cols = 70;
  newnote.onblur = function(){  //文本域失去焦点时保存，如果为空则恢复原值  
    element.innerHTML = this.value ? this.value : oldnote ;
    var newnotes = encodeURIComponent(element.innerHTML);
    self.dcnframe.location.href='/lib/dcnBuildCompare/dcnReportEditExecution.php?id='+exe_id+'&note='+newnotes;
  }

  element.innerHTML = '' ;

  element.appendChild(newnote);
  newnote.focus();
}
}
</script>

<script type="text/javascript">
function editFailtype(element,exe_id)
{
var oldinner = element.innerHTML;
var temp =  /^(<input.*?)$/;
if(!temp.test(oldinner)){
  var newselect = document.createElement('select'); //创建select元素
  newselect.options.add(new Option("功能BUG","f") );
  newselect.options.add(new Option("已知缺陷","a") );
  newselect.options.add(new Option("脚本问题","s") );
  newselect.options.add(new Option("产品差异","p") );
  newselect.options.add(new Option("版本差异","v") );
  newselect.options.add(new Option("方案问题","c") );
  newselect.options.add(new Option("环境问题","e") );
  newselect.options.add(new Option("无效测试","x") );
  newselect.options.add(new Option("未分析","none") );

   switch(element.innerHTML){
     case '功能BUG' :
        newselect.options[0].selected=true;
        break;
     case '已知缺陷' :
        newselect.options[1].selected=true;
        break;
     case '脚本问题' :
        newselect.options[2].selected=true;
        break;
     case '产品差异' :
        newselect.options[3].selected=true;
        break;
     case '版本差异' :
        newselect.options[4].selected=true;
        break;
     case '方案问题' :
        newselect.options[5].selected=true;
        break;
     case '环境问题' :
        newselect.options[6].selected=true;
        break;
     case '无效测试' :
        newselect.options[7].selected=true;
        break;
     case '未分析' :
        newselect.options[8].selected=true;
        break;
     default:
      }
  
    newselect.onblur = function(){  //失去焦点时保存，如果为空则恢复原值
        var index = this.selectedIndex;
        var value = this.value;
        element.innerHTML = this.options[index].text;
        self.dcnframe.location.href='/lib/dcnBuildCompare/dcnReportEditExecution.php?id='+exe_id+'&fail='+value;
    }
  element.innerHTML = '' ;
  element.appendChild(newselect);
  newselect.focus();
}
}
</script>

{/literal}

<body>
<h1 class="title">DCN Test Report</h1>
<div class="workBack">
{if $gui->do_report.status_ok}
<div  align="center" ><img src="{$basehref}/lib/dcnBuildCompare/draw_multi_tplan.php?{$gui->draw_string}"></div>
<br>
<strong>详细测试例列表:</strong>
<br>
<table class="simple_tableruler" style="text-align:left; margin-left: 2px;">
    <tHead>
    <tr><th rowspan='2' align="center" valign="middle" width=20>TestCase</th>
        <th rowspan='2' align="center" valign="middle" width=60>Summary</th>
        <th colspan="3" style="text-align:center;">{$gui->build_name[1]}-拓扑{$gui->stack1}</th>
        <th colspan="3" style="text-align:center;">{$gui->build_name[2]}-拓扑{$gui->stack2}</th>
        <th rowspan='2' align="center" valign="middle">Action</th>
    </tr>
    <tr>
    	<th style="text-align:center;" width=10>Result</th>
    	<th style="text-align:center;" width=10>FailType</th>
    	<th style="text-align:center;" width=20>Notes</th>
    	
    	<th style="text-align:center;" width=10>Result</th>
    	<th style="text-align:center;" width=10>FailType</th>
    	<th style="text-align:center;" width=20>Notes</th>
    </tr>
    </tHead>
    <tbody>
        {foreach item=tcvid from=$gui->all_nopass key=index}
		<tr>		
            <td>{$gui->tplan_tc[$tcvid]['name']}</td>
			<td>{$gui->tplan_tc[$tcvid]['summary']}</td>
	            {foreach item=buildid from=$gui->build key=index}		
                <td style="text-align:center;">{if $gui->buildallcase[$index][$tcvid]['status']=='p'}Pass
				    {elseif $gui->buildallcase[$index][$tcvid]['status']=='x'}<span style="color:red">NA</span>
					{elseif $gui->buildallcase[$index][$tcvid]['status']=='c'}<span style="color:green">Accept</span>
					{elseif $gui->buildallcase[$index][$tcvid]['status']=='f'}<span style="color:red">Fail</span>
					{else}NoRun{/if}
				</td>
				<td style="text-align:center;" {if $index==1 && $gui->buildallcase[$index][$tcvid]['status'] != 'p' && $gui->buildallcase[$index][$tcvid]['status'] != 'NoRun' && $gui->buildallcase[$index][$tcvid]['status'] != 'x' && $gui->buildallcase[$index][$tcvid]['status'] != 'c' }ondblclick = "editFailtype(this,{$gui->buildallcase[$index][$tcvid]['id']})" {/if}>
				    {if $gui->buildallcase[$index][$tcvid]['fail_type']=='p'}产品差异
				    {elseif $gui->buildallcase[$index][$tcvid]['fail_type']=='x'}无效测试
					{elseif $gui->buildallcase[$index][$tcvid]['fail_type']=='v'}版本差异
					{elseif $gui->buildallcase[$index][$tcvid]['fail_type']=='s'}脚本问题
					{elseif $gui->buildallcase[$index][$tcvid]['fail_type']=='e'}环境问题
					{elseif $gui->buildallcase[$index][$tcvid]['fail_type']=='c'}方案问题
					{elseif $gui->buildallcase[$index][$tcvid]['fail_type']=='f'}功能BUG
					{elseif $gui->buildallcase[$index][$tcvid]['fail_type']=='a'}已知缺陷
					{elseif $gui->buildallcase[$index][$tcvid]['fail_type']=='none'}未分析
					{else}--{/if}
				</td>
				<td {if  $index==1 && $gui->buildallcase[$index][$tcvid]['status'] != 'p'}ondblclick = "editNotes(this,{$gui->buildallcase[$index][$tcvid]['id']})" {/if}> {$gui->buildallcase[$index][$tcvid]['notes']}</td>
	        {/foreach}
	        <td>{if ($gui->buildallcase[0][$tcvid]['status']=='f' || $gui->buildallcase[0][$tcvid]['status']=='x' || $gui->buildallcase[0][$tcvid]['status']=='c') && ($gui->buildallcase[1][$tcvid]['status']=='f' || $gui->buildallcase[1][$tcvid]['status']=='x' || $gui->buildallcase[1][$tcvid]['status']=='c')}<a href="lib/dcnBuildCompare/copyBuildFailType.php?oldexec={$gui->buildallcase[0][$tcvid]['id']}&newexec={$gui->buildallcase[1][$tcvid]['id']}" target="dcnframe"><input type="button" value="复制分析" onclick="this.disabled=true" /></a>{/if}</td>
		</tr>
	    {/foreach}
    </tbody>
</table></br>
<iframe src="" name="dcnframe" width=0 height=0 frameborder=0></iframe>
</body>

{else}
  	{$gui->do_report.msg}
{/if}  
</div>

</body>
</html>