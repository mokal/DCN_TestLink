{include file="inc_head.tpl" jsValidate="yes" openHead="yes" enableTableSorting="yes"}

<script src="/third_party/jquery/jquery-1.11.1.min.js"></script>
<script>
{literal}
$(document).ready(function(){
   $("#affirm2").click(function(){
     $("#affirm2ModuleSelect").show();
     $("#affirm3ModuleSelect").hide();
     $("#collegeModuleSelect").hide();
     $("#overseaModuleSelect").hide();
     $("#financialModuleSelect").hide();
     $("#functionModuleSelect").hide();
     $("#submit").show();
     $(":checkbox").attr("checked",false);
	});

   $("#affirm3").click(function(){
     $("#affirm2ModuleSelect").hide();
     $("#affirm3ModuleSelect").show();
     $("#collegeModuleSelect").hide();
     $("#overseaModuleSelect").hide();
     $("#financialModuleSelect").hide();
     $("#functionModuleSelect").hide();
     $("#submit").show();
     $(":checkbox").attr("checked",false);
	});

   $("#college").click(function(){
     $("#affirm2ModuleSelect").hide();
     $("#affirm3ModuleSelect").hide();
     $("#collegeModuleSelect").show();
     $("#overseaModuleSelect").hide();
     $("#financialModuleSelect").hide();
     $("#functionModuleSelect").hide();
     $("#submit").show();
     $(":checkbox").attr("checked",false);
	});

   $("#oversea").click(function(){
     $("#affirm2ModuleSelect").hide();
     $("#affirm3ModuleSelect").hide();
     $("#collegeModuleSelect").hide();
     $("#overseaModuleSelect").show();
     $("#financialModuleSelect").hide();
     $("#functionModuleSelect").hide();
     $("#submit").show();
     $(":checkbox").attr("checked",false);
	});

   $("#financial").click(function(){
     $("#affirm2ModuleSelect").hide();
     $("#affirm3ModuleSelect").hide();
     $("#collegeModuleSelect").hide();
     $("#overseaModuleSelect").hide();
     $("#financialModuleSelect").show();
     $("#functionModuleSelect").hide();
     $("#submit").show();
     $(":checkbox").attr("checked",false);
	});

   $("#function").click(function(){
     $("#affirm2ModuleSelect").hide();
     $("#affirm3ModuleSelect").hide();
     $("#collegeModuleSelect").hide();
     $("#overseaModuleSelect").hide();
     $("#financialModuleSelect").hide();
     $("#functionModuleSelect").show();
     $("#submit").show();
	});

});
</script>

<script type="text/javascript">
function checkTopo(){
  var topotype = document.getElementsByName("topotype");
  return ture;
}

</script>

{/literal}
</head>
<body {$body_onload}>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}

<h1 class="title">云执行 环境设置</h1>
<div class="workBack">

{if $gui->productline_id == 1} {* 有线交换机测试 *}
<form enctype="multipart/form-data" action="lib/execute/jobsCloudRun.php" method="post" onsubmit="javascript:return checkTopo();">
<div id="topoSelect" name="topoSelect" align="center" >
		<input name="topotype" id="function" type="radio" value="function" ><font size="4"><strong>功能固定拓扑</strong></font></input>
		<input name="topotype" id="affirm2" type="radio" value="affirm2" ><font size="4"><strong>确认2.0拓扑</strong></font></input>
		<input name="topotype" id="affirm3" type="radio" value="affirm3" ><font size="4"><strong>确认3.0拓扑</strong></font></input>
		<input name="topotype" id="college" type="radio" value="college" ><font size="4"><strong>校园网拓扑</strong></font></input>
		<input name="topotype" id="oversea" type="radio" value="oversea" ><font size="4"><strong>海外拓扑</strong></font></input>
		<input name="topotype" id="financial" type="radio" value="financial" ><font size="4"><strong>金融拓扑</strong></font></input>
</div>
<hr>
<div id="affirm2ModuleSelect" name="affirm2ModuleSelect" align="center" style="display:none">
	<input name="affirm2" id="affirm2" type="checkbox" value="1" >确认测试2.0</input>
	<input name="xxxx2" id="xxxx2" type="checkbox" value="1" >可用确认2.0拓扑的功能模块(待扩展)</input>
</div>

<div id="affirm3ModuleSelect" name="affirm3ModuleSelect" align="center" style="display:none">
	<input name="affirm3" id="affirm3" type="checkbox" value="1" >确认测试3.0</input>
	<input name="xxxx3" id="xxxx" type="checkbox" value="1" >可用确认3.0拓扑的功能模块(待扩展)</input>
</div>

<div id="collegeModuleSelect" name="collegeModuleSelect" align="center" style="display:none">
	<input name="college" id="college" type="checkbox" checked="checked" value="1" >校园网典型应用环境测试</input>
</div>

<div id="overseaModuleSelect" name="overseaModuleSelect" align="center" style="display:none">
	<input name="oversea" id="oversea" type="checkbox" checked="checked" value="1" >海外运营商典型应用环境测试</input>
</div>

<div id="financialModuleSelect" name="financialModuleSelect" align="center" style="display:none">
	<input name="financial" id="financial" type="checkbox" checked="checked" value="1" >金融典型应用环境测试</input>
