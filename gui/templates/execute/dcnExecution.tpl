{include file="inc_head.tpl" jsValidate="yes" openHead="yes" enableTableSorting="yes"}

<script src="/third_party/jquery/jquery-1.11.1.min.js"></script>
<script>
var affirm3env = {$allaffirm3env};
var allwaffirmenv = {$allwaffirmenv};
var jobhistory = {$jobhistory};
var par_detail = {$par_detail};
var function_env_detail = {$function_env_detail};
var poncat_var = {$poncat_var};
var poncat_function_env_detail = {$poncat_function_env_detail};
{literal}
$(document).ready(function(){
   $("#affirm2").click(function(){
     $("#affirm2Env").show();
     $("#submit").show();
	 $("#affirm3EnvSelect").hide();
	 $("#affirm3Env").hide();
	 $("#functionEnvSelect").hide();
	 $("#functionEnv").hide();
	 $("#functionEnv_adv").hide();
	 $("#functionSelect").hide();
 	 $("#collegeEnv").hide();
     $("#financialEnv").hide();
     $("#overseaEnv").hide();
 	 $("#dianxingEnvSelect").hide();  
	 $("#performanceAdv").hide();
	 $("#performanceEnv").hide();
	 $("#performanceSelect").hide();
	 $("#cmdautoEnv").hide();
	 $("#memorytestEnv").hide();
 
     if( jobhistory['affirm2'] ){
          alert("此测试设备模块上找到历史执行记录!环境参数已填写最近一次历史环境，请酌情修正！");
           $("#affirm2s1ip")[0].value = jobhistory['affirm2'].s1ip;
           $("#affirm2s2ip")[0].value = jobhistory['affirm2'].s2ip;
           $("#affirm2s1sn")[0].value = jobhistory['affirm2'].s1sn;
           $("#affirm2s2sn")[0].value = jobhistory['affirm2'].s2sn;

           $("#affirm2s2device")[0].value = jobhistory['affirm2'].s2device;
           $("#affirm2s1p1")[0].value = jobhistory['affirm2'].s1p1;
           $("#affirm2s1p2")[0].value = jobhistory['affirm2'].s1p2;
           $("#affirm2s1p3")[0].value = jobhistory['affirm2'].s1p3;
           $("#affirm2s2p1")[0].value = jobhistory['affirm2'].s2p1;
           $("#affirm2s2p2")[0].value = jobhistory['affirm2'].s2p2;
           $("#affirm2s2p3")[0].value = jobhistory['affirm2'].s2p3;
           $("#affirm2ixiaip")[0].value = jobhistory['affirm2'].ixia_ip;
           $("#affirm2tp1")[0].value = jobhistory['affirm2'].tp1;
           $("#affirm2tp2")[0].value = jobhistory['affirm2'].tp2;
           $("#productversion ").val(jobhistory['affirm2'].productVersion);
           $("#scriptversion ").val(jobhistory['affirm2'].scriptVersion);
      }
   });

   $("#affirm3").click(function(){
       $("#affirm2Env").hide();
       $("#submit").hide();
       if( jobhistory['affirm3'] ){
             $("#submit").show();
             alert("此测试设备模块上找到历史执行记录!环境参数已填写最近一次历史环境，请酌情修正！");
             $("#affirm3s1ip")[0].value = jobhistory['affirm3'].s1ip;
             $("#affirm3s4ip")[0].value = jobhistory['affirm3'].s4ip;
             $("#affirm3s1p1")[0].value = jobhistory['affirm3'].s1p1;
             $("#affirm3s1p2")[0].value = jobhistory['affirm3'].s1p2;
             $("#affirm3s1p3")[0].value = jobhistory['affirm3'].s1p3;
             $("#affirm3s1p4")[0].value = jobhistory['affirm3'].s1p4;
             $("#affirm3s1p5")[0].value = jobhistory['affirm3'].s1p5;
             $("#affirm3s1p6")[0].value = jobhistory['affirm3'].s1p6;
			 $("#affirm3s1p7")[0].value = jobhistory['affirm3'].s1p7;

             $("#affirm3s2device")[0].value = jobhistory['affirm3'].s2device;
             $("#affirm3s2ip")[0].value = jobhistory['affirm3'].s2ip;
             $("#affirm3s5ip")[0].value = jobhistory['affirm3'].s5ip;
             $("#affirm3s2p1")[0].value = jobhistory['affirm3'].s2p1;
             $("#affirm3s2p2")[0].value = jobhistory['affirm3'].s2p2;
             $("#affirm3s2p3")[0].value = jobhistory['affirm3'].s2p3;
             $("#affirm3s2p4")[0].value = jobhistory['affirm3'].s2p4;
             $("#affirm3s2p5")[0].value = jobhistory['affirm3'].s2p5;
             $("#affirm3s2p6")[0].value = jobhistory['affirm3'].s2p6;
             $("#affirm3s2p7")[0].value = jobhistory['affirm3'].s2p7;
             $("#affirm3s2p8")[0].value = jobhistory['affirm3'].s2p8;
             $("#affirm3s2p9")[0].value = jobhistory['affirm3'].s2p9;
             $("#affirm3s2p10")[0].value = jobhistory['affirm3'].s2p10;
             $("#affirm3s2p11")[0].value = jobhistory['affirm3'].s2p11;
             $("#affirm3s2p12")[0].value = jobhistory['affirm3'].s2p12;

             $("#affirm3s6ip")[0].value = jobhistory['affirm3'].s6ip;
             $("#affirm3s6p1")[0].value = jobhistory['affirm3'].s6p1;
             $("#affirm3s6p2")[0].value = jobhistory['affirm3'].s6p2;

             $("#affirm3ixiaip")[0].value = jobhistory['affirm3'].ixia_ip;
             $("#affirm3tp1")[0].value = jobhistory['affirm3'].tp1;
             $("#affirm3tp2")[0].value = jobhistory['affirm3'].tp2;

             $("#affirm3server")[0].value = jobhistory['affirm3'].server;
             $("#affirm3client")[0].value = jobhistory['affirm3'].client;
             $("#affirm3admin_ip")[0].value = jobhistory['affirm3'].admin_ip;
             $("#affirm3radius")[0].value = jobhistory['affirm3'].radius; 
	         $("#affirm3Env").show();
             $("#submit").show();
           }
	   $("#affirm3EnvSelect").show();
	   $("#functionEnvSelect").hide();
	   $("#functionEnv").hide();
	   $("#functionEnv_adv").hide();
	   $("#functionSelect").hide();
   	   $("#collegeEnv").hide();
       $("#financialEnv").hide();
       $("#overseaEnv").hide();
   	   $("#dianxingEnvSelect").hide();
   	   $("#performanceEnv").hide(); 
   	   $("#performanceAdv").hide();
   	   $("#performanceSelect").hide();
   	   $("#cmdautoEnv").hide();
   	   $("#memorytestEnv").hide();
   });

   $("#function").click(function(){
       $("#affirm2Env").hide();
	   $("#affirm3EnvSelect").hide();
	   $("#affirm3Env").hide();
	   $("#functionEnvSelect").show();
	   $("#functionEnv").hide();
	   $("#functionEnv_adv").hide();
	   $("#functionSelect").show();
       $("#submit").hide();
 	   $("#collegeEnv").hide();
       $("#financialEnv").hide();
       $("#overseaEnv").hide();
 	   $("#dianxingEnvSelect").hide();
 	   $("#performanceEnv").hide(); 
   	   $("#performanceAdv").hide();
   	   $("#performanceSelect").hide();
   	   $("#cmdautoEnv").hide();
   	   $("#memorytestEnv").hide();
   });

   $("#dianxing").click(function(){
       $("#affirm2Env").hide();
	   $("#affirm3EnvSelect").hide();
	   $("#affirm3Env").hide();
	   $("#functionEnvSelect").hide();
	   $("#functionEnv").hide();
	   $("#functionEnv_adv").hide();
	   $("#functionSelect").hide();
       $("#submit").hide();
       $("#collegeEnv").hide();
       $("#financialEnv").hide();
       $("#overseaEnv").hide();
 	   $("#dianxingEnvSelect").show();
 	   $("#performanceEnv").hide(); 
   	   $("#performanceAdv").hide();
   	   $("#performanceSelect").hide();
   	   $("#cmdautoEnv").hide();
   	   $("#memorytestEnv").hide();
   });

   $("#softperformance").click(function(){
       $("#affirm2Env").hide();
	   $("#affirm3EnvSelect").hide();
	   $("#affirm3Env").hide();
	   $("#functionEnvSelect").hide();
	   $("#functionEnv").hide();
	   $("#functionEnv_adv").hide();
	   $("#functionSelect").hide();
       $("#submit").hide();
       $("#collegeEnv").hide();
       $("#financialEnv").hide();
       $("#overseaEnv").hide();
 	   $("#dianxingEnvSelect").hide();
 	   $("#performanceEnv").show(); 
 	   $("#submit").hide();
 	   $("#performanceSelect").show();
 	   $("#performanceEnv").hide();
   	   $("#performanceAdv").hide();
   	   $("#cmdautoEnv").hide();
   	   $("#memorytestEnv").hide();
   });
   
   $("#cmdauto").click(function(){
     $("#affirm2Env").hide();
     $("#submit").show();
	 $("#affirm3EnvSelect").hide();
	 $("#affirm3Env").hide();
	 $("#functionEnvSelect").hide();
	 $("#functionEnv").hide();
	 $("#functionEnv_adv").hide();
	 $("#functionSelect").hide();
 	 $("#collegeEnv").hide();
     $("#financialEnv").hide();
     $("#overseaEnv").hide();
 	 $("#dianxingEnvSelect").hide();  
	 $("#performanceAdv").hide();
	 $("#performanceEnv").hide();
	 $("#performanceSelect").hide();
	 $("#cmdautoEnv").show();
	 $("#memorytestEnv").hide();
   });
   
  $("#memorytest").click(function(){
     $("#affirm2Env").hide();
     $("#submit").show();
	 $("#affirm3EnvSelect").hide();
	 $("#affirm3Env").hide();
	 $("#functionEnvSelect").hide();
	 $("#functionEnv").hide();
	 $("#functionEnv_adv").hide();
	 $("#functionSelect").hide();
 	 $("#collegeEnv").hide();
     $("#financialEnv").hide();
     $("#overseaEnv").hide();
 	 $("#dianxingEnvSelect").hide();  
	 $("#performanceAdv").hide();
	 $("#performanceEnv").hide();
	 $("#performanceSelect").hide();
	 $("#cmdautoEnv").hide();
	 $("#memorytestEnv").show();
   });
    
   $("#affirm3EnvSelect").change(function(){
             var affirm3envno = $("#affirm3EnvSel option:selected").val();
             $("#affirm3s1ip")[0].value = affirm3env[affirm3envno].s1ip;
             $("#affirm3s4ip")[0].value = affirm3env[affirm3envno].s4ip;
             $("#affirm3s1p1")[0].value = affirm3env[affirm3envno].s1p1;
             $("#affirm3s1p2")[0].value = affirm3env[affirm3envno].s1p2;
             $("#affirm3s1p3")[0].value = affirm3env[affirm3envno].s1p3;
             $("#affirm3s1p4")[0].value = affirm3env[affirm3envno].s1p4;
             $("#affirm3s1p5")[0].value = affirm3env[affirm3envno].s1p5;
             $("#affirm3s1p6")[0].value = affirm3env[affirm3envno].s1p6;
             $("#affirm3s1p7")[0].value = affirm3env[affirm3envno].s1p7;

             $("#affirm3s2device")[0].value = affirm3env[affirm3envno].s2device;
             $("#affirm3s2ip")[0].value = affirm3env[affirm3envno].s2ip;
             $("#affirm3s5ip")[0].value = affirm3env[affirm3envno].s5ip;
             $("#affirm3s2p1")[0].value = affirm3env[affirm3envno].s2p1;
             $("#affirm3s2p2")[0].value = affirm3env[affirm3envno].s2p2;
             $("#affirm3s2p3")[0].value = affirm3env[affirm3envno].s2p3;
             $("#affirm3s2p4")[0].value = affirm3env[affirm3envno].s2p4;
             $("#affirm3s2p5")[0].value = affirm3env[affirm3envno].s2p5;
             $("#affirm3s2p6")[0].value = affirm3env[affirm3envno].s2p6;
             $("#affirm3s2p7")[0].value = affirm3env[affirm3envno].s2p7;
             $("#affirm3s2p8")[0].value = affirm3env[affirm3envno].s2p8;
             $("#affirm3s2p9")[0].value = affirm3env[affirm3envno].s2p9;
             $("#affirm3s2p10")[0].value = affirm3env[affirm3envno].s2p10;
             $("#affirm3s2p11")[0].value = affirm3env[affirm3envno].s2p11;
             $("#affirm3s2p12")[0].value = affirm3env[affirm3envno].s2p12;

             $("#affirm3s6ip")[0].value = affirm3env[affirm3envno].s6ip;
             $("#affirm3s6p1")[0].value = affirm3env[affirm3envno].s6p1;
             $("#affirm3s6p2")[0].value = affirm3env[affirm3envno].s6p2;

             $("#affirm3ixiaip")[0].value = affirm3env[affirm3envno].ixia_ip;
             $("#affirm3tp1")[0].value = affirm3env[affirm3envno].tp1;
             $("#affirm3tp2")[0].value = affirm3env[affirm3envno].tp2;

             $("#affirm3server")[0].value = affirm3env[affirm3envno].server;
             $("#affirm3client")[0].value = affirm3env[affirm3envno].client;
             $("#affirm3admin_ip")[0].value = affirm3env[affirm3envno].admin_ip;
             $("#affirm3radius")[0].value = affirm3env[affirm3envno].radius; 
	         $("#affirm3Env").show();
             $("#submit").show();
   });
   
   $("#dianxingEnvSelect").change(function(){
             var dianxingno = $("#dianxingEnvSel option:selected").val();
             if(dianxingno == 'college'){
                 $("#collegeEnv").show();
                 $("#financialEnv").hide();
                 $("#overseaEnv").hide();
                 $("#submit").show();
             }
              if(dianxingno == 'financial'){
                 $("#collegeEnv").hide();
                 $("#financialEnv").show();
                 $("#overseaEnv").hide();
                 $("#submit").show();
             }
             if(dianxingno == 'oversea'){
                 $("#collegeEnv").hide();
                 $("#financialEnv").hide();
                 $("#overseaEnv").show();
                 $("#submit").show();
             }
             if(dianxingno == '0'){
                 $("#collegeEnv").hide();
                 $("#financialEnv").hide();
                 $("#overseaEnv").hide();
                 $("#submit").hide();
             }
   });
   
   $("#performanceSel").change(function(){
             var ptopo = $("#performanceSel option:selected").val();
             if( ptopo==0 ){
 					$("#submit").hide();
             	    $("#performanceEnv").hide();
                 	$("#performanceEnv1").hide();
                 	$("#performanceEnv2").hide();
                 	$("#performanceAdv").hide();
             }else{                   
             		$("#submit").show();
             	    $("#performanceEnv").show();
             	    var obj = document.getElementById("par_detail");
                 	obj.innerHTML=par_detail[ptopo];
             	    if( ptopo==1 || ptopo==2 ){
             	    	$("#performanceEnv1").show();
                 		$("#performanceEnv2").hide();
                 		$("#performance1s1port")[0].value = '1/0/1;1/0/2;1/0/3';
             	    	$("#performance1tp")[0].value = '1/1;1/2;1/3';
             	    }
             	    if( ptopo==3 ){
             	    	$("#performanceEnv1").show();
                 		$("#performanceEnv2").hide();
             	    	$("#performance1s1port")[0].value = '1/0/1';
             	    	$("#performance1tp")[0].value = '1/1';
             	    }
             	    if( ptopo==4 ){
             	    	$("#performanceEnv1").hide();
                 		$("#performanceEnv2").show();
             	    }
             }
   });
   
   $("#functionEnvSel").change(function(){
	   $("#functionEnv").show();
	   $("#functionEnv_adv").hide();
       var envno = $("#functionEnvSel option:selected").val();
       if( envno==0 ){
 			$("#submit").hide();
 			$("#functionEnv").hide();
        }else{                   
             $("#submit").show();
             $("#functionEnv").show();
             if( poncat_var == 1 ){
                $("#function_env_detail")[0].value = poncat_function_env_detail[envno].details;
                $("#function_env_detail_adv")[0].value = poncat_function_env_detail[envno].details_adv;
             }else{
             	$("#function_env_detail")[0].value = function_env_detail[envno].details;
             	$("#function_env_detail_adv")[0].value = function_env_detail[envno].details_adv;
             }
        }
   });
   
   $("#affirmWirelessEnvSelect").change(function(){
             var waffirm = $("#affirmWirelessEnvSel option:selected").val();
             $("#waffirms1ip")[0].value = allwaffirmenv[waffirm].s1ip;
             $("#waffirms1p1")[0].value = allwaffirmenv[waffirm].s1p1;
             
             $("#waffirms2ip")[0].value = allwaffirmenv[waffirm].s2ip;
             $("#waffirms2p1")[0].value = allwaffirmenv[waffirm].s2p1;
             if( waffirm == 4 ){
                 $("#waffirms1name")[0].value = 'DSCC';
                 $("#waffirms2name")[0].value = 'DSCC';
             }else{
                 $("#waffirms1name")[0].value = 'DCWS-6028';
                 $("#waffirms2name")[0].value = 'DCWS-6028';
	      }
             $("#waffirms3ip")[0].value = allwaffirmenv[waffirm].s3ip;
             $("#waffirms3p1")[0].value = allwaffirmenv[waffirm].s3p1;
             $("#waffirms3p2")[0].value = allwaffirmenv[waffirm].s3p2;
             $("#waffirms3p3")[0].value = allwaffirmenv[waffirm].s3p3;
             $("#waffirms3p4")[0].value = allwaffirmenv[waffirm].s3p4;     
             $("#waffirms3p5")[0].value = allwaffirmenv[waffirm].s3p5;
             $("#waffirms3p6")[0].value = allwaffirmenv[waffirm].s3p6; 
             
             $("#waffirmpc1")[0].value = allwaffirmenv[waffirm].pc1ip;
             $("#waffirmtester")[0].value = allwaffirmenv[waffirm].testerip_wired;     
             $("#waffirmsta1")[0].value = allwaffirmenv[waffirm].sta1ip;
             $("#waffirmsta2")[0].value = allwaffirmenv[waffirm].sta2ip;
             $("#waffirmap1")[0].value = allwaffirmenv[waffirm].ap1ip;
             $("#waffirmap2")[0].value = allwaffirmenv[waffirm].ap2ip;
             $("#wireless_submit").show();
             $("#affirmWirelessEnv").show();
   });
});
</script>

