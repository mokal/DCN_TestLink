{include file="inc_head.tpl"}

{literal}
<script type="text/javascript" src="/third_party/jquery/jquery1.3.2.js"></script>
<script type="text/javascript">
    //排序 tableId: 表的id,iCol:第几列 ；dataType：iCol对应的列显示数据的数据类型
    function sortAble(th, tableId, iCol, dataType) {
        var ascChar = "▲";
        var descChar = "▼";
        var table = document.getElementById(tableId);

       //排序标题加背景色
        for (var t = 0; t < table.tHead.rows[0].cells.length; t++) {
            var th = $(table.tHead.rows[0].cells[t]);
            var thText = th.html().replace(ascChar, "").replace(descChar, "");
            if (t == iCol) {
                th.css("background-color", "#ccc");
            }
            else {
                th.css("background-color", "#fff");
                th.html(thText);
            }
        }

        var tbody = table.tBodies[0];
        var colRows = tbody.rows;
        var aTrs = new Array;

        //将得到的行放入数组，备用
        for (var i = 0; i < colRows.length; i++) {
            //注：如果要求“分组明细不参与排序”，把下面的注释去掉即可
            //if ($(colRows[i]).attr("group") != undefined) {
            aTrs.push(colRows[i]);
            //}
        }

        //判断上一次排列的列和现在需要排列的是否同一个。
        var thCol = $(table.tHead.rows[0].cells[iCol]);
        if (table.sortCol == iCol) {
            aTrs.reverse();
        } else {
            //如果不是同一列，使用数组的sort方法，传进排序函数
            aTrs.sort(compareEle(iCol, dataType));
        }

        var oFragment = document.createDocumentFragment();
        for (var i = 0; i < aTrs.length; i++) {
            oFragment.appendChild(aTrs[i]);
        }
        tbody.appendChild(oFragment);

        //记录最后一次排序的列索引
        table.sortCol = iCol;

        //给排序标题加“升序、降序” 小图标显示
        var th = $(table.tHead.rows[0].cells[iCol]);
        if (th.html().indexOf(ascChar) == -1 && th.html().indexOf(descChar) == -1) {
            th.html(th.html() + ascChar);
        }
        else if (th.html().indexOf(ascChar) != -1) {
            th.html(th.html().replace(ascChar, descChar));
        }
        else if (th.html().indexOf(descChar) != -1) {
            th.html(th.html().replace(descChar, ascChar));
        }

        //重新整理分组
        var subRows = $("#" + tableId + " tr[parent]");
        for (var t = subRows.length - 1; t >= 0 ; t--) {
            var parent = $("#" + tableId + " tr[group='" + $(subRows[t]).attr("parent") + "']");
            parent.after($(subRows[t]));
        }
    }

    //将列的类型转化成相应的可以排列的数据类型
    function convert(sValue, dataType) {
        switch (dataType) {
            case "int":
                return parseInt(sValue, 10);
            case "float":
                return parseFloat(sValue);
            case "date":
                return new Date(Date.parse(sValue));
            case "string":
            default:
                return sValue.toString();
        }
    }

    //排序函数，iCol表示列索引，dataType表示该列的数据类型
    function compareEle(iCol, dataType) {
        return function (oTR1, oTR2) {
            var vValue1 = convert(removeHtmlTag($(oTR1.cells[iCol]).html()), dataType);
            var vValue2 = convert(removeHtmlTag($(oTR2.cells[iCol]).html()), dataType);
            if (vValue1 < vValue2) {
                return -1;
            }
            else {
                return 1;
            }
        };
    }

    //去掉html标签
    function removeHtmlTag(html) {
        return html.replace(/<[^>]+>/g, "");
    }

    //jQuery加载完以后，分组行高亮背景，分组明细隐藏
    $(document).ready(function () {
        $("tr[group]").css("background-color", "#ff9");
        $("tr[parent]").hide();
    });

    //点击分组行时，切换分组明细的显示/隐藏
    function showSub(a) {
        var groupValue = $(a).parent().parent().attr("group");
        var subDetails = $("tr[parent='" + groupValue + "']");
        subDetails.toggle();
    }
