{include file="inc_head.tpl" jsValidate="yes" openHead="yes"}
</head>
<body>
<h1 class="title">任务详情</h1>
<div class="workBack">
<table class="common" style="width:100%">
  <tr><th style="width:180;">任务描述</th>
       <td> <strong>执行模块：</strong>{if $gui->jobdetails['job_type'] == 'affirm2'}确认测试2.0{/if}{if $gui->jobdetails['job_type'] == 'affirm3'}确认测试3.0{/if}{if $gui->jobdetails['job_type'] == 'affirm3|affirm2'}确认测试3.0+2.0连跑{/if}<br>
            <strong>执行人：</strong>{$gui->jobdetails['user']}<br><strong>当前状态：</strong>{$gui->jobdetails['status']}<br>
            <strong>测试计划：</strong>{$gui->jobdetails['tplan']}<br><strong>执行设备：</strong>{$gui->jobdetails['device']}<br><strong>版本：</strong>{$gui->jobdetails['build']}<br>
            <strong>执行PC：</strong>{$gui->jobdetails['running_vdi']}<br>
            <strong>开始执行时间：</strong>{$gui->jobdetails['job_startTime']}
       </td>
  </tr>
  <tr><th style="width:180;">执行结果/进度</th>
       <td><strong>总用例数：</strong>{$gui->jobdetails['total_case']}<br><strong>整体进度：</strong>{$gui->jobdetails['process']}<br>
           <strong>PASS用例：</strong>{$gui->jobdetails['pass_case']}<br>
           <strong>ACCEPT用例数：</strong>{$gui->jobdetails['accept_case']}<br>
           <strong>FAIL用例数: </strong>{$gui->jobdetails['fail_case']}<br>
           <strong>差异未处理数: </strong>{$gui->jobdetails['olddiff_case']}<br>
           <strong>INVALID用例数：</strong>{$gui->jobdetails['na_case']}<br>
           当前测试用例<strong>{$gui->jobdetails['running_case']}</strong>于<strong>{$gui->jobdetails['run_time']}</strong>开始执行！
  </td>
  </tr>
  <tr><th style="width:180;">执行环境</th>
{if $gui->jobdetails['job_type'] == 'affirm2'}
       <td><strong>S1 CCM：</strong>{$gui->jobdetails['s1ip']}<br>
           <strong>S1P1：</strong>Ethernet{$gui->jobdetails['s1p1']}<br><strong>S1P2：</strong>Ethernet{$gui->jobdetails['s1p2']}<br><strong>S1P3：</strong>Ethernet{$gui->jobdetails['s1p3']}<br>
           <strong>S2 CCM：</strong>{$gui->jobdetails['s2ip']}<br>
           <strong>S2P1：</strong>Ethernet{$gui->jobdetails['s2p1']}<br><strong>S2P2：</strong>Ethernet{$gui->jobdetails['s2p2']}<br><strong>S2P3：</strong>Ethernet{$gui->jobdetails['s2p3']}<br>
           <strong>IXIA IP：</strong>{$gui->jobdetails['ixia_ip']}<br>
           <strong>TP1：</strong>{$gui->jobdetails['tp1']}<br><strong>TP2：</strong>{$gui->jobdetails['tp2']}<br>
  </td>
{/if}
{if $gui->jobdetails['job_type'] == 'affirm3' || $gui->jobdetails['job_type'] =='affirm3|affirm2'}
       <td><strong>S1 CCM：</strong>{$gui->jobdetails['s1ip']}<br><strong>S4 CCM：</strong>{$gui->jobdetails['s4ip']}<br>
           <strong>S1P1：</strong>Ethernet{$gui->jobdetails['s1p1']}<br><strong>S1P2：</strong>Ethernet{$gui->jobdetails['s1p2']}<br><strong>S1P3：</strong>Ethernet{$gui->jobdetails['s1p3']}<br><strong>S1P4：</strong>Ethernet{$gui->jobdetails['s1p4']}<br><strong>S1P5：</strong>Ethernet{$gui->jobdetails['s1p5']}<br><strong>S1P6：</strong>Ethernet{$gui->jobdetails['s1p6']}<br>
           <strong>S2 CCM：</strong>{$gui->jobdetails['s2ip']}<br><strong>S5 CCM：</strong>{$gui->jobdetails['s5ip']}<br>
           <strong>S2P1：</strong>Ethernet{$gui->jobdetails['s2p1']}<br><strong>S2P2：</strong>Ethernet{$gui->jobdetails['s2p2']}<br><strong>S2P3：</strong>Ethernet{$gui->jobdetails['s2p3']}<br><strong>S2P4：</strong>Ethernet{$gui->jobdetails['s2p4']}<br><strong>S2P5：</strong>Ethernet{$gui->jobdetails['s2p5']}<br>
           <strong>S2P6：</strong>Ethernet{$gui->jobdetails['s2p6']}<br><strong>S2P7：</strong>Ethernet{$gui->jobdetails['s2p7']}<br><strong>S2P8：</strong>Ethernet{$gui->jobdetails['s2p8']}<br><strong>S2P9：</strong>Ethernet{$gui->jobdetails['s2p9']}<br><strong>S2P10：</strong>Ethernet{$gui->jobdetails['s2p10']}<br><strong>S2P11：</strong>Ethernet{$gui->jobdetails['s2p11']}<br><strong>S2P12：</strong>Ethernet{$gui->jobdetails['s2p12']}<br>
           <strong>S6工装机 CCM：</strong>{$gui->jobdetails['s6ip']}<br>
           <strong>S6P1：</strong>Ethernet{$gui->jobdetails['s6p1']}<br><strong>S6P2：</strong>Ethernet{$gui->jobdetails['s6p2']}<br>
           <strong>IXIA IP：</strong>{$gui->jobdetails['ixia_ip']}<br>
           <strong>TP1：</strong>{$gui->jobdetails['tp1']}<br><strong>TP2：</strong>{$gui->jobdetails['tp2']}<br>
           <strong>RadiusServer：</strong>{$gui->jobdetails['radius']}<br>
           <strong>Server IP：</strong>{$gui->jobdetails['server']}<br><strong>Client IP：</strong>{$gui->jobdetails['client']}<br>
  </td>
{/if}
  </tr>
</table>
</div>
</body>
</html>