<script type="text/javascript">
function showPerformanceAdv(){
   cur = document.getElementById("performanceAdv");
   if(cur.style.display=="none"){
		cur.style.display="";
   }else{
		cur.style.display="none";
   }
}

function showFunctionEnvAdv(){
   cur = document.getElementById("functionEnv_adv");
   if(cur.style.display=="none"){
		cur.style.display="";
   }else{
		cur.style.display="none";
   }
}

function check_all_function_module() { 
    var allcheckbox = document.getElementsByTagName("input");
    for(var i=0;i<allcheckbox.length;i++){
       if( allcheckbox[i].type=="checkbox" ){
       		allcheckbox[i].checked = true;
       }
    }
    var temp = document.getElementsByName("func_Aggregation");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_dhcpsnooping");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_keepalive_gateway");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_port_channel");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_EgressACL");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_FastLink");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_Ipv4MulticastVlanPort");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_Ipv4Pbr");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_MultiToOneVlanTranslation");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_QACL");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_QINQ");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_QoS");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_SuperVlan");
    temp[0].checked = false;
}

function switch_check_function_module() { 
  	var allcheckbox = document.getElementsByTagName("input");
    for(var i=0;i<allcheckbox.length;i++){
       if( allcheckbox[i].type=="checkbox" ){
          if(allcheckbox[i].checked){
          	allcheckbox[i].checked = false;
          }else{
          	allcheckbox[i].checked = true;
          }
       }
    }
    var temp = document.getElementsByName("func_Aggregation_ixia");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_dhcpsnooping");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_keepalive_gateway");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_port_channel_ixia");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_EgressACL");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_FastLink");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_Ipv4MulticastVlanPort");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_Ipv4Pbr");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_MultiToOneVlanTranslation");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_QACL");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_QINQ");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_QoS");
    temp[0].checked = false;
    var temp = document.getElementsByName("func_SuperVlan");
    temp[0].checked = false;
}

</script>

