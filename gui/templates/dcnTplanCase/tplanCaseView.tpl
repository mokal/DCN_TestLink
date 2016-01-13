{include file="inc_head.tpl" jsValidate="yes" openHead="yes" enableTableSorting="yes"}
{literal}
<script language="JavaScript" type="text/javascript">
function ChangeDiv(divID,totalDiv){
   for(i=0;i<=totalDiv;i++){
       document.getElementById(i).style.display="none";
       document.getElementById('span'+i).style.color="#000000";
       document.getElementById('span'+i).style.backgroundColor="#eeeeee";
   }
   document.getElementById(divID).style.display="block";
   document.getElementById('span'+divID).style.color="#ffffff";
   document.getElementById('span'+divID).style.backgroundColor="#005599";
}
</script>

<script type="text/javascript">
function editActive(element,id)
{
  var newselect = document.createElement('select'); //创建select元素
  newselect.options.add(new Option("Y",1) );
  newselect.options.add(new Option("N",0) );

   switch(element.innerHTML){
     case 'Y' :
        newselect.options[0].selected=true;
        break;
     case 'N' :
        newselect.options[1].selected=true;
        break;
     default:
      }
  
    newselect.onblur = function(){  //失去焦点时保存，如果为空则恢复原值
        var index = this.selectedIndex;
        var value = this.value;
        element.innerHTML = this.options[index].text;
        self.dcnframe.location.href='/lib/dcnTplanCase/editActive.php?id='+id+'&active='+value;
    }
  element.innerHTML = '' ;
  element.appendChild(newselect);
  newselect.focus();
}

function swithCheckAll(tableid) { 
    var objTable = document.getElementById("tb" + tableid);
    for(var i=1;i<objTable.rows.length;i++){
       if(objTable.rows[i].cells.length == 11 ){
           if( navigator.userAgent.indexOf('Firefox') >= 0 ){
               var id = objTable.rows[i].cells[10].textContent;
           }else{
               var id = objTable.rows[i].cells[10].innerText;
           }
           var checkbox = document.getElementById(tableid + "-" + id);
           if(checkbox){
              checkbox.checked = !checkbox.checked;
           }
       }
    }
}

function CheckAll(tableid) { 
    var objTable = document.getElementById("tb" + tableid);
    for(var i=1;i<objTable.rows.length;i++){
       if(objTable.rows[i].cells.length == 11 ){
           if( navigator.userAgent.indexOf('Firefox') >= 0 ){
               var id = objTable.rows[i].cells[10].textContent;
           }else{
               var id = objTable.rows[i].cells[10].innerText;
           }
           var checkbox = document.getElementById(tableid + "-" + id);
           if(checkbox){
              checkbox.checked = 1;
           }
        }
    }
}
    
function saveCheck(tableid) {
     document.getElementById("form"+tableid).submit(); 
}

function export_cases(testplanid,deviceid,divindex,name){
   this.location.href='/lib/dcnTplanCase/exportTplanCases.php?tplanid='+testplanid+'&deviceid='+deviceid+'&divindex='+divindex+'&tplanname='+name ;
}

function get_cases_affirm2(testplanid,deviceid,divindex,name){
   this.location.href='/lib/dcnTplanCase/pullCasesFromVar.php?tplanid='+testplanid+'&deviceid='+deviceid+'&divindex='+divindex+'&tplanname='+name+'&suite=affirm2' ;
  // this.location.href='/lib/dcnTplanCase/tplanCaseView.php?divindex='+divindex;
}

function get_cases_affirm3(testplanid,deviceid,divindex,name){
   this.location.href='/lib/dcnTplanCase/pullCasesFromVar.php?tplanid='+testplanid+'&deviceid='+deviceid+'&divindex='+divindex+'&tplanname='+name+'&suite=affirm3' ;
  // this.location.href='/lib/dcnTplanCase/tplanCaseView.php?divindex='+divindex;
}

function get_cases_function(testplanid,deviceid,divindex,name){
   this.location.href='/lib/dcnTplanCase/pullCasesFromVar.php?tplanid='+testplanid+'&deviceid='+deviceid+'&divindex='+divindex+'&tplanname='+name+'&suite=function' ;
  // this.location.href='/lib/dcnTplanCase/tplanCaseView.php?divindex='+divindex;
}
</script>

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

</head>
<body>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<h1 class="title">测试计划:{$gui->tplanName|escape}--用例覆盖</h1>
{foreach from=$gui->tplanDevices key=index item=device}
    {if $gui->divindex == $index}
    <span id='span{$index}' onclick="JavaScript:ChangeDiv({$index},{$gui->totalDevices})" style="cursor:pointer;color:#ffffff;background-color:#005599; font-size:14px;border:solid 1px black">{$gui->tplanDevices[$index]['name']|escape}</span>
    {else}
    <span id='span{$index}' onclick="JavaScript:ChangeDiv({$index},{$gui->totalDevices})" style="cursor:pointer;font-size:14px;border:solid 1px black">{$gui->tplanDevices[$index]['name']|escape}</span>
    {/if}
{/foreach}

{foreach from=$gui->tplanDevices key=index item=device}

<div class="workBack" id='{$index}' {if $gui->divindex==$index}style="display:block"{else}style="display:none"{/if}>
&nbsp;1. 若测试例从添加到当前从未被执行过，点击删除图标可取消该测试例引用关系；</br>
&nbsp;2. 闪电图标表示该测试例在至少在一个版本上执行过，不允许取消引用关系，点击图标可查看该测试例在此测试计划的执行历史；</br>
&nbsp;3. 执行过的测试例可双击"激活"列，选择为N，后续该测试计划+设备执行测试将忽略该测试例；</br>
&nbsp;4. Skip列勾选，意味着仅下一次执行该测试计划+设备，该测试里将被忽略；</br>
&nbsp;<strong>5. 上传var文件功能：上传后，testlink将自动解析该var文件中的测试例，并将其增量关联到所选中的设备上，并将无执行记录的测试例取消关联；</strong></br>