</script>

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
          self.dcnframe.location.href='/lib/results/dcnReportEditExecution.php?id='+exe_id+'&note='+newnotes;
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
      newselect.options.add(new Option("售后未合入","m") );
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
         case '售后未合入' :
            newselect.options[2].selected=true;
            break;
         case '脚本问题' :
            newselect.options[3].selected=true;
            break;
         case '产品差异' :
            newselect.options[4].selected=true;
            break;
         case '版本差异' :
            newselect.options[5].selected=true;
            break;
         case '方案问题' :
            newselect.options[6].selected=true;
            break;
         case '环境问题' :
            newselect.options[7].selected=true;
            break;
         case '无效测试' :
            newselect.options[8].selected=true;
            break;
         case '未分析' :
            newselect.options[9].selected=true;
            break;
         default:
      }
  
      newselect.onblur = function(){  //失去焦点时保存，如果为空则恢复原值
           var index = this.selectedIndex;
           var value = this.value;
           element.innerHTML = this.options[index].text;
           self.dcnframe.location.href='/lib/results/dcnReportEditExecution.php?id='+exe_id+'&fail='+value;
      }
      element.innerHTML = '' ;
      element.appendChild(newselect);
      newselect.focus();
  }
}
</script>
<script type="text/javascript">
function editAllFailtype(element,tplan,build,mystack,device,suite)
{
  if( mystack  != 0 ){
      var stack = 1;
  }else{
      var stack = 0;
  }
  var oldinner = element.innerHTML;
  var temp =  /^(<input.*?)$/;
  if(!temp.test(oldinner)){
      var newselect = document.createElement('select'); //创建select元素
      newselect.options.add(new Option("功能BUG","f") );
      newselect.options.add(new Option("已知缺陷","a") );
      newselect.options.add(new Option("售后未合入","m") );
      newselect.options.add(new Option("脚本问题","s") );
      newselect.options.add(new Option("产品差异","p") );
      newselect.options.add(new Option("版本差异","v") );
      newselect.options.add(new Option("方案问题","c") );
      newselect.options.add(new Option("环境问题","e") );
      newselect.options.add(new Option("无效测试","x") );
      newselect.options.add(new Option("未分析","none") );
 
      newselect.onblur = function(){  //失去焦点时保存，如果为空则恢复原值
          var index = this.selectedIndex;
          var value = this.value;
          element.innerHTML = this.options[index].text;
          self.dcnframe.location.href='/lib/results/dcnReportEditAllExecution.php?format=0&stack='+stack+'&mystack='+mystack+'&tplan_id='+tplan+'&build_id='+build+'&device_id='+device+'&failtype='+value+'&suite_id='+suite;
      }
      element.innerHTML = '' ;
      element.appendChild(newselect);
      newselect.focus();
  }
}
</script>

<script>
$(function() {
$('tr.myparent')
.css("cursor","pointer")
.attr("title","click to open")
.click(function(){
$(this).siblings('.child-'+this.id).toggle();
});

});
</script>

{/literal}

<body>
<h1 class="title">DCN Test Report</h1>
<div class="workBack">
{include file="inc_result_tproject_tplan.tpl" 
         arg_tproject_name=$gui->tproject_name arg_tplan_name=$gui->tplan_name arg_build_name=$gui->build_by_id['name']}	

{if $gui->do_report.status_ok}

{if $gui->build_id != 1 && $gui->needstack==0}
<strong>版本结论:</strong>
<table class="simple_tableruler" style="text-align:left; margin-left: 2px;">
<tr><th style="width:100px;">版本测试结论:</th><td>{$gui->build_result}</td></tr>
<tr><th style="width:100px;">测试总结与分析:</th><td>{nl2br($gui->build_result_summary)}</td></tr>
<tr><th style="width:100px;">版本审核人:</th><td>{$gui->build_reviewer}</td></tr>
<tr><th style="width:100px;">审核意见:</th><td>{nl2br($gui->build_review_summary)}</td></tr>
<tr><th style="width:100px;">测试时间:</th><td>{$gui->build_timePoint['start']} 至 {$gui->build_timePoint['stop']}</td></tr>
</table>
{/if}

