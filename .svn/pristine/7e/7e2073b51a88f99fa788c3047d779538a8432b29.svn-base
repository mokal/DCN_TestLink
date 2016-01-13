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
    self.dcnframe.location.href='/lib/dcnMonthReport/dcnReportEditExecution.php?id='+exe_id+'&note='+newnotes;
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
        self.dcnframe.location.href='/lib/dcnMonthReport/dcnReportEditExecution.php?id='+exe_id+'&fail='+value;
    }
  element.innerHTML = '' ;
  element.appendChild(newselect);
  newselect.focus();
}
}
</script>

{/literal}

</head>
<body>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<h1 class="title">{$gui->job_id}-测试报告统计</h1>
{include file="inc_feedback.tpl" user_feedback=$gui->user_feedback}

<div class="workBack">
	<table class="simple_tableruler sortable">
		<tr>
			<th align="center">TestCase</th>
			<th align="center">Result</th>
			<th align="center">Fail Type</th>
			<th align="center">Notes</th>
		</tr>
		{foreach item=case from=$gui->jobReport}
		<tr>
			<td align="center">{$case['testcase']}</td>
			<td align="center">{$case['result']}</td>
			<td align="center" ondblclick = "editFailtype(this,{$case.exe_id})" >{$case['fail_type']}</td>
			<td align="left" ondblclick = "editNotes(this,{$case.exe_id})" >{nl2br($case.notes)}</td>
		</tr>
		{/foreach}
	</table>
</div>
<iframe src="" name="dcnframe" width=0 height=0 frameborder=0></iframe>
</body>
</html>