<div class="groupBtn">
<form enctype="multipart/form-data" action="lib/dcnTplanCase/dcnTplanCaseAssign.php?tplan_id={$gui->tplan_id}&device_id={$gui->tplanDevices[$index]['id']}&username={$gui->username}&tplanname={$gui->tplanName}&divindex={$index}" method="post">
<input type='button' onclick="export_cases({$gui->tplan_id},{$gui->tplanDevices[$index]['id']},{$index},'{$gui->tplanName}')"  value='导出测试例文件' /> <input type="hidden" name="MAX_FILE_SIZE" value="8000000">
上传本地var文件：<input name="varfile" type="file">
<input type="submit" value="提交分析测试例">
</form>
</div>
<form action="/lib/dcnTplanCase/editSkip.php" method="post" id='form{$index}' target="dcnframe">
	<table class="simple_tableruler" id='tb{$index}'>
		<tr>
			<th align="center">NO.</th>
			<th style="width:100px;" align="center">模 块</th>
			<th onclick="sortAble(this,'tb{$index}', 2,'string')" style="cursor:pointer" align="center">测试例</th>
			<th>描 述</th>
			<th onclick="sortAble(this,'tb{$index}', 4,'string')" style="cursor:pointer" align="center">脚本文件</th>
			<th align="center">引入者</th>
			<th onclick="sortAble(this,'tb{$index}', 6,'string')" style="cursor:pointer" align="center">引入时间</th>
			<th align="center">删除</th>
			<th onclick="sortAble(this,'tb{$index}', 8,'string')" style="cursor:pointer" align="center">激活</th>
			<th onclick="sortAble(this,'tb{$index}', 9,'string')" style="cursor:pointer" align="center">Skip</th>
			<th align="center" class="{$noSortableColumnClass}">
			<input type="button" value="全选" onclick="CheckAll('{$index}');" /><br>
			<input type="button" value="反选" onclick="swithCheckAll('{$index}');" /><br>
			<input type="button" value="保存" onclick="saveCheck('{$index}');" /></th>
		</tr>
		{foreach item=suite from=$gui->tplanCases[$index] key=suiteid}
		<tr group='gp{math equation="x + y*99" x=$index y=$suiteid}'><td colspan='4' style="cursor:pointer"><a onclick="showSub(this)">&nbsp;&nbsp;+&nbsp;{$gui->suites[$suiteid]}</a></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="display:none">0</td></tr>
        {foreach item=case key=caseindex from=$gui->tplanCases[{$index}][{$suiteid}]}
		<tr parent='gp{math equation="x + y*99" x=$index y=$suiteid}'> 
			<td align="center">{$caseindex+1}</td>
			<td style="width:100px;" align="center">{$case['suite']|escape}</td>
			<td style="width:100px;" align="center">{$case['name']|escape}</td>
			<td>{$case['summary']|escape}</td>
			<td align="center">{$case['script']|escape}</td>
			<td style="width:100px;" align="center">{$case['assignby']|escape}</td>
			<td style="width:150px;" align="center">{$case['assigntime']|escape}</td>
			<td align="center">{if $case['executed']=='1'}<a href="/lib/execute/execHistoryTplanPlatform.php?tplan_id={$gui->tplan_id}&device_id={$gui->tplanDevices[$index]['id']}&tcase_id={$case['id']}" target="_black" ><img src="/gui/themes/default/images/lightning.png"></a>{/if}{if $case['executed']=='0'}<a href ="/lib/dcnTplanCase/dcnTplanCaseDelete.php?tplan_id={$gui->tplan_id}&device_id={$gui->tplanDevices[$index]['id']}&tcv_id={$case['tcvid']}" target="_black"><img src="/gui/themes/default/images/trash.png"></a>{/if}</td>
			<td align="center" ondblclick = "editActive(this,{$case['tptcid']})" >{if $case['active']==1}Y{else}N{/if}</td>
			<td align="center">{if  $case['active']==1}<input type="checkbox" id="{$index}-{$case['tptcid']}" name="{$case['tptcid']}" value=1 {if $case['skip']==1}checked="checked"{/if} />{else}-{/if}</td>
			<td align="center" style="display:none">{$case['tptcid']}</td>
		</tr>
		{/foreach}
		{/foreach}
		<input type="hidden" name="tplan_id" value={$gui->tplan_id} />
		<input type="hidden" name="device_id" value={$gui->tplanDevices[$index]['id']} />
	</table>
</form>

<div class="groupBtn">
<input type='button' onclick="get_cases_affirm2({$gui->tplan_id},{$gui->tplanDevices[$index]['id']},{$index},'{$gui->tplanName}')"  value='从确认2.0分支引用测试例' />
<input type='button' onclick="get_cases_affirm3({$gui->tplan_id},{$gui->tplanDevices[$index]['id']},{$index},'{$gui->tplanName}')"  value='从确认3.0分支引用测试例' />
<input type='button' onclick="get_cases_function({$gui->tplan_id},{$gui->tplanDevices[$index]['id']},{$index},'{$gui->tplanName}')"  value='从功能分支引用测试例' />
</div>

</div>
{/foreach}
<iframe src="" name="dcnframe" width=0 height=0 frameborder=0></iframe>
</body>
</html>