<strong>结果统计:</strong>
	<table id ='0' class="simple_tableruler" style="text-align:left; margin-left: 2px;">
		<tr><th>Device</th>
			<th>Suite</th>
			<th>Total</th>
			<th>Executed</th>
			<th>Pass</th>
			<th>Failed</th>
			<th>Accept</th>
			<th>Block</th>
			<th>Skip</th>
			<th>Warn</th>
			<th>Invalid</th>
			<th>NOT RUN</th>
		</tr>

{foreach from=$gui->alldevice item=device key=deviceid}
	<tr class='myparent' id='{$deviceid}'>
		<td colspan='3'>&nbsp;+&nbsp;{$device}</td>
	</tr>
	{if $gui->needstack==0}
    {foreach item=suite from=$gui->results[{$deviceid}]['result'][5] key=suiteid}
	<tr class='child-{$deviceid}'>
		<td></td>
		<td>{$gui->suites[$suiteid]}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][5][{$suiteid}]['total'])}{$gui->results[{$deviceid}]['result'][5][{$suiteid}]['total']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][5][{$suiteid}]['runend'])}{$gui->results[{$deviceid}]['result'][5][{$suiteid}]['runend']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][5][{$suiteid}]['pass'])}{$gui->results[{$deviceid}]['result'][5][{$suiteid}]['pass']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][5][{$suiteid}]['fail'])}{$gui->results[{$deviceid}]['result'][5][{$suiteid}]['fail']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][5][{$suiteid}]['accept'])}{$gui->results[{$deviceid}]['result'][5][{$suiteid}]['accept']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][5][{$suiteid}]['block'])}{$gui->results[{$deviceid}]['result'][5][{$suiteid}]['block']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][5][{$suiteid}]['skip'])}{$gui->results[{$deviceid}]['result'][5][{$suiteid}]['skip']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][5][{$suiteid}]['warn'])}{$gui->results[{$deviceid}]['result'][5][{$suiteid}]['warn']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][5][{$suiteid}]['na'])}{$gui->results[{$deviceid}]['result'][5][{$suiteid}]['na']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][5][{$suiteid}]['norun'])}{$gui->results[{$deviceid}]['result'][5][{$suiteid}]['norun']}{else}0{/if}</td>
	</tr>
    {/foreach}
	{/if}
	
	{if $gui->needstack==1}
	{foreach item=temp from=$gui->stackloop key=stackid}
    {foreach item=suite from=$gui->results[{$deviceid}]['result'][$stackid] key=suiteid}
	 {* {if $gui->results[{$deviceid}]['stack'][$stackid] == 1 } *}
	<tr class='child-{$deviceid}'>
		<td></td>
		<td>{$gui->suites[$suiteid]}{if $stackid==1}一般独立{/if}{if $stackid==2}一般堆叠{/if}{if $stackid==3}独立跨板卡{/if}{if $stackid==4}堆叠跨机架{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['total'])}{$gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['total']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['runend'])}{$gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['runend']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['pass'])}{$gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['pass']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['fail'])}{$gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['fail']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['accept'])}{$gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['accept']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['block'])}{$gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['block']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['skip'])}{$gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['skip']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['warn'])}{$gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['warn']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['na'])}{$gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['na']}{else}0{/if}</td>
		<td>{if isset($gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['norun'])}{$gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['norun']}{else}0{/if}</td>
	</tr>
	{* {/if} *}
	{/foreach}
    {/foreach}
	{/if}
	
{/foreach}
</table>