<script type="text/javascript">
function checkInput(){
  var module = document.getElementsByName("module");
  var ccmmatch = /^([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\:(1000[1-9]|1001[0-6])$/;
  var portmatch = /^(\d|1[0-6])\/((\d|1[0-6])\/)?([1-9]|[1-4]\d|5[0-2])(\:[1-4])?$/;
  var ixiaportmatch = /^([1-9]|1[0-6])\/([1-9]|1[0-6])$/;
  var ipmatch =  /^([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])$/;

  if(module[0].checked){ //affirm2.0
       var s1ip = document.getElementsByName("affirm2s1ip")[0].value;
       if(!ccmmatch.test(s1ip)){  alert("主测CCM(S1IP)输入不正确，输入格式例如：172.17.100.1:10010") ;   return false; }
       var s2ip = document.getElementsByName("affirm2s2ip")[0].value;
       if(!ccmmatch.test(s2ip)){  alert("辅测CCM(S2IP)输入不正确，输入格式例如：172.17.100.1:10010") ;  return false; }

       var s2device = document.getElementsByName("affirm2s2device")[0].value;
       if(s2device == ''){  alert("辅测设备型号不允许留空，请输入例如：DCRS-5980R2") ;   return false; }

       var s1p1 = document.getElementsByName("affirm2s1p1")[0].value;
       if(!portmatch.test(s1p1)){  alert("S1P1输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s1p2 = document.getElementsByName("affirm2s1p2")[0].value;
       if(!portmatch.test(s1p2)){  alert("S1P2输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s1p3 = document.getElementsByName("affirm2s1p3")[0].value;
       if(!portmatch.test(s1p3)){  alert("S1P3输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }

       var s2p1 = document.getElementsByName("affirm2s2p1")[0].value;
       if(!portmatch.test(s2p1)){  alert("S2P1输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p2 = document.getElementsByName("affirm2s2p2")[0].value;
       if(!portmatch.test(s2p2)){  alert("S2P2输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p3 = document.getElementsByName("affirm2s2p3")[0].value;
       if(!portmatch.test(s2p3)){  alert("S2P3输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }

       var ixia = document.getElementsByName("affirm2ixiaip")[0].value;
       if(!ipmatch.test(ixia)){  alert("IXIA IP输入不正确，输入格式例如：172.17.100.252") ;  return false; }

       var tp1 = document.getElementsByName("affirm2tp1")[0].value;
       if(!ixiaportmatch.test(tp1)){  alert("IXIA TP1输入不正确，输入格式例如：1/1 (前数字表示card，后数字表示port)") ;  return false; }
       var tp2 = document.getElementsByName("affirm2tp2")[0].value;
       if(!ixiaportmatch.test(tp2)){  alert("IXIA TP2输入不正确，输入格式例如：1/2 (前数字表示card，后数字表示port)") ;  return false; }
       var aftersale = 0;
       var productversion= document.getElementsByName("productversion")[0].value;
       if( productversion == 0 && aftersale == 1){  alert("售后测试请选择产品流信息，否则无法匹配售后已知缺陷！") ;  return false; }
       var scriptversion= document.getElementsByName("scriptversion")[0].value;
       if( scriptversion== 0 && aftersale == 1){  alert("售后测试请选择脚本流信息，否则无法匹配售后已知缺陷！") ;  return false; }

       return ture;
   }
   else if(module[1].checked){ //affirm3.0
       var s1ip = document.getElementsByName("affirm3s1ip")[0].value;
       if(!ccmmatch.test(s1ip)){  alert("主测CCM(S1IP)输入不正确，输入格式例如：172.17.100.1:10010") ;   return false; }
       var s2ip = document.getElementsByName("affirm3s2ip")[0].value;
       if(!ccmmatch.test(s2ip)){  alert("辅测CCM(S2IP)输入不正确，输入格式例如：172.17.100.1:10010") ;  return false; }

       var s2device = document.getElementsByName("affirm3s2device")[0].value;
       if(s2device == ''){  alert("辅测设备型号不允许留空，请输入例如：DCRS-5980R2") ;   return false; }

       var s1p1 = document.getElementsByName("affirm3s1p1")[0].value;
       if(!portmatch.test(s1p1)){  alert("S1P1输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s1p2 = document.getElementsByName("affirm3s1p2")[0].value;
       if(!portmatch.test(s1p2)){  alert("S1P2输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s1p3 = document.getElementsByName("affirm3s1p3")[0].value;
       if(!portmatch.test(s1p3)){  alert("S1P3输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s1p4 = document.getElementsByName("affirm3s1p4")[0].value;
       if(!portmatch.test(s1p4)){  alert("S1P4输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s1p5 = document.getElementsByName("affirm3s1p5")[0].value;
       if(!portmatch.test(s1p5)){  alert("S1P5输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s1p6 = document.getElementsByName("affirm3s1p6")[0].value;
       if(!portmatch.test(s1p6)){  alert("S1P6输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s1p7 = document.getElementsByName("affirm3s1p7")[0].value;
       if(!portmatch.test(s1p7)){  alert("S1P7输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       
       var s2p1 = document.getElementsByName("affirm3s2p1")[0].value;
       if(!portmatch.test(s2p1)){  alert("S2P1输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p2 = document.getElementsByName("affirm3s2p2")[0].value;
       if(!portmatch.test(s2p2)){  alert("S2P2输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p3 = document.getElementsByName("affirm3s2p3")[0].value;
       if(!portmatch.test(s2p3)){  alert("S2P3输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p4 = document.getElementsByName("affirm3s2p4")[0].value;
       if(!portmatch.test(s2p4)){  alert("S2P4输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p5 = document.getElementsByName("affirm3s2p5")[0].value;
       if(!portmatch.test(s2p5)){  alert("S2P5输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p6 = document.getElementsByName("affirm3s2p6")[0].value;
       if(!portmatch.test(s2p6)){  alert("S2P6输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p7 = document.getElementsByName("affirm3s2p7")[0].value;
       if(!portmatch.test(s2p7)){  alert("S2P7输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p8 = document.getElementsByName("affirm3s2p8")[0].value;
       if(!portmatch.test(s2p8)){  alert("S2P8输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p9 = document.getElementsByName("affirm3s2p9")[0].value;
       if(!portmatch.test(s2p9)){  alert("S2P9输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p10 = document.getElementsByName("affirm3s2p10")[0].value;
       if(!portmatch.test(s2p10)){  alert("S2P10输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p11 = document.getElementsByName("affirm3s2p11")[0].value;
       if(!portmatch.test(s2p11)){  alert("S2P11输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s2p12 = document.getElementsByName("affirm3s2p12")[0].value;
       if(!portmatch.test(s2p12)){  alert("S2P12输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }

       var s6ip = document.getElementsByName("affirm3s6ip")[0].value;
       if(!ccmmatch.test(s6ip)){  alert("辅测CCM(S6IP)输入不正确，输入格式例如：172.17.100.1:10010") ;  return false; }
       var s6p1 = document.getElementsByName("affirm3s6p1")[0].value;
       if(!portmatch.test(s6p1)){  alert("S6P1输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
       var s6p2 = document.getElementsByName("affirm3s6p2")[0].value;
       if(!portmatch.test(s6p2)){  alert("S6P2输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }

       var ixia = document.getElementsByName("affirm3ixiaip")[0].value;
       if(!ipmatch.test(ixia)){  alert("IXIA IP输入不正确，输入格式例如：172.17.100.252") ;  return false; }

       var tp1 = document.getElementsByName("affirm3tp1")[0].value;
       if(!ixiaportmatch.test(tp1)){  alert("IXIA TP1输入不正确，输入格式例如：1/1 (前数字表示card，后数字表示port)") ;  return false; }
       var tp2 = document.getElementsByName("affirm3tp2")[0].value;
       if(!ixiaportmatch.test(tp2)){  alert("IXIA TP2输入不正确，输入格式例如：1/2 (前数字表示card，后数字表示port)") ;  return false; }

       //var affirm5 = document.getElementsByName("affirm3and2check")[0].checked;
       //if( affirm5 && s1p1 >= s1p2 ){  alert("连跑确认2.0，拓扑需要满足：S1P1 < S1P2，请检查！") ;  return false; }
       //if( affirm5 && s2p1 >= s2p2 ){  alert("连跑确认2.0，拓扑需要满足：S2P1 < S2P2，请检查！") ;  return false; }

       var serverip = document.getElementsByName("affirm3server")[0].value;
       if(!ipmatch.test(serverip)){  alert("Server IP输入不正确，输入格式例如：172.17.100.252") ;  return false; }
       var clientip = document.getElementsByName("affirm3client")[0].value;
       if(!ipmatch.test(clientip)){  alert("Client IP输入不正确，输入格式例如：172.17.100.252") ;  return false; }
       var adminip = document.getElementsByName("affirm3admin_ip")[0].value;
       if(!ipmatch.test(adminip)){  alert("Admin IP输入不正确，输入格式例如：172.17.100.252") ;  return false; }
       var radiusip = document.getElementsByName("affirm3radius")[0].value;
       if(!ipmatch.test(radiusip)){  alert("Radius IP输入不正确，输入格式例如：172.17.100.252") ;  return false; }

       return ture;
  }
  else if(module[2].checked){ //function
      var f1 = document.getElementsByName("func_Am")[0].checked;
      var f2 = document.getElementsByName("func_Arp")[0].checked;
      var f3 = document.getElementsByName("func_ArpGuard")[0].checked;
      var f4 = document.getElementsByName("func_DCSCM")[0].checked;
      var f5 = document.getElementsByName("func_dynamicVlan")[0].checked;
      var f6 = document.getElementsByName("func_FBR")[0].checked;
      var f7 = document.getElementsByName("func_GratuitousArp")[0].checked;
      var f8= document.getElementsByName("func_icmpv6")[0].checked;
      var f9= document.getElementsByName("func_igmpsnooping")[0].checked;
      var f10= document.getElementsByName("func_ipv4acl")[0].checked;
      var f11= document.getElementsByName("func_Ipv4Icmp")[0].checked;
      var f12= document.getElementsByName("func_Ipv4Ipv6Host")[0].checked;
      var f = f1||f2||f3||f4||f5||f6||f7||f8||f9||f10||f11||f12 ;
      var f1= document.getElementsByName("func_ipv4staticroute")[0].checked;
      var f2= document.getElementsByName("func_ipv4v6blackholeroute")[0].checked;
      var f3= document.getElementsByName("func_ipv6acl")[0].checked;
      var f4= document.getElementsByName("func_Ipv6Address")[0].checked;
      var f5= document.getElementsByName("func_Ipv6Nd")[0].checked;
      var f6= document.getElementsByName("func_Ipv6StaticRouting")[0].checked;
      var f7= document.getElementsByName("func_Ipv6vrrp")[0].checked;
      var f8= document.getElementsByName("func_IsolatePort")[0].checked;
      var f9= document.getElementsByName("func_l2")[0].checked;
      var f10= document.getElementsByName("func_lldp")[0].checked;
      var f11= document.getElementsByName("func_LocalProxyARP")[0].checked;
      var f12= document.getElementsByName("func_loopbackdetection")[0].checked;
      f = f||f1||f2||f3||f4||f5||f6||f7||f8||f9||f10||f11||f12 ;
      var f1= document.getElementsByName("func_mirror")[0].checked;
      var f2= document.getElementsByName("func_mrpp")[0].checked;
      var f3= document.getElementsByName("func_mstp")[0].checked;
      var f4= document.getElementsByName("func_PortStatistic")[0].checked;
      var f5= document.getElementsByName("func_PortVlanIpLimit")[0].checked;
      var f6= document.getElementsByName("func_PreventARPSboofing")[0].checked;
      var f7= document.getElementsByName("func_PreventNDSboofing")[0].checked;
      var f8= document.getElementsByName("func_rate_violation")[0].checked;
      var f9= document.getElementsByName("func_RSPAN")[0].checked;
      var f10= document.getElementsByName("func_security-ra")[0].checked;
      var f11= document.getElementsByName("func_ULPP")[0].checked;
      var f12= document.getElementsByName("func_vlan")[0].checked;
      f = f||f1||f2||f3||f4||f5||f6||f7||f8||f9||f10||f11||f12 ;
      var f1= document.getElementsByName("func_vlan_acl")[0].checked;
      var f2= document.getElementsByName("func_VRRP")[0].checked;
      var f3= document.getElementsByName("func_Aggregation")[0].checked;
      var f4= document.getElementsByName("func_port_channel")[0].checked;
      f = f||f1||f2||f3||f4 ;
      if(f){
          return ture;
      }else{
          alert('注意：最少需要勾选一个模块！');
          return false;
      }
  }else if(module[3].checked){ //dianxing
      return ture;
  }else if(module[4].checked){ //performance
      return ture;
  }else if(module[5].checked){ //cmd auto
      var s1ip = document.getElementsByName("cmdautos1ip")[0].value;
      if(!ccmmatch.test(s1ip)){  alert("主测CCM输入不正确，输入格式例如：172.17.100.1:10010") ;   return false; }
      return ture;
  }else if(module[6].checked){ //memory test
      var s1ip = document.getElementsByName("memorytests1ip")[0].value;
      if(!ccmmatch.test(s1ip)){  alert("主测CCM输入不正确，输入格式例如：172.17.100.1:10010") ;   return false; }
      return ture;
  }
  return false;  
}
</script>

<script type="text/javascript">
function checkInput_wireless(){
  var ccmmatch = /^([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\:(1000[1-9]|1001[0-6])$/;
  var portmatch = /^(\d|1[0-6])\/((\d|1[0-6])\/)?([1-9]|[1-4]\d|5[0-2])(\:[1-4])?$/;
  var ipmatch =  /^([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-4])$/;

  var obj = document.getElementById("affirmWirelessEnvSelect");
  var index = obj.selectedIndex;
  var selected = obj.options[index].value;

  var s1ip = document.getElementsByName("waffirms1ip")[0].value;
  var s2ip = document.getElementsByName("waffirms2ip")[0].value;
  var s1p1 = document.getElementsByName("waffirms1p1")[0].value;
  var s2p1 = document.getElementsByName("waffirms2p1")[0].value;
  
  if( selected == 1 || selected == 2 || selected == 3 ){
     if(!ccmmatch.test(s1ip)){  alert("S1IP输入不正确，输入格式例如：80.0.0.42:10010") ;   return false; }
     if(!ccmmatch.test(s2ip)){  alert("S2IP输入不正确，输入格式例如：80.0.0.42:10010") ;   return false; }
     if(!portmatch.test(s1p1)){  alert("S1P1输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
     if(!portmatch.test(s2p1)){  alert("S2P1输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
  }
  if(selected == 4){
     if(!ipmatch.test(s1ip)){  alert("S1IP输入不正确，输入格式例如：80.0.0.42") ;   return false; }
     if(!ipmatch.test(s2ip)){  alert("S2IP输入不正确，输入格式例如：80.0.0.42") ;   return false; }
  }

  if(selected == 0){
     alert("执行环境关系到执行本地的具体平台PATH，请先选择执行环境！");
     return false;
   }
     
  var s3ip = document.getElementsByName("waffirms3ip")[0].value;
  if(!ccmmatch.test(s3ip)){  alert("S3IP输入不正确，输入格式例如：80.0.0.42:10010") ;  return false; } 
  var s3p1 = document.getElementsByName("waffirms3p1")[0].value;
  if(!portmatch.test(s3p1)){  alert("S3P1输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
  var s3p2 = document.getElementsByName("waffirms3p2")[0].value;
  if(!portmatch.test(s3p2)){  alert("S3P2输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
  var s3p3 = document.getElementsByName("waffirms3p3")[0].value;
  if(!portmatch.test(s3p3)){  alert("S3P3输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
  var s3p4 = document.getElementsByName("waffirms3p4")[0].value;
  if(!portmatch.test(s3p4)){  alert("S3P4输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
  var s3p5 = document.getElementsByName("waffirms3p5")[0].value;
  if(!portmatch.test(s3p5)){  alert("S3P5输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
  var s3p6 = document.getElementsByName("waffirms3p6")[0].value;
  if(!portmatch.test(s3p6)){  alert("S3P6输入不正确，输入格式例如：1/10 或 1/0/20") ;  return false; }
  
  var pc1 = document.getElementsByName("waffirmpc1")[0].value;
  if(!ipmatch.test(pc1)){  alert("服务器PC1 IP输入不正确，输入格式例如：172.16.1.54") ;  return false; }
  var tester = document.getElementsByName("waffirmtester")[0].value;
  if(!ipmatch.test(tester)){  alert("Tester_Wired IP输入不正确，输入格式例如：172.16.1.54") ;  return false; }

  var sta1 = document.getElementsByName("waffirmsta1")[0].value;
  if(!ipmatch.test(sta1)){  alert("STA1 IP输入不正确，输入格式例如： 80.0.0.10") ;  return false; }
  var sta2 = document.getElementsByName("waffirmsta2")[0].value;
  if(!ipmatch.test(sta2)){  alert("STA2 IP输入不正确，输入格式例如：80.0.0.10") ;  return false; }
 
  var ap1 = document.getElementsByName("waffirmap1")[0].value;
  if(!ccmmatch.test(ap1)){  alert("AP1 IP输入不正确，输入格式例如： 80.0.0.42:10010") ;  return false; }
  var ap2 = document.getElementsByName("waffirmap2")[0].value;
  if(!ccmmatch.test(ap2)){  alert("AP2 IP输入不正确，输入格式例如：80.0.0.42:10010") ;  return false; }

  return ture;
}

</script>

{/literal}
</head>
<body {$body_onload}>
{assign var="cfg_section" value=$smarty.template|basename|replace:".tpl":"" }
{config_load file="input_dimensions.conf" section=$cfg_section}


<h1 class="title">自动执行环境设置</h1>
<div class="workBack">

{if $gui->productline_id == 1} {* 有线交换机测试 *}

<form name=switchrunform action="/lib/execute/jobsRun.php" method="post" onsubmit="javascript:return checkInput();">

<div id="moduleSelect" name="moduleSelect" align="center" >
		<input name="module" id="affirm2" type="radio" value="affirm2" ><font size="4"><strong>确认测试2.0</strong></font></input>
		<input name="module" id="affirm3" type="radio" value="affirm3" ><font size="4"><strong>确认测试3.0</strong></font></input>
		<input name="module" id="function" type="radio" value="function" ><font size="4"><strong>功能测试</strong></font></input>
		<input name="module" id="dianxing" type="radio" value="dianxing" ><font size="4"><strong>典型应用测试</strong></font></input>
		<input name="module" id="softperformance" type="radio" value="softperformance" ><font size="4"><strong>软件性能测试</strong></font></input>
		<input name="module" id="cmdauto" type="radio" value="cmdauto" ><font size="4"><strong>命令行测试</strong></font></input>
		<input name="module" id="memorytest" type="radio" value="memorytest" ><font size="4"><strong>内存泄露测试</strong></font></input>
</div>
<div id="affirm3EnvSelect" name="affirm3EnvSelect" style="display:none">确认测试3.0固定环境<select id="affirm3EnvSel">
		<option value='0'>请选择执行环境</option>
		<option value='wh1'>武汉第一套3.0环境(左机柜上方)</option>
		<option value='wh2'>武汉第二套3.0环境(左机柜下方)</option>
		<option value='wh3'>武汉第三套3.0环境(右机柜下方)</option>
		<option value='wh4'>武汉第四套3.0环境(右机柜上方)</option>
		<option value='bj1'>北京第一套3.0环境(34#机架)</option>
        <option value='bj2'>北京第二套3.0环境(bigstone测试环境处)</option>
		</select>连跑确认测试2.0<input name="affirm3and2check" type="checkbox" value="1" /><span style="color:Red">连跑要求端口号S1P2>=S1P1和S2P2>=S2P1,否则执行affirm2时拓扑检查不过!</span>
</div>

<div id="dianxingEnvSelect" name="dianxingEnvSelect" style="display:none">典型应用环境环境<select id="dianxingEnvSel" name="dianxingEnvSel">
		<option value='0'>请选择典型应用环境</option>
		<option value='college'>校园网环境</option>
		<option value='oversea'>海外运营商环境</option>
		<option value='financial'>金融环境</option>
		</select>
</div>

<div id="performanceSelect" name="performanceSelect" style="display:none">软件性能指标测试点<select id="performanceSel" name="performanceSel">
		<option value='0'>请选择待测试性能指标</option>
		<option value='1'>IgmpSnooping处理性能</option>
		<option value='2'>IgmpSnooping时延</option>
		<option value='3'>协议收包缓冲区长度</option>
		{if $gui->device_not_box eq 1}
			<option value='4'>板间协议处理能力</option>
		{/if}
		</select>
</div>

<div id="submit" name="submit" align="center"  style="display:none" >
<hr>
<input type="submit" name="switchsubmit" id="switchsubmit"  value="猛击开始测试" />
<hr>
</div>

<div id="functionSelect" name="functionSelect" align="center" style="display:none">
 <table border="1"><tbody>
  <tr><td align="center" valign="center" colspan=6 ><span style="font-size: 14px;color:#E53333;"><strong>Moni  +  Dsend</strong></span></td></tr>
  <tr>
	<td><input name="func_Am" type="checkbox" value="1" checked="checked" />Am</td>
	<td><input name="func_Arp" type="checkbox" value="1" checked="checked" />Arp</td>
	<td><input name="func_ArpGuard" type="checkbox" value="1" checked="checked" />ArpGuard</td>
	<td><input name="func_DCSCM" type="checkbox" value="1" checked="checked" />DCSCM</td>
	<td><input name="func_dynamicVlan" type="checkbox" value="1" checked="checked" />dynamicVlan</td>
	<td><input name="func_FBR" type="checkbox" value="1" checked="checked" />FBR</td>
  </tr>
  <tr>
	<td><input name="func_GratuitousArp" type="checkbox" value="1" checked="checked" />GratuitousArp</td>
	<td><input name="func_icmpv6" type="checkbox" value="1" checked="checked" />icmpv6</td>
	<td><input name="func_igmpsnooping" type="checkbox" value="1" checked="checked" />igmpsnooping</td>
    <td><input name="func_ipv4acl" type="checkbox" value="1" checked="checked" />ipv4acl</td>
	<td><input name="func_Ipv4Icmp" type="checkbox" value="1" checked="checked" />Ipv4Icmp</td>
	<td><input name="func_Ipv4Ipv6Host" type="checkbox" value="1" checked="checked" />Ipv4Ipv6Host</td>
  </tr>
  <tr>
	<td><input name="func_ipv4staticroute" type="checkbox" value="1" checked="checked" />ipv4staticroute</td>
	<td><input name="func_ipv4v6blackholeroute" type="checkbox" value="1" checked="checked" />ipv4v6blackholeroute</td>
	<td><input name="func_ipv6acl" type="checkbox" value="1" checked="checked" />ipv6acl</td>
    <td><input name="func_Ipv6Address" type="checkbox" value="1" checked="checked" />Ipv6Address</td>
	<td><input name="func_Ipv6Nd" type="checkbox" value="1" checked="checked" />Ipv6Nd</td>
	<td><input name="func_Ipv6StaticRouting" type="checkbox" value="1" checked="checked" />Ipv6StaticRouting</td>
   </tr>
   <tr>
	<td><input name="func_Ipv6vrrp" type="checkbox" value="1" checked="checked" />Ipv6vrrp</td>
	<td><input name="func_IsolatePort" type="checkbox" value="1" checked="checked" />IsolatePort</td>
    <td><input name="func_l2" type="checkbox" value="1" checked="checked" />l2</td>
	<td><input name="func_lldp" type="checkbox" value="1" checked="checked" />lldp</td>
	<td><input name="func_LocalProxyARP" type="checkbox" value="1" checked="checked" />LocalProxyARP</td>
	<td><input name="func_loopbackdetection" type="checkbox" value="1" checked="checked" />loopbackdetection</td>
   </tr>
   <tr>	
	<td><input name="func_mirror" type="checkbox" value="1" checked="checked" />mirror</td>
	<td><input name="func_mrpp" type="checkbox" value="1" checked="checked" />mrpp</td>
	<td><input name="func_mstp" type="checkbox" value="1" checked="checked" />mstp</td>
	<td><input name="func_PortStatistic" type="checkbox" value="1" checked="checked" />PortStatistic</td>
	<td><input name="func_PortVlanIpLimit" type="checkbox" value="1" checked="checked" />PortVlanIpLimit</td>
	<td><input name="func_PreventARPSboofing" type="checkbox" value="1" checked="checked" />PreventARPSboofing</td>
	</tr>
	<tr>
	<td><input name="func_PreventNDSboofing" type="checkbox" value="1" checked="checked" />PreventNDSboofing</td>
    <td><input name="func_rate_violation" type="checkbox" value="1" checked="checked" />rate_violation</td>
	<td><input name="func_RSPAN" type="checkbox" value="1" checked="checked" />RSPAN</td>
	<td><input name="func_security-ra" type="checkbox" value="1" checked="checked" />security-ra</td>
	<td><input name="func_ULPP" type="checkbox" value="1" checked="checked" />ULPP</td>
	<td><input name="func_vlan" type="checkbox" value="1" checked="checked" />vlan</td>
	</tr>
	<tr>
	<td><input name="func_vlan_acl" type="checkbox" value="1" checked="checked" />vlan_acl</td>
	<td><input name="func_VRRP" type="checkbox" value="1" checked="checked" />VRRP</td>
	<td><input name="func_Aggregation" type="checkbox" value="1" checked="checked" />Aggregation</td>
	<td><input name="func_port_channel" type="checkbox" value="1" checked="checked" />port_channel</td>
	<td></td>
	<td></td>
	</tr>
	<tr><td align="center" valign="center" colspan=6 ><span style="font-size: 14px;color:#E53333;"><strong>Moni  +  Ixia</strong></span></td></tr>
	<tr>
	<td><input name="func_Aggregation_ixia" type="checkbox" value="1" disabled />Aggregation</td>
	<td><input name="func_dhcpsnooping" type="checkbox" value="1" disabled />dhcpsnooping</td>
	<td><input name="func_keepalive_gateway" type="checkbox" value="1" disabled />keepalive_gateway</td>
	<td><input name="func_port_channel_ixia" type="checkbox" value="1" disabled />port_channel</td>
	<td></td>
	<td></td>
	</tr>
	<tr><td align="center" valign="center" colspan=6 ><span style="font-size: 14px;color:#E53333;"><strong>DautoV3  +  Dsend</strong></span></td></tr>
	<tr>
	<td><input name="func_EgressACL" type="checkbox" value="1" disabled />EgressACL</td>
	<td><input name="func_FastLink" type="checkbox" value="1" disabled />FastLink</td>
	<td><input name="func_Ipv4MulticastVlanPort" type="checkbox" value="1" disabled />Ipv4MulticastVlanPort</td>
	<td><input name="func_Ipv4Pbr" type="checkbox" value="1" disabled />Ipv4Pbr</td>
	<td><input name="func_MultiToOneVlanTranslation" type="checkbox" value="1" disabled />MultiToOneVlanTranslation</td>
	<td><input name="func_QACL" type="checkbox" value="1" disabled />QACL</td>
	</tr>
	<tr>
	<td><input name="func_QINQ" type="checkbox" value="1" disabled />QINQ</td>
	<td><input name="func_QoS" type="checkbox" value="1" disabled />QoS</td>
	<td><input name="func_SuperVlan" type="checkbox" value="1" disabled />Supervlan</td>
	<td></td>
	<td></td>
	<td></td>
	</tr>
	<tr>
	<td></td>
	<td></td>
	<td align='center'><input type='button' value='全选' onclick="check_all_function_module();"></td>
	<td align='center'><input type='button' value='反选' onclick="switch_check_function_module();"></td>
	<td></td>
	<td></td>
	</tr>
</tbody></table>
</div>

<div id="functionEnvSelect" name="functionEnvSelect" align="center" style="display:none">选择固定环境<select id="functionEnvSel" name='functionEnvSel'>
		<option value='0'>请选择执行环境</option>
		<option value='131-11918'>武汉发包工具100.131:11918</option>
		<option value='135-11918'>武汉发包工具100.135:11918</option>
		<option value='135-11919'>武汉发包工具100.135:11919</option>
		<option value='136-11919'>武汉发包工具100.136:11919</option>
		<option value='138-11918'>武汉发包工具100.138:11918</option>
		<option value='138-11919'>武汉发包工具100.138:11919</option>
		</select>
</div>

<div id="functionEnv" align="center" style="display:none;">
 <table border="1"><tbody>
		<tr>
			<th align="center" valign="center"><br /><br /><br />参<br />数<br />调<br />整</th>
			<td align="center" valign="center"><textarea wrap="off" cols=115 rows=20 name='function_env_detail' id='function_env_detail'></textarea></td>
		</tr>
</tbody></table>
<div align="center"><input type="button" onclick="showFunctionEnvAdv();" value="显示/隐藏高级参数" ></div> 
</div>

<div id="functionEnv_adv" align="center" style="display:none;">
 <table border="1"><tbody>
		<tr>
			<td align="center" valign="center"><textarea wrap="off" cols=115 rows=20 name='function_env_detail_adv' id='function_env_detail_adv'></textarea></td>
		</tr>
</tbody></table>
</div>

<div id='affirm2Env' align="center" style="display:none">
 <table border="1"><tbody>
 		<tr>
			<th align="center" valign="center" colspan="5">
			<span style="font-size: 16px;color:#E53333;"><strong>测试用例集:</strong></span>
					<select name="affirm2platform" id="affirm2platform" style="font-size: 16px;color:#E53333;">
		                <option style="font-size: 16px;color:#E53333;" value='all'><strong>Moni+Dauto测试例</strong></option>
	                    <option style="font-size: 16px;color:#E53333;" value='moni'><strong>Moni平台测试例</strong></option>
		                <option style="font-size: 16px;color:#E53333;" value='dauto'><strong>Dauto平台测试例</strong></option>
	                </select></th>
		</tr>
		<tr>
			<th>&nbsp</th>
			<th align="center" valign="center">连接设备</th>
			<th align="center" valign="center">测试端口</th>
			<th align="center" valign="center">设备型号</th>
			<th align="center" valign="center">资产编号</th>
		</tr>
		<tr>
			<td align="center" valign="center">IXIA</td>
			<td align="center" valign="center"><strong>IP</strong>:<input type="text" name="affirm2ixiaip" id="affirm2ixiaip" size="21" value="172.17.100.x" /></input></td>
			<td align="center" valign="center">
				<strong>TP1</strong>(card1/port1):<input type="text" name="affirm2tp1" id="affirm2tp1" size="6" value="1/x" /><br>
				<strong>TP2</strong>(card2/port2):<input type="text" name="affirm2tp2" id="affirm2tp2" size="6" value="1/x" />
			</td>
			<td align="center" valign="center">售后产品流
                    <select name="productversion" id="productversion">
		                <option value='0'>仅售后必须选择</option>
	                    <option value='3900_pofly_maintain'>3900_pofly_maintain</option>
		                <option value='4500_hurricane_maintain'>4500_hurricane_maintain</option>
		                <option value='4600_rtk_maintain'>4600_rtk_maintain</option>
        		        <option value='5500_xhound_maintain'>5500_xhound_maintain</option>
	                    <option value='3650_rocket_maintain'>3650_rocket_maintain</option>
		                <option value='3950_kelland_maintain'>3950_kelland_maintain</option>
        		        <option value='3950_rocket_maintain'>3950_rocket_maintain</option>
        		        <option value='5750_bobcat_7.1'>5750_bobcat_7.1</option>
	                    <option value='5750_bobcat_maintain'>5750_bobcat_maintain</option>
		                <option value='5750_poncat_maintain'>5750_poncat_maintain</option>
        		        <option value='5960_bobcat_maintain'>5960_bobcat_maintain</option>
        		        <option value='3950_blade_maintain'>3950_blade_maintain</option>
	                    <option value='5950_maintain'>5950_maintain</option>
		                <option value='6200_kennisis_maintain'>6200_kennisis_maintain</option>
		                <option value='6500_redstone_maintain'>6500_redstone_maintain</option>
	                    <option value='6800_fb_ivy7.0_maintain'>6800_FB_ivy7.0_maintain</option>
		                <option value='6800_fb2_ivy7.0_maintain'>6800_FB2_ivy7.0_maintain</option>
		                <option value='6800_kylin_ivy7.0_maintain'>6800_Kylin_ivy7.0_maintain</option>
	                    <option value='7600_fb_ivy7.0_maintain'>7600_FB_ivy7.0_maintain</option>
		                <option value='7600_fb2_ivy7.0_maintain'>7600_FB2_ivy7.0_maintain</option>
		                <option value='7600_kylin_ivy7.0_maintain'>7600_Kylin_ivy7.0_maintain</option>
		                <option value='9800_4xfp_ivy7.0_maintain'>9800_4xfp_ivy7.0_maintain</option>
		                <option value='9800_24gt/gb_ivy7.0_maintain'>9800_24GT/GB_ivy7.0_maintain</option>
		                <option value='9800_24sfp+_ivy7.0_maintain'>9800_24SFP+_ivy7.0_maintain</option>
	                </select>
            </td>
			<td align="center" valign="center">售后脚本流
                    <select name="scriptversion" id="scriptversion">
		                <option value='0'>仅售后必须选择</option>
	                   	<option value='7.0patch'>7.0patch</option>
		                <option value='6.3'>6.3</option>
	                </select>
	        </td>
		</tr>
		<tr>
			<td align="center" valign="center">主测S1</td>
			<td align="center" valign="center"><input type="text" size="21" name="affirm2s1ip" id="affirm2s1ip" value="172.17.100.x:10001" /></td>
			<td align="center" valign="center">
				<strong>P1</strong>:Ethernet <input type="text" name="affirm2s1p1" id="affirm2s1p1" size="10" value="1/0/x" /><br>
				<strong>P2</strong>:Ethernet <input type="text" name="affirm2s1p2" id="affirm2s1p2" size="10" value="1/0/x" /><br>
				<strong>P3</strong>:Ethernet <input type="text" name="affirm2s1p3" id="affirm2s1p3" size="10" value="1/0/x" />
			</td>
			<td align="center" valign="center">{$gui->device_name}<input type="hidden" name="affirm2s1device" id="affirm2s1device" value={$gui->device_name} /></td>
			<td align="center" valign="center"><input type="text" name="affirm2s1sn" id="affirm2s1sn" size="30" value="" /><br />(可以为空)</td>
		</tr>
		<tr>
			<td align="center" valign="center">辅测S2</td>
			<td align="center" valign="center"><input type="text" name="affirm2s2ip" id="affirm2s2ip" size="21" value="172.17.100.x:10015" /></td>
			<td align="center" valign="center">
				<strong>P1</strong>:Ethernet <input type="text" name="affirm2s2p1" id="affirm2s2p1" size="10" value="1/0/x" /><br>
				<strong>P2</strong>:Ethernet <input type="text" name="affirm2s2p2" id="affirm2s2p2" size="10" value="1/0/x" /><br>
				<strong>P3</strong>:Ethernet <input type="text" name="affirm2s2p3" id="affirm2s2p3" size="10" value="1/0/x" />
			</td>
			<td align="center" valign="center">
			<span style="color:Red">确认测试辅测必须为5960及以上的设备</span>
			<br />
			<input type="text" name="affirm2s2device" id="affirm2s2device" size="30" value="DCRS-5980R2" />
			</td>
			<td align="center" valign="center"><input type="text" name="affirm2s2sn" id="affirm2s2sn" size="30" value="" /><br />(可以为空)</td>
		</tr>
	</tbody></table>
</div>

<div id="affirm3Env" name="affirm3Env" align="center" style="display:none">
 <table border="1"><tbody>
		<tr>
			<th>&nbsp</th>
			<th align="center" valign="center">连接设备</th>
			<th align="center" valign="center">测试端口</th>
			<th align="center" valign="center">设备型号</th>
			<th align="center" valign="center">说  明</th>
		</tr>
		<tr>
			<td align="center" valign="center">IXIA</td>
			<td align="center" valign="center"><strong>IP</strong>:<input type="text" id="affirm3ixiaip" name="affirm3ixiaip" size="21" /></input></td>
			<td align="center" valign="center">
				<strong>TP1</strong>(card1/port1):<input type="text" id="affirm3tp1" name="affirm3tp1" size="6" /><br>
				<strong>TP2</strong>(card2/port2):<input type="text" id="affirm3tp2" name="affirm3tp2" size="6" />
			</td>
			<td>&nbsp</td><td>&nbsp</td>
		</tr>
		<tr>
			<td align="center" valign="center">主测S1</td>
			<td align="center" valign="center">
				<strong>S1</strong>:<input type="text" size="21" id="affirm3s1ip" name="affirm3s1ip" /><br>
				<br /><br />
				<strong>S4</strong>:<input type="text" size="21" id="affirm3s4ip" name="affirm3s4ip" />
			</td>
			<td align="center" valign="center">
				<strong>P 1</strong>:Ethernet <input type="text" id="affirm3s1p1" name="affirm3s1p1" size="10" /><br>
				<strong>P 2</strong>:Ethernet <input type="text" id="affirm3s1p2" name="affirm3s1p2" size="10" /><br>
				<strong>P 3</strong>:Ethernet <input type="text" id="affirm3s1p3" name="affirm3s1p3" size="10" /><br>
				<strong>P 4</strong>:Ethernet <input type="text" id="affirm3s1p4" name="affirm3s1p4" size="10" /><br>
				<strong>P 5</strong>:Ethernet <input type="text" id="affirm3s1p5" name="affirm3s1p5" size="10" /><br>
				<strong>P 6</strong>:Ethernet <input type="text" id="affirm3s1p6" name="affirm3s1p6" size="10" /><br>
				<strong>P 7</strong>:Ethernet <input type="text" id="affirm3s1p7" name="affirm3s1p7" size="10" />
			</td>
			<td align="center" valign="center">{$gui->device_name}<input type="hidden" name="affirm3s1device" value={$gui->device_name} /></td>
			<td align="center" valign="center">S4是主测S1的备份主控CCM<br />若无或不支持，请留空</td>
		</tr>
		<tr>
			<td align="center" valign="center">辅测S2</td>
			<td align="center" valign="center">
				<strong>S2</strong>:<input type="text" size="21" id="affirm3s2ip" name="affirm3s2ip" /><br>
				<br /><br />
				<strong>S5</strong>:<input type="text" size="21" id="affirm3s5ip" name="affirm3s5ip" />
			</td><td align="center" valign="center">
				<strong>P 1</strong>:Ethernet <input type="text" id="affirm3s2p1" name="affirm3s2p1" size="10" /><br>
				<strong>P 2</strong>:Ethernet <input type="text" id="affirm3s2p2" name="affirm3s2p2" size="10" /><br>
				<strong>P 3</strong>:Ethernet <input type="text" id="affirm3s2p3" name="affirm3s2p3" size="10" /><br>
				<strong>P 4</strong>:Ethernet <input type="text" id="affirm3s2p4" name="affirm3s2p4" size="10" /><br>
				<strong>P 5</strong>:Ethernet <input type="text" id="affirm3s2p5" name="affirm3s2p5" size="10" /><br>
				<strong>P 6</strong>:Ethernet <input type="text" id="affirm3s2p6" name="affirm3s2p6" size="10" /><br>
				<strong>P 7</strong>:Ethernet <input type="text" id="affirm3s2p7" name="affirm3s2p7" size="10" /><br>
				<strong>P 8</strong>:Ethernet <input type="text" id="affirm3s2p8" name="affirm3s2p8" size="10" /><br>
				<strong>P 9</strong>:Ethernet <input type="text" id="affirm3s2p9" name="affirm3s2p9" size="10" /><br>
				<strong>P10</strong>:Ethernet <input type="text" id="affirm3s2p10" name="affirm3s2p10" size="10" /><br>
				<strong>P11</strong>:Ethernet <input type="text" id="affirm3s2p11" name="affirm3s2p11" size="10" /><br>
				<strong>P12</strong>:Ethernet <input type="text" id="affirm3s2p12" name="affirm3s2p12" size="10" />
			</td>
			<td align="center" valign="center"><input type="text" id="affirm3s2device" name="affirm3s2device" size="20" /></td>
			<td align="center" valign="center">S5是辅测S2的备份主控CCM<br />若无或不支持，请留空</td>
		</tr>
		<tr>
			<td align="center" valign="center">工装机</td>
			<td align="center" valign="center"><strong>S6</strong>:<input type="text" size="21" id="affirm3s6ip" name="affirm3s6ip" /></td>
			<td>
				<strong>P 1</strong>:Ethernet <input type="text" id="affirm3s6p1" name="affirm3s6p1" size="10" /><br>
				<strong>P 2</strong>:Ethernet <input type="text" id="affirm3s6p2" name="affirm3s6p2" size="10" /><br>	
			</td>
			<td>&nbsp</td><td align="center" valign="center">默认配置是所选环境的固定配置<br />若无修改请使用默认值</td>
		</tr>
                  <tr>
			<td align="center" valign="center">服务器</td>
			<td align="center" valign="center"><strong>Server IP</strong>:<input type="text" id="affirm3server" name="affirm3server" size="15" /></input><br />
                                                              <strong>Client IP</strong>:<input type="text" id="affirm3client" name="affirm3client" size="15" /></input>
                            </td>
			<td align="center" valign="center"><strong>AdminIP</strong>:<input type="text" id="affirm3admin_ip" name="affirm3admin_ip" size="15" /></td>
			<td><strong>Radius</strong>:<input type="text" id="affirm3radius" name="affirm3radius" size="15" /></td><td align="center" valign="center">默认配置是所选环境的固定配置<br />若无修改请使用默认值</td>
                  </tr>
	</tbody></table>
</div>

<div id="collegeEnv" name="collegeEnv" align="center" style="display:none">
 <table border="1"><tbody>
		<tr>
			<th>校园网环境</th>
			<th align="center" valign="center">连接设备</th>
			<th align="center" valign="center">测试端口</th>
			<th align="center" valign="center">设备型号</th>
			<th align="center" valign="center">说  明</th>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>IXIA</strong></td>
			<td align="center" valign="center"><strong>IP:</strong><input type="text" size="21" id="collegeixia" name="collegeixia" value="172.18.100.252" /></td>
			<td align="center" valign="center">
			<strong>Card1/Port1</strong>: <input type="text" id="collegetp1" name="collegetp1" size="10"  value="1/1" /><br>
			<strong>Card2/Port2</strong>: <input type="text" id="collegetp2" name="collegetp2" size="10"  value="1/3" /><br>
			<strong>Card3/Port3</strong>: <input type="text" id="collegetp3" name="collegetp3" size="10"  value="1/4" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S5主测</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="colleges5ip" name="colleges5ip" value="172.18.100.153:10001" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="colleges5p1" name="colleges5p1" size="10" value="1/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="colleges5p2" name="colleges5p2" size="10" value="1/2" /><br>
			<strong>P 5</strong>:Ethernet <input type="text" id="colleges5p5" name="colleges5p5" size="10" value="1/5" /><br>
			<strong>P 6</strong>:Ethernet <input type="text" id="colleges5p6" name="colleges5p6" size="10" value="1/6" /><br>
			<strong>P 7</strong>:Ethernet <input type="text" id="colleges5p7" name="colleges5p7" size="10" value="1/7" /><br>
			<strong>P 8</strong>:Ethernet <input type="text" id="colleges5p8" name="colleges5p8" size="10" value="1/8" /><br>
			<strong>P 9</strong>:Ethernet <input type="text" id="colleges5p9" name="colleges5p9" size="10" value="1/9" /><br>
			<strong>P10</strong>:Ethernet <input type="text" id="colleges5p10" name="colleges5p10" size="10" value="1/10" /><br>
			<strong>P11</strong>:Ethernet <input type="text" id="colleges5p11" name="colleges5p11" size="10" value="1/11" /><br>
			<strong>P12</strong>:Ethernet <input type="text" id="colleges5p12" name="colleges5p12" size="10" value="1/12" /><br>
			<strong>P13</strong>:Ethernet <input type="text" id="colleges5p13" name="colleges5p13" size="10" value="1/13" /><br>
			<strong>P14</strong>:Ethernet <input type="text" id="colleges5p14" name="colleges5p14" size="10" value="1/14" /><br>
			<strong>P5-14</strong>:Ethernet <input type="text" id="colleges5p514" name="colleges5p514" size="10" value="1/5-14" /><br>	
			<strong>P15</strong>:Ethernet <input type="text" id="colleges5p15" name="colleges5p15" size="10" value="1/15" /><br>
			<strong>P16</strong>:Ethernet <input type="text" id="colleges5p16" name="colleges5p16" size="10" value="1/16" /><br>
			<strong>P17</strong>:Ethernet <input type="text" id="colleges5p17" name="colleges5p17" size="10" value="1/17" /><br>
			<strong>P19</strong>:Ethernet <input type="text" id="colleges5p19" name="colleges5p19" size="10" value="1/19" />
			</td>
			<td align="center" valign="center">{$gui->device_name}</td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>APC</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="collegeapc" name="collegeapc" value="172.18.100.152:10008" /></td>
			<td align="center" valign="center"><strong>Port</strong>: <input type="text" id="collegeapcp1" name="collegeapcp1" size="10" value="1" /></td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center">以APC模拟主测掉电测试<br>请保证主测电源连接到APC输出口</td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S1</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="colleges1ip" name="colleges1ip" value="172.18.100.152:10009" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="colleges1p1" name="colleges1p1" size="10" value="1/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="colleges1p2" name="colleges1p2" size="10" value="1/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="colleges1p3" name="colleges1p3" size="10" value="1/3" /><br>
			<strong>P 4</strong>:Ethernet <input type="text" id="colleges1p4" name="colleges1p4" size="10" value="1/4" /><br>
			<strong>P 5</strong>:Ethernet <input type="text" id="colleges1p5" name="colleges1p5" size="10" value="1/5" /><br>
			<strong>P 6</strong>:Ethernet <input type="text" id="colleges1p6" name="colleges1p6" size="10" value="1/6" />
			</td>
			<td align="center" valign="center">DCRS-9800</td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S2</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="colleges2ip" name="colleges2ip" value="172.18.100.152:10010" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="colleges2p1" name="colleges2p1" size="10" value="1/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="colleges2p2" name="colleges2p2" size="10" value="1/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="colleges2p3" name="colleges2p3" size="10" value="1/3" /><br>
			<strong>P 4</strong>:Ethernet <input type="text" id="colleges2p4" name="colleges2p4" size="10" value="1/4" /><br>
			<strong>P 5</strong>:Ethernet <input type="text" id="colleges2p5" name="colleges2p5" size="10" value="1/5" />
			</td>
			<td align="center" valign="center">DCRS-7600</td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S3</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="colleges3ip" name="colleges3ip" value="172.18.100.153:10003" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="colleges3p1" name="colleges3p1" size="10" value="1/0/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="colleges3p2" name="colleges3p2" size="10" value="1/0/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="colleges3p3" name="colleges3p3" size="10" value="1/0/3" />
			</td>
			<td align="center" valign="center">DCRS-5960</td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S4</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="colleges4ip" name="colleges4ip" value="172.18.100.153:10004" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="colleges4p1" name="colleges4p1" size="10" value="1/0/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="colleges4p2" name="colleges4p2" size="10" value="1/0/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="colleges4p3" name="colleges4p3" size="10" value="1/0/3" />
			</td>
			<td align="center" valign="center">DCRS-5960</td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S6</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="colleges6ip" name="colleges6ip" value="172.18.100.153:10006" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="colleges6p1" name="colleges6p1" size="10" value="1/0/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="colleges6p2" name="colleges6p2" size="10" value="1/0/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="colleges6p3" name="colleges6p3" size="10" value="1/0/3" /><br>
			<strong>P 4</strong>:Ethernet <input type="text" id="colleges6p4" name="colleges6p4" size="10" value="1/0/4" /><br>
			<strong>P 5</strong>:Ethernet <input type="text" id="colleges6p5" name="colleges6p5" size="10" value="1/0/5" /><br>
			<strong>P 6</strong>:Ethernet <input type="text" id="colleges6p6" name="colleges6p6" size="10" value="1/0/6" /><br>
			<strong>P 7</strong>:Ethernet <input type="text" id="colleges6p7" name="colleges6p7" size="10" value="1/0/7" /><br>
			<strong>P 8</strong>:Ethernet <input type="text" id="colleges6p8" name="colleges6p8" size="10" value="1/0/8" /><br>
			<strong>P 9</strong>:Ethernet <input type="text" id="colleges6p9" name="colleges6p9" size="10" value="1/0/9" /><br>
			<strong>P10</strong>:Ethernet <input type="text" id="colleges6p10" name="colleges6p10" size="10" value="1/0/10" /><br>
			<strong>P11</strong>:Ethernet <input type="text" id="colleges6p11" name="colleges6p11" size="10" value="1/0/11" /><br>
			<strong>P12</strong>:Ethernet <input type="text" id="colleges6p12" name="colleges6p12" size="10" value="1/0/12" /><br>
			<strong>P3-12</strong>:Ethernet <input type="text" id="colleges6p312" name="colleges6p312" size="10" value="1/0/3-12" /><br>
			<strong>P13</strong>:Ethernet <input type="text" id="colleges6p13" name="colleges6p13" size="10" value="1/0/13" /><br>
			<strong>P14</strong>:Ethernet <input type="text" id="colleges6p14" name="colleges6p14" size="10" value="1/0/14" /><br>	
			<strong>P15</strong>:Ethernet <input type="text" id="colleges6p15" name="colleges6p15" size="10" value="1/0/15" /><br>
			<strong>ALL</strong>:Ethernet <input type="text" id="colleges6pall" name="colleges6pall" size="10" value="1/0/1-28" />
			</td>
			<td align="center" valign="center">DCRS-5750</td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S7</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="colleges7ip" name="colleges7ip" value="172.18.100.153:10007" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="colleges7p1" name="colleges7p1" size="10" value="1/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="colleges7p2" name="colleges7p2" size="10" value="1/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="colleges7p3" name="colleges7p3" size="10" value="1/3" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center">HUB</td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S8</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="colleges8ip" name="colleges8ip" value="172.18.100.153:10008" /></td>
			<td align="center" valign="center">
			<strong>P 5</strong>:Ethernet <input type="text" id="colleges8p5" name="colleges8p5" size="10" value="1/5" /><br>
			<strong>P 6</strong>:Ethernet <input type="text" id="colleges8p6" name="colleges8p6" size="10" value="1/6" /><br>
			<strong>P 7</strong>:Ethernet <input type="text" id="colleges8p7" name="colleges8p7" size="10" value="1/7" /><br>
			<strong>P 8</strong>:Ethernet <input type="text" id="colleges8p8" name="colleges8p8" size="10" value="1/8" /><br>
			<strong>P 9</strong>:Ethernet <input type="text" id="colleges8p9" name="colleges8p9" size="10" value="1/9" /><br>
			<strong>P10</strong>:Ethernet <input type="text" id="colleges8p10" name="colleges8p10" size="10" value="1/10" /><br>
			<strong>P11</strong>:Ethernet <input type="text" id="colleges8p11" name="colleges8p11" size="10" value="1/11" /><br>
			<strong>P12</strong>:Ethernet <input type="text" id="colleges8p12" name="colleges8p12" size="10" value="1/12" /><br>
			<strong>P13</strong>:Ethernet <input type="text" id="colleges8p13" name="colleges8p13" size="10" value="1/13" /><br>
			<strong>P14</strong>:Ethernet <input type="text" id="colleges8p14" name="colleges8p14" size="10" value="1/14" />
			</td>
			<td align="center" valign="center">DCRS-5750</td>
			<td align="center" valign="center">工装机</td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S9</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="colleges9ip" name="colleges9ip" value="172.18.100.153:10009" /></td>
			<td align="center" valign="center">
			<strong>P 3</strong>:Ethernet <input type="text" id="colleges9p3" name="colleges9p3" size="10" value="1/3" /><br>
			<strong>P 4</strong>:Ethernet <input type="text" id="colleges9p4" name="colleges9p4" size="10" value="1/4" /><br>
			<strong>P 5</strong>:Ethernet <input type="text" id="colleges9p5" name="colleges9p5" size="10" value="1/5" /><br>
			<strong>P 6</strong>:Ethernet <input type="text" id="colleges9p6" name="colleges9p6" size="10" value="1/6" /><br>
			<strong>P 7</strong>:Ethernet <input type="text" id="colleges9p7" name="colleges9p7" size="10" value="1/7" /><br>
			<strong>P 8</strong>:Ethernet <input type="text" id="colleges9p8" name="colleges9p8" size="10" value="1/8" /><br>
			<strong>P 9</strong>:Ethernet <input type="text" id="colleges9p9" name="colleges9p9" size="10" value="1/9" /><br>
			<strong>P10</strong>:Ethernet <input type="text" id="colleges9p10" name="colleges9p10" size="10" value="1/10" /><br>
			<strong>P11</strong>:Ethernet <input type="text" id="colleges9p11" name="colleges9p11" size="10" value="1/11" /><br>
			<strong>P12</strong>:Ethernet <input type="text" id="colleges9p12" name="colleges9p12" size="10" value="1/12" />
			</td>
			<td align="center" valign="center">DCRS-5750</td>
			<td align="center" valign="center">工装机</td>
		</tr>
 </tbody></table>
</div>	

<div id="financialEnv" name="financialEnv" align="center" style="display:none">
 <table border="1"><tbody>
		<tr>
			<th>金融环境</th>
			<th align="center" valign="center">连接设备</th>
			<th align="center" valign="center">测试端口</th>
			<th align="center" valign="center">设备型号</th>
			<th align="center" valign="center">说  明</th>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>IXIA</strong></td>
			<td align="center" valign="center"><strong>IP:</strong><input type="text" size="21" id="financialixia" name="financialixia" value="172.18.100.252" /></td>
			<td align="center" valign="center">
			<strong>Card1/Port1</strong>: <input type="text" id="financialtp1" name="financialtp1" size="10"  value="1/1" /><br>
			<strong>Card2/Port2</strong>: <input type="text" id="financialtp2" name="financialtp2" size="10"  value="1/4" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>APC</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="financialapc" name="financialapc" value="172.18.100.152:10008" /></td>
			<td align="center" valign="center">
			<strong>Port</strong>: <input type="text" id="financialapcport" name="financialapcport" size="10" value="8" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>PC</strong></td>
			<td align="center" valign="center">
			<strong>PC1:</strong><input type="text" size="21" id="financialpc1" name="financialpc1" value="172.18.100.168" /><br>
			<strong>PC2:</strong><input type="text" size="21" id="financialpc2" name="financialpc2" value="172.18.100.169" /></td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center">安装DCSM客户端，测试Dot1X功能</td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S1</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="financials1ip" name="financials1ip" value="172.18.100.152:10001" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="financials1p1" name="financials1p1" size="10" value="1/0/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="financials1p2" name="financials1p2" size="10" value="1/0/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="financials1p3" name="financials1p3" size="10" value="1/0/3" /><br>
			<strong>P 4</strong>:Ethernet <input type="text" id="financials1p4" name="financials1p4" size="10" value="1/0/4" /><br>
			<strong>P 5</strong>:Ethernet <input type="text" id="financials1p5" name="financials1p5" size="10" value="1/0/5" /><br>
			<strong>P 6</strong>:Ethernet <input type="text" id="financials1p6" name="financials1p6" size="10" value="1/0/6" /><br>
			<strong>P 7</strong>:Ethernet <input type="text" id="financials1p7" name="financials1p7" size="10" value="1/0/7" /><br>
			<strong>P 8</strong>:Ethernet <input type="text" id="financials1p8" name="financials1p8" size="10" value="1/0/8" /><br>
			<strong>P 9</strong>:Ethernet <input type="text" id="financials1p9" name="financials1p9" size="10" value="1/0/9" /><br>
			<strong>P10</strong>:Ethernet <input type="text" id="financials1p10" name="financials1p10" size="10" value="1/0/10" /><br>
			<strong>P11</strong>:Ethernet <input type="text" id="financials1p11" name="financials1p11" size="10" value="1/0/11" /><br>
			<strong>P12</strong>:Ethernet <input type="text" id="financials1p12" name="financials1p12" size="10" value="1/0/12" /><br>
			<strong>P13</strong>:Ethernet <input type="text" id="financials1p13" name="financials1p13" size="10" value="1/0/13" /><br>
			<strong>P14</strong>:Ethernet <input type="text" id="financials1p14" name="financials1p14" size="10" value="1/0/14" /><br>
			<strong>P15</strong>:Ethernet <input type="text" id="financials1p15" name="financials1p15" size="10" value="1/0/15" /><br>
			<strong>P16</strong>:Ethernet <input type="text" id="financials1p16" name="financials1p16" size="10" value="1/0/16" /><br>
			<strong>P17</strong>:Ethernet <input type="text" id="financials1p17" name="financials1p17" size="10" value="1/0/17" /><br>
			<strong>P18</strong>:Ethernet <input type="text" id="financials1p18" name="financials1p18" size="10" value="1/0/18" /><br>
			<strong>P1-18</strong>:Ethernet <input type="text" id="financials1p118" name="financials1p118" size="10" value="1/0/1-18" /><br>
			<strong>P19</strong>:Ethernet <input type="text" id="financials1p19" name="financials1p19" size="10" value="1/0/19" /><br>
			<strong>P21</strong>:Ethernet <input type="text" id="financials1p21" name="financials1p21" size="10" value="1/0/21" /><br>
			<strong>P22</strong>:Ethernet <input type="text" id="financials1p22" name="financials1p22" size="10" value="1/0/22" /><br>
			<strong>P23</strong>:Ethernet <input type="text" id="financials1p23" name="financials1p23" size="10" value="1/0/23" /><br>
			<strong>P25</strong>:Ethernet <input type="text" id="financials1p25" name="financials1p25" size="10" value="1/0/25" /><br>
			<strong>P26</strong>:Ethernet <input type="text" id="financials1p26" name="financials1p26" size="10" value="1/0/26" /><br>
			<strong>P36</strong>:Ethernet <input type="text" id="financials1p36" name="financials1p36" size="10" value="1/0/27" /><br>
			<strong>P47</strong>:Ethernet <input type="text" id="financials1p47" name="financials1p47" size="10" value="1/0/28" />
			</td>
			<td align="center" valign="center">{$gui->device_name}</td>
			<td align="center" valign="center">主测设备</td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S2</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="financials2ip" name="financials2ip" value="172.18.100.152:10002" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="financials2p1" name="financials2p1" size="10" value="1/0/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="financials2p2" name="financials2p2" size="10" value="1/0/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="financials2p3" name="financials2p3" size="10" value="1/0/3" /><br>
			<strong>P23</strong>:Ethernet <input type="text" id="financials2p23" name="financials2p23" size="10" value="1/0/23" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S3</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="financials3ip" name="financials3ip" value="172.18.100.152:10003" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="financials3p1" name="financials3p1" size="10" value="1/0/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="financials3p2" name="financials3p2" size="10" value="1/0/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="financials3p3" name="financials3p3" size="10" value="1/0/3" /><br>
			<strong>P14</strong>:Ethernet <input type="text" id="financials3p14" name="financials3p14" size="10" value="1/0/14" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S4</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="financials4ip" name="financials4ip" value="172.18.100.152:10004" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="financials4p1" name="financials4p1" size="10" value="1/0/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="financials4p2" name="financials4p2" size="10" value="1/0/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="financials4p3" name="financials4p3" size="10" value="1/0/3" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S5</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="financials5ip" name="financials5ip" value="172.18.100.152:10005" /></td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center">工装机DCRS-5750</td>
			<td align="center" valign="center">Ethernet1/1-18依次连接S1P1-18</td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S6</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="financials6ip" name="financials6ip" value="172.18.100.152:10006" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="financials6p1" name="financials6p1" size="10" value="1/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="financials6p2" name="financials6p2" size="10" value="1/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="financials6p3" name="financials6p3" size="10" value="1/3" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S7</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="financials7ip" name="financials7ip" value="172.18.100.152:10007" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="financials7p1" name="financials7p1" size="10" value="1/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="financials7p2" name="financials7p2" size="10" value="1/2" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
		</tr>
 </tbody></table>
</div>	

<div id="overseaEnv" name="overseaEnv" align="center" style="display:none">
 <table border="1"><tbody>
		<tr>
			<th>海外运营商</th>
			<th align="center" valign="center">连接设备</th>
			<th align="center" valign="center">测试端口</th>
			<th align="center" valign="center">设备型号</th>
			<th align="center" valign="center">说  明</th>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>IXIA</strong></td>
			<td align="center" valign="center"><strong>IP:</strong><input type="text" size="21" id="overseaixia" name="overseaixia" value="172.18.100.252" /></td>
			<td align="center" valign="center">
			<strong>Card1/Port1</strong>: <input type="text" id="overseatp1" name="overseatp1" size="10"  value="1/1" /><br>
			<strong>Card2/Port2</strong>: <input type="text" id="overseatp2" name="overseatp2" size="10"  value="1/3" /><br>
			<strong>Card3/Port3</strong>: <input type="text" id="overseatp3" name="overseatp3" size="10"  value="1/4" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>PC</strong></td>
			<td align="center" valign="center"><strong>IP:</strong><input type="text" size="21" id="overseapc" name="overseapc" value="172.18.100.170" /></td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center">安装DCSM客户端，用于Dot1X测试</td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S8</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="overseas8ip" name="overseas8ip" value="172.18.100.152:10016" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="overseas8p1" name="overseas8p1" size="10" value="1/0/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="overseas8p2" name="overseas8p2" size="10" value="1/0/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="overseas8p3" name="overseas8p3" size="10" value="1/0/3" /><br>
			<strong>P 4</strong>:Ethernet <input type="text" id="overseas8p4" name="overseas8p4" size="10" value="1/0/4" /><br>
			<strong>P 5</strong>:Ethernet <input type="text" id="overseas8p5" name="overseas8p5" size="10" value="1/0/5" /><br>
			<strong>P 6</strong>:Ethernet <input type="text" id="overseas8p6" name="overseas8p6" size="10" value="1/0/6" /><br>
			<strong>P 7</strong>:Ethernet <input type="text" id="overseas8p7" name="overseas8p7" size="10" value="1/0/7" /><br>
			<strong>P 8</strong>:Ethernet <input type="text" id="overseas8p8" name="overseas8p8" size="10" value="1/0/8" />
			</td>
			<td align="center" valign="center">{$gui->device_name}</td>
			<td align="center" valign="center">主测设备<br>S8P3测试VCT功能，请连接电口<br>S8P8无需连线，测试VCT请定义电口<br>S8P6-7自环</td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S9</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="overseas9ip" name="overseas9ip" value="172.18.100.152:10015" /></td>
			<td align="center" valign="center">
			<strong>P 1</strong>:Ethernet <input type="text" id="overseas9p1" name="overseas9p1" size="10" value="1/0/1" /><br>
			<strong>P 2</strong>:Ethernet <input type="text" id="overseas9p2" name="overseas9p2" size="10" value="1/0/2" /><br>
			<strong>P 3</strong>:Ethernet <input type="text" id="overseas9p3" name="overseas9p3" size="10" value="1/0/3" /><br>
			<strong>P 4</strong>:Ethernet <input type="text" id="overseas9p4" name="overseas9p4" size="10" value="1/0/4" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center">S9P3-4自环</td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S3</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="overseas3ip" name="overseas3ip" value="172.18.100.152:10013" /></td>
			<td align="center" valign="center">
			<strong>P 4</strong>:Ethernet <input type="text" id="overseas3p4" name="overseas3p4" size="10" value="1/0/4" /><br>
			<strong>P 5</strong>:Ethernet <input type="text" id="overseas3p5" name="overseas3p5" size="10" value="1/0/5" /><br>
			<strong>P 6</strong>:Ethernet <input type="text" id="overseas3p6" name="overseas3p6" size="10" value="1/0/6" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S4</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="overseas4ip" name="overseas4ip" value="172.18.100.152:10014" /></td>
			<td align="center" valign="center">
			<strong>P 4</strong>:Ethernet <input type="text" id="overseas4p4" name="overseas4p4" size="10" value="1/4" /><br>
			<strong>P 5</strong>:Ethernet <input type="text" id="overseas4p5" name="overseas4p5" size="10" value="1/5" />
			</td>
			<td align="center" valign="center"></td>
			<td align="center" valign="center"></td>
		</tr>
 </tbody></table>
</div>

<div id="performanceEnv" name="performanceEnv" align="center" style="display:none">
 <div id="performanceEnv1" name="performanceEnv1" align="center" style="display:none">
 <table border="1"><tbody>
		<tr>
			<th>拓扑1</th>
			<th align="center" valign="center">连接设备</th>
			<th align="center" valign="center">测试端口</th>
			<th align="center" valign="center">设备型号</th>
			<th align="center" valign="center">说  明</th>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>IXIA</strong></td>
			<td align="center" valign="center"><strong>I P:</strong><input type="text" size="21" id="performance1ixia" name="performance1ixia" value="172.18.100.252" /></td>
			<td align="center" valign="center">
			<strong>Port List</strong>:<br />
			<input type="text" id="performance1tp" name="performance1tp" size="31"  value="1/1;1/2;1/3" />
			</td>
			<td align="center" valign="center">&nbsp</td>
			<td align="center" valign="center">Port List:多个IXIA端口</br >请依次以;隔开填写</td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S1</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="performance1s1ip" name="performance1s1ip" value="172.18.100.252:10001" /></td>
			<td align="center" valign="center">
			<strong>Port List</strong>:<br /><input type="text" id="performance1s1port" name="performance1s1port" size="31"  value="1/0/1;1/0/2;1/0/3" />
			</td>
			<td align="center" valign="center">{$gui->device_name}</td>
			<td align="center" valign="center">Port List:多个S1端口</br >请依次以;隔开填写</td>
		</tr>
		<tr><td colspan='5'>&nbsp</td></tr>
		<tr>
			<td align="center" valign="center"><strong>测试设定</strong></td>
			<td align="center" valign="center">
			<strong>TestTrial:</strong><input type="text" size="5" id="performance1trial" name="performance1trial" value="3" /><br />
			<strong>Interval :</strong><input type="text" size="5" id="performance1interval" name="performance1interval" value="5" /><br />
			<strong>DebugON:</strong><input type="text" size="5" id="performance1debug" name="performance1debug" value="0" />
			</td>
			<td align="center" valign="center" colspan='3'>TestTrial:脚本测试次数;<br />Interval:脚本检查CPU/MEM使用率时间间隔(单位秒);<br />Debug ON:0-不开启|1-开启Debug;</td>
		</tr>
 </tbody></table>
 </div>
 
 <div id="performanceEnv2" name="performanceEnv2" align="center" style="display:none">
 <table border="1"><tbody>
		<tr>
			<th>拓扑2</th>
			<th align="center" valign="center">连接设备</th>
			<th align="center" valign="center">测试端口</th>
			<th align="center" valign="center">设备型号</th>
			<th align="center" valign="center">说  明</th>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>IXIA</strong></td>
			<td align="center" valign="center"><strong>I P:</strong><input type="text" size="21" id="performance2ixia" name="performance2ixia" value="172.18.100.252" /></td>
			<td align="center" valign="center">
			<strong>Port Number</strong>:
			<input type="text" id="performance2tpnum" name="performance2tpnum" size="5"  value="1" />
			<br />
			<strong>PortList</strong>:
			<input type="text" id="performance2tp" name="performance2tp" size="21"  value="1/1" />
			</td>
			<td align="center" valign="center">&nbsp</td>
			<td align="center" valign="center">每板卡连接一个测试仪端口</br >请根据板卡数量填写以;隔开</br >同时须修改PortNumber</td>
		</tr>
		<tr>
			<td align="center" valign="center"><strong>S1</strong></td>
			<td align="center" valign="center"><strong>CCM:</strong><input type="text" size="21" id="performance2s1ip" name="performance2s1ip" value="172.18.100.252:10001" /></td>
			<td align="center" valign="center">
			<strong>Port List</strong>:<br /><input type="text" id="performance2s1port" name="performance2s1port" size="31"  value="1/0/1" />
			</td>
			<td align="center" valign="center">{$gui->device_name}</td>
			<td align="center" valign="center">每板卡使用一个端口测试</br >请根据板卡数量填写<br />依次以;隔开</td>
		</tr>
		<tr><td colspan='5'>&nbsp</td></tr>
		<tr>
			<td align="center" valign="center"><strong>测试设定</strong></td>
			<td align="center" valign="center">
			<strong>TestTrial:</strong><input type="text" size="5" id="performance2trial" name="performance2trial" value="3" /><br />
			<strong>Interval :</strong><input type="text" size="5" id="performance2interval" name="performance2interval" value="5" /><br />
			<strong>DebugON:</strong><input type="text" size="5" id="performance2debug" name="performance2debug" value="0" />
			</td>
			<td align="center" valign="center" colspan='3'>TestTrial:脚本测试次数;<br />Interval:脚本检查CPU/MEM使用率时间间隔(单位秒);<br />Debug ON:0-不开启|1-开启Debug;</td>
		</tr>
 </tbody></table>
 </div>
 
 <div align="center"><input type="button" onclick="showPerformanceAdv();" value="显示/隐藏高级参数" ></div> 
</div>
<div id="performanceAdv" align="center" style="display:none;">
 <table border="1"><tbody>
		<tr>
			<th align="center" valign="center">性<br />能<br />参<br />数<br />微<br />调</th>
			<td align="center" valign="center"><textarea cols=120 rows=10 name='par_detail' id='par_detail'></textarea></td>
		</tr>
</tbody></table>
</div>

<div id='cmdautoEnv' align="center" style="display:none">
 <table border="1"><tbody>
		<tr>
			<th align="center" valign="center">连接设备</th>
			<td align="center"><input type="text" size="21" name="cmdautos1ip" id="cmdautos1ip" value="172.17.100.x:10001" /></td>
		</tr>
	</tbody></table>
</div>

<div id='memorytestEnv' align="center" style="display:none">
 <table border="1"><tbody>
		<tr>
			<th align="center" valign="center">连接设备</th>
			<td align="center"><input type="text" size="21" name="memorytests1ip" id="memorytests1ip" value="172.17.100.x:10001" /></td>
		</tr>
		<tr>
			<th align="center" valign="center">测<br />试<br />参<br />数</th>
			<td align="center" valign="center"><textarea cols=120 rows=10 name='memorytestdetails' id='memorytestdetails'>runTimes = 100 #脚本执行runTimes次后停止
interval = 5 #执行命令组interval次后检查一次内存
waittime1 = 2 #执行组各命令之间间隔(秒)
waittime2 = 2 #执行命令组后等待waittime2秒查询内存
#测试命令组，可添加/删除，格式为commandlist.append(['命令提示符|enable or config or current','命令行'])
commandlist = []
commandlist.append(['enable','show run'])
#commandlist.append(['config','show version'])
#commandlist.append(['current','show xxx'])</textarea></td>
		</tr>
	</tbody></table>
</div>

</div>
</form>
{/if}

{if $gui->productline_id == 2} {* 无线产品线测试 *}
<form name=wirelessrunform action="/lib/execute/jobsWaffirmRun.php" method="post" onsubmit="javascript:return checkInput_wireless();">

<div id="affirmWirelessEnvSelect" name="affirmWirelessEnvSelect">选择无线固定测试环境<select id="affirmWirelessEnvSel" name='affirmWirelessEnvSel'>
		<option value='0'>请选择执行环境</option>
		<option value='1'>北京第一套环境</option>
		<option value='2'>北京第二套环境</option>
		<option value='3'>北京第三套环境</option>
        <option value='4'>北京第四套环境(云AC)</option>
		</select>
</div>

<div id="wireless_submit" name="wireless_submit" align="center" style="display:none">
<hr>
<input type="submit" name="wirelesssubmit" id="wirelesssubmit" value="猛击开始测试" />
<hr>
</div>


<div id="affirmWirelessEnv" name="affirmWirelessEnv" align="center" style="display:none">
 <table border="1"><tbody>
		<tr>
			<th>&nbsp</th>
			<th align="center" valign="center">连接设备</th>
			<th align="center" valign="center">测试端口</th>
			<th align="center" valign="center">设备型号</th>
			<th align="center" valign="center">说  明</th>
		</tr>
		<tr>
			<td align="center" valign="center">AC1</td>
			<td align="center" valign="center"><strong>IP</strong>:<input type="text" id="waffirms1ip" name="waffirms1ip" size="21" /></input></td>
			<td align="center" valign="center"><strong>S1P1</strong>:Ethernet <input type="text" id="waffirms1p1" name="waffirms1p1" size="10" /></td>
			<td align="center" valign="center"><strong>型号</strong>:<input type="text" id="waffirms1name" name="waffirms1name" size="21" value="DCWS-6028" /></td>
			<td>&nbsp</td>
		</tr>
		<tr>
			<td align="center" valign="center">AC2</td>
			<td align="center" valign="center"><strong>IP</strong>:<input type="text" size="21" id="waffirms2ip" name="waffirms2ip" /></td>
			<td align="center" valign="center"><strong>S2P1</strong>:Ethernet <input type="text" id="waffirms2p1" name="waffirms2p1" size="10" /></td>
			<td align="center" valign="center"><strong>型号</strong>:<input type="text" id="waffirms2name" name="waffirms2name" size="21" value="DCWS-6028" /></td>
			<td>&nbsp</td>
		</tr>
		<tr>
			<td align="center" valign="center">S3</td>
			<td align="center" valign="center"><strong>IP</strong>:<input type="text" size="21" id="waffirms3ip" name="waffirms3ip" /></td>
				<td align="center" valign="center">
				<strong>S3P1</strong>:Ethernet <input type="text" id="waffirms3p1" name="waffirms3p1" size="10" /><br>
				<strong>S3P2</strong>:Ethernet <input type="text" id="waffirms3p2" name="waffirms3p2" size="10" /><br>
				<strong>S3P3</strong>:Ethernet <input type="text" id="waffirms3p3" name="waffirms3p3" size="10" /><br>
				<strong>S3P4</strong>:Ethernet <input type="text" id="waffirms3p4" name="waffirms3p4" size="10" /><br>
				<strong>S3P5</strong>:Ethernet <input type="text" id="waffirms3p5" name="waffirms3p5" size="10" /><br>
				<strong>S3P6</strong>:Ethernet <input type="text" id="waffirms3p6" name="waffirms3p6" size="10" />
			</td>
			<td align="center" valign="center"><strong>型号</strong>:<input type="text" id="waffirms3name" name="waffirms3name" size="21" value="DCRS-5950-52T" /></td>
			<td><p align="center" valign="center">默认配置是所选环境的固定配置<br />若无修改请使用默认值</p></td>
		</tr>
		<tr></tr>
		<tr>
			<td align="center" valign="center">服务器PC1</td>
			<td align="center" valign="center"><strong>IP</strong>:<input type="text" size="21" id="waffirmpc1" name="waffirmpc1" /></td>
			<td>&nbsp</td>
			<td>Linux Server</td>
			<td>包括DHCP、Radius、AP模拟器等</td>
		</tr>
		<tr>
		    <td align="center" valign="center">Tester_Wired</td>
			<td align="center" valign="center"><strong>IP</strong>:<input type="text" size="21" id="waffirmtester" name="waffirmtester" /></td>
			<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td>
		</tr>
        <tr>
			<td align="center" valign="center">STA1</td>
			<td align="center" valign="center"><strong>IP</strong>:<input type="text" id="waffirmsta1" name="waffirmsta1" size="21" /></td>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td>
         </tr>
         <tr>
            <td align="center" valign="center">STA2</td>
			<td align="center" valign="center"><strong>IP</strong>:<input type="text" id="waffirmsta2" name="waffirmsta2" size="21" /></td>
            <td>&nbsp</td><td>&nbsp</td><td>&nbsp</td>
         </tr>
         <tr>
            <td align="center" valign="center">AP1</td>
			<td align="center" valign="center"><strong>IP</strong>:<input type="text" id="waffirmap1" name="waffirmap1" size="21" /></td>
            <td>&nbsp</td>
            <td align="center" valign="center"><strong>型号</strong>:<input type="text" id="waffirmap1name" name="waffirmap1name" size="21" value="DCWL-7942AP(R4)" /></td>
			<td>&nbsp</td>
         </tr>
         <tr>
            <td align="center" valign="center">AP2</td>
			<td align="center" valign="center"><strong>IP</strong>:<input type="text" id="waffirmap2" name="waffirmap2" size="21" /></td>
            <td>&nbsp</td>
            <td align="center" valign="center"><strong>型号</strong>:<input type="text" id="waffirmap2name" name="waffirmap2name" size="21" value="DCWL-7942AP(R4)" /></td>
			<td>&nbsp</td>
         </tr>
	</tbody></table>
</div>

</div>
</form>

{/if}
</body>
</html>