</div>

<div id="functionModuleSelect" name="functionModuleSelect" align="center" style="display:none">
 <table border="1"><tbody>
  <tr>
	<td><input name="Aggregation" type="checkbox" value="1" disabled />Aggregation</td>
	<td><input name="Am" type="checkbox" value="1" disabled />Am</td>
	<td><input name="Arp" type="checkbox" value="1" disabled />Arp</td>
	<td><input name="ArpGuard" type="checkbox" value="1" disabled />ArpGuard</td>
	<td><input name="DCSCM" type="checkbox" value="1" disabled />DCSCM</td>
	<td><input name="DhcpSnooping" type="checkbox" value="1" disabled />DhcpSnooping</td>
  </tr>
  <tr>
	<td><input name="DynamicVlan" type="checkbox" value="1" disabled />DynamicVlan</td>
	<td><input name="FBR" type="checkbox" value="1" disabled />FBR</td>
	<td><input name="GratuitousArp" type="checkbox" value="1" disabled />GratuitousArp</td>
	<td><input name="Icmpv6" type="checkbox" value="1" disabled />Icmpv6</td>
	<td><input name="IgmpSnooping" type="checkbox" value="1" disabled />IgmpSnooping</td>
    <td><input name="IPv4ACL" type="checkbox" value="1" disabled />IPv4ACL</td>
  </tr>
  <tr>
	<td><input name="IPv4Icmp" type="checkbox" value="1" disabled />IPv4Icmp</td>
	<td><input name="Ipv4Ipv6Host" type="checkbox" value="1" checked="checked" />Ipv4Ipv6Host</td>
	<td><input name="IPv4StaticRoute" type="checkbox" value="1" disabled />IPv4StaticRoute</td>
	<td><input name="IPv4v6BlackHoleRoute" type="checkbox" value="1" disabled />IPv4v6BlackHoleRoute</td>
	<td><input name="IPv6ACL" type="checkbox" value="1" disabled />IPv6ACL</td>
    <td><input name="IPv6Address" type="checkbox" value="1" disabled />IPv6Address</td>
   </tr>
   <tr>
	<td><input name="IPv6ND" type="checkbox" value="1" disabled />IPv6ND</td>
	<td><input name="Ipv6StaticRouting" type="checkbox" value="1" disabled />Ipv6StaticRouting</td>
	<td><input name="IPv6VRRP" type="checkbox" value="1" disabled />IPv6VRRP</td>
	<td><input name="IsolatePort" type="checkbox" value="1" disabled />IsolatePort</td>
	<td><input name="KeepAliveGateway" type="checkbox" value="1" disabled />KeepAliveGateway</td>
    <td><input name="L2" type="checkbox" value="1" disabled />L2</td>
   </tr>
   <tr>
	<td><input name="lldp" type="checkbox" value="1" checked="checked" />lldp</td>
	<td><input name="LocalProxyARP" type="checkbox" value="1" disabled />LocalProxyARP</td>
	<td><input name="LoopbackDetection" type="checkbox" value="1" disabled />LoopbackDetection</td>
	<td><input name="Mirror" type="checkbox" value="1" disabled />Mirror</td>
	<td><input name="MRPP" type="checkbox" value="1" disabled />MRPP</td>
	<td><input name="MSTP" type="checkbox" value="1" disabled />MSTP</td>
	</tr>
	<tr>
	<td><input name="PortChannel" type="checkbox" value="1" disabled />PortChannel</td>
	<td><input name="PortStatistic" type="checkbox" value="1" disabled />PortStatistic</td>
	<td><input name="PortVlanIpLimit" type="checkbox" value="1" disabled />PortVlanIpLimit</td>
	<td><input name="PreventARPSboofing" type="checkbox" value="1" disabled />PreventARPSboofing</td>
	<td><input name="PreventNDSboofing" type="checkbox" value="1" disabled />PreventNDSboofing</td>
    <td><input name="RateViolation" type="checkbox" value="1" disabled />RateViolation</td>
   </tr>
   <tr>
	<td><input name="RSPAN" type="checkbox" value="1" disabled />RSPAN</td>
	<td><input name="SecurityRA" type="checkbox" value="1" disabled />SecurityRA</td>
	<td><input name="ULPP" type="checkbox" value="1" disabled />ULPP</td>
	<td><input name="VLAN" type="checkbox" value="1" disabled />VLAN</td>
	<td><input name="VlanACL" type="checkbox" value="1" disabled />VlanACL</td>
	<td><input name="VRRP" type="checkbox" value="1" checked="checked" />VRRP</td>
	</tr>
</tbody></table>
</div>

<div id="submit" name="submit" align="center"  style="display:none" >
	上传IMG文件<input type='file' name='img_file' /><input type="submit" value="猛击开始云端托管测试" /><hr>
</div>

</div>
</form>
{/if}

{if $gui->productline_id == 2} {* 无线产品线测试 *}
<form action="/lib/execute/jobsWaffirmRun.php" method="post" onsubmit="javascript:return checkInput_wireless();">
<div id="affirmWirelessEnvSelect" name="affirmWirelessEnvSelect" align="center">无线暂不支持</div>
</form>
</div>
{/if}

</body>
</html>