<br>
<strong>详细记录:</strong>{if $gui->build_id == 0}&nbsp;&nbsp;<inpput type='button'><a href='/lib/results/dcnReportDownloadExcel.php?format=0&amp;tplan_id={$gui->tplan_id}&amp;device_id={$gui->device_id}&amp;build_id={$gui->build_id}&amp;stack={$gui->stack}' target='_black'>点击下载Excel报告(按设备/模块生成多个sheet)</a></input>{/if}
<br>
{if $gui->needstack == 0}
{foreach from=$gui->alldevice item=device key=deviceid}
{if isset($gui->results[$deviceid]['result'])}
</br>
<strong><span style="color:#7D26CD;">{$device}:</span></strong>点击黄底色的模块名可以展开，点击表头可以排序(在chrome/firefox上排序更快)
<table id='tb{$deviceid}' class="simple_tableruler" style="text-align:left; margin-left: 2px;">
    <tHead>
        <tr>
            <th >Module</th>
            <th onclick="sortAble(this,'tb{$deviceid}', 1,'string')" style="cursor:pointer">Test Case</th>
            <th onclick="sortAble(this,'tb{$deviceid}', 2, 'string')" style="cursor:pointer">Title</th>
            <th onclick="sortAble(this,'tb{$deviceid}', 3, 'string')" style="cursor:pointer">Result</th>
            <th onclick="sortAble(this,'tb{$deviceid}', 4, 'string')" style="cursor:pointer">FailType</th>
            <th>Notes</th>
	   <th>Tester</th>
            <th>Time</th>
        </tr>
    </tHead>
    <tbody>
	{foreach item=suite from=$gui->results[{$deviceid}]['result'][5] key=suiteid}
	 {if $suiteid != 0}
		<tr group='gp{$suiteid+$deviceid}'><td colspan='2' style="cursor:pointer"><a onclick="showSub(this)">&nbsp;&nbsp;+&nbsp;{$gui->suites[$suiteid]}</a></td><td></td><td></td><td ondblclick = "editAllFailtype(this,{$tplan},{$build},0,{$deviceid},{$suiteid})">双击编辑</td><td></td><td></td><td></td></tr>
        {foreach item=tc from=$gui->results[{$deviceid}]['result'][5][{$suiteid}]['cases']}
			<tr parent='gp{$suiteid+$deviceid}'><td></td>
	            <td><a href='/lib/execute/execHistory.php?tcase_id={$tc.tc_id}' target='{$tc.tc_id}_black'>{$tc.tc_name}</a></td>
		        <td>{if $gui->build_id != 1}<a href='/lib/execute/execHistoryBuildPlatform.php?tplan_id={$gui->tplan_id}&build_id={$gui->build_id}&device_id={$tc.device_id}&tcase_id={$tc.tc_id}' target='{$tc.tcv_id}_black'>{/if}{$tc.summary}{if $gui->build_id != 1}</a>{/if}</td>
	            <td>{if $tc.status != 'Pass' }<span style="color:#E53333;">{/if}{$tc.status}{if !isset($tc.status)}<span style="color:#E53333;">NoRun</span>{/if}{if $tc.status != 'Pass'}</span>{/if}</td>
				<td {if $tc.status != 'Pass' && $tc.status != 'NoRun' && $tc.status != 'N/A' && $tc.status != 'Accept' }ondblclick = "editFailtype(this,{$tc.id})" {/if} >{if $tc.status != 'Pass' && $tc.status != 'NoRun' && $tc.status != 'N/A' && $tc.status != 'Accept'}{$tc.fail_type}{/if}{if $tc.status == 'N/A'}无效测试{/if}{if $tc.status == 'Accept'}已知缺陷{/if}</td>
	            <td {if $tc.status != 'Pass' && $tc.status != 'NoRun' }ondblclick = "editNotes(this,{$tc.id})" {/if} >{nl2br($tc.notes)}</td>
				<td>{$tc.user}</td>
                <td>{$tc.time}</td>
            </tr>
        {/foreach}
	 {/if}
    {/foreach}
    </tbody>
</table>
{/if}
{/foreach}
{/if}

{if $gui->needstack == 1}
{foreach from=$gui->alldevice item=device key=deviceid}
{foreach item=temp from=$gui->stackloop key=stackid}
{if $gui->results[{$deviceid}]['stack'][$stackid] == 1}
<br>
<strong><span style="color:#7D26CD;">{$device}:{if $stackid==1}一般独立{/if}{if $stackid==2}一般堆叠{/if}{if $stackid==3}独立跨板卡{/if}{if $stackid==4}堆叠跨机架{/if}模式</span></strong>点击黄底色的模块名可以展开，点击表头可以排序(在chrome/firefox上排序更快)
<table id='tb{math equation="x + y*99" x=$deviceid y=$stackid}' class="simple_tableruler" style="text-align:left; margin-left: 2px;">
    <tHead>
        <tr>
            <th >Module</th>
            <th onclick="sortAble(this,'tb{math equation="x + y*99" x=$deviceid y=$stackid}', 1,'string')" style="cursor:pointer">Test Case</th>
            <th onclick="sortAble(this,'tb{math equation="x + y*99" x=$deviceid y=$stackid}', 2, 'string')" style="cursor:pointer">Title</th>
            <th onclick="sortAble(this,'tb{math equation="x + y*99" x=$deviceid y=$stackid}', 3, 'string')" style="cursor:pointer">Result</th>
            <th onclick="sortAble(this,'tb{math equation="x + y*99" x=$deviceid y=$stackid}', 4, 'string')" style="cursor:pointer">FailType</th>
            <th>Notes</th>
	   		<th>Tester</th>
            <th>Time</th>
        </tr>
    </tHead>
    <tbody>
	{foreach item=suite from=$gui->results[{$deviceid}]['result'][$stackid] key=suiteid}
	 {if $suiteid != 0}
		<tr group='gp{math equation="x + y*999 + z" x=$deviceid y=$stackid z=$suiteid}'><td colspan='2' style="cursor:pointer"><a onclick="showSub(this)">&nbsp;&nbsp;+&nbsp;{$gui->suites[$suiteid]}</a></td><td></td><td></td><td ondblclick = "editAllFailtype(this,{$tplan},{$build},{$stackid},{$deviceid},{$suiteid})">双击编辑</td><td></td><td></td><td></td></tr>
        {foreach item=tc from=$gui->results[{$deviceid}]['result'][$stackid][{$suiteid}]['cases']}
			<tr parent='gp{math equation="x + y*999 + z" x=$deviceid y=$stackid z=$suiteid}'><td></td> 
	            <td><a href='/lib/execute/execHistory.php?tcase_id={$tc.tc_id}' target='{$tc.tc_id}_black'>{$tc.tc_name}</a></td>
		        <td>{if $gui->build_id != 1}<a href='/lib/execute/execHistoryBuildPlatform.php?tplan_id={$gui->tplan_id}&build_id={$gui->build_id}&device_id={$tc.device_id}&tcase_id={$tc.tc_id}' target='{$tc.tcv_id}_black'>{/if}{$tc.summary}{if $gui->build_id != 1}</a>{/if}</td>
	            <td>{if $tc.status != 'Pass' }<span style="color:#E53333;">{/if}{$tc.status}{if !isset($tc.status)}<span style="color:#E53333;">NoRun</span>{/if}{if $tc.status != 'Pass'}</span>{/if}</td>
				<td {if $tc.status != 'Pass' && $tc.status != 'NoRun' && $tc.status != 'N/A' && $tc.status != 'Accept' }ondblclick = "editFailtype(this,{$tc.id})" {/if} >{if $tc.status != 'Pass' && $tc.status != 'NoRun' && $tc.status != 'N/A' && $tc.status != 'Accept'}{$tc.fail_type}{/if}{if $tc.status == 'N/A'}无效测试{/if}{if $tc.status == 'Accept'}已知缺陷{/if}</td>
	            <td {if $tc.status != 'Pass' && $tc.status != 'NoRun' }ondblclick = "editNotes(this,{$tc.id})" {/if} >{nl2br($tc.notes)}</td>
				<td>{$tc.user}</td>
                <td>{$tc.time}</td>
            </tr>
        {/foreach}
	 {/if}
    {/foreach}
    </tbody>
</table>
{/if}
{/foreach}
{/foreach}
{/if}

<iframe src="" name="dcnframe" width=0 height=0 frameborder=0></iframe>
</body>

{else}
  	{$gui->do_report.msg}
{/if}  
</div>

</body>
</html>