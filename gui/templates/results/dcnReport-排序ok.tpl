{include file="inc_head.tpl"}

{literal}
<script type="text/javascript" src="http://192.168.50.193/third_party/jquery/jquery1.3.2.js"></script>
<script type="text/javascript" src="http://10.1.145.70/third_party/jquery/jquery1.3.2.js"></script>
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
function editNotes(element)
{
  var oldhtml = element.innerHTML;
  var newobj = document.createElement('textarea'); //创建文本域元素
  newobj.value = oldhtml;
  newobj.rows = 3;
  newobj.clos = 50;
  newobj.onblur = function(){  //文本域失去焦点时保存，如果为空则恢复原值
      element.innerHTML = this.value ? this.value : oldhtml ;
  }
  element.innerHTML = '' ;
  element.appendChild(newobj);
  newobj.focus();
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

<strong>结果统计:</strong>
	<table id ='0' class="simple_tableruler" style="text-align:left; margin-left: 2px;">
		<tr><th>Device</th>
			<th>Suite</th>
			<th>Total</th>
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
	<tr class='child-{$deviceid}'>
		<td></td>
		<td>所有模块</td>
		<td>{$gui->results[{$deviceid}][0]['total']}</td>
		<td>{$gui->results[{$deviceid}][0]['pass']}</td>
		<td>{$gui->results[{$deviceid}][0]['fail']}</td>
		<td>{$gui->results[{$deviceid}][0]['accept']}</td>
		<td>{$gui->results[{$deviceid}][0]['block']}</td>
		<td>{$gui->results[{$deviceid}][0]['skip']}</td>
		<td>{$gui->results[{$deviceid}][0]['warn']}</td>
		<td>{$gui->results[{$deviceid}][0]['na']}</td>
		<td>{$gui->results[{$deviceid}][0]['norun']}</td>
	</tr>
    {foreach item=suite from=$gui->results[{$deviceid}] key=suiteid}
	{if $suiteid != 0}
		<tr class='child-{$deviceid}'>
			<td></td>
			<td>{$gui->suites[$suiteid]}</td>
			<td>{$gui->results[{$deviceid}][{$suiteid}]['total']}</td>
			<td>{$gui->results[{$deviceid}][{$suiteid}]['pass']}</td>
			<td>{$gui->results[{$deviceid}][{$suiteid}]['fail']}</td>
			<td>{$gui->results[{$deviceid}][{$suiteid}]['accept']}</td>
			<td>{$gui->results[{$deviceid}][{$suiteid}]['block']}</td>
			<td>{$gui->results[{$deviceid}][{$suiteid}]['skip']}</td>
			<td>{$gui->results[{$deviceid}][{$suiteid}]['warn']}</td>
			<td>{$gui->results[{$deviceid}][{$suiteid}]['na']}</td>
			<td>{$gui->results[{$deviceid}][{$suiteid}]['norun']}</td>
		</tr>
	{/if}
    {/foreach}
{/foreach}
</table>


<br>
<strong>详细记录:</strong>&nbsp;&nbsp;<inpput type='button'><a href='/lib/results/dcnReportDownloadExcelNew.php?format=0&amp;tplan_id={$gui->tplan_id}&amp;device_id={$gui->device_id}&amp;build_id={$gui->build_id}' target='_black'>点击下载Excel报告(按设备/模块生成多个sheet)</a></input>
<br>

{foreach from=$gui->alldevice item=device key=deviceid}
<strong>{$device}:</strong>点击黄底色的模块名可以展开，点击表头可以排序(在chrome/firefox上排序更快)
<table id='tb{$deviceid}' class="simple_tableruler" style="text-align:left; margin-left: 2px;">
    <tHead>
        <tr>
            <th >Module</th>
            <th onclick="sortAble(this,'tb{$deviceid}', 1,'string')" style="cursor:pointer">Test Case</th>
            <th onclick="sortAble(this,'tb{$deviceid}', 2, 'string')" style="cursor:pointer">Title</th>
            <th onclick="sortAble(this,'tb{$deviceid}', 3, 'string')" style="cursor:pointer">Result</th>
            <th onclick="sortAble(this,'tb{$deviceid}', 4, 'date')" style="cursor:pointer">Time</th>
	   <th onclick="sortAble(this,'tb{$deviceid}', 5, 'string')" style="cursor:pointer">Tester</th>
            <th onclick="sortAble(this,'tb{$deviceid}', 6, 'string')" style="cursor:pointer">FailType</th>
            <th>Notes</th>
        </tr>
    </tHead>
    <tbody>
	{foreach item=suite from=$gui->results[{$deviceid}] key=suiteid}
	 {if $suiteid != 0}
		<tr group='gp{$suiteid+$deviceid}'><td colspan='2' style="cursor:pointer"><a onclick="showSub(this)">&nbsp;&nbsp;+&nbsp;{$gui->suites[$suiteid]}</a></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        {foreach item=tc from=$gui->results[{$deviceid}][{$suiteid}]['cases']}
			<tr parent='gp{$suiteid+$deviceid}'><td></td>
	            <td><a href='/lib/execute/execHistory.php?tcase_id={$tc.tc_id}' target='{$tc.tc_id}_black'>{$tc.tc_name}</a></td>
		        <td>{if $gui->build_id != 1}<a href='/lib/execute/execHistoryBuildPlatform.php?tplan_id={$gui->tplan_id}&build_id={$gui->build_id}&device_id={$tc.device_id}&tcase_id={$tc.tc_id}' target='{$tc.tcv_id}_black'>{/if}{$tc.summary}{if $gui->build_id != 1}</a>{/if}</td>
	            <td>{if $tc.status != 'Pass' }<span style="color:#E53333;">{/if}{$tc.status}{if $tc.status != 'Pass'}</span>{/if}</td>
		        <td>{$tc.time}</td>
		        <td>{$tc.user}</td>
		        <td>{$tc.tc_name}</td>
	            <td ondblclick = "editNotes(this)">{$tc.notes}</td>
            </tr>
        {/foreach}
	 {/if}
    {/foreach}
    </tbody>
</table></br>
{/foreach}
</body>

{else}
  	{$gui->do_report.msg}
{/if}  
</div>

</body>
</html>