<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?} else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql); $filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="01-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); 
if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];}else{$formato_presup="XX-XX-XX-XXX-XX-XX-XX";$formato_cat="XX-XX-XX";}
$len_cat=strlen($formato_cat);  $len_cod=strlen($formato_presup);
if (!$_GET){$cod_presup=''; $cod_fuente='00'; $p_letra=''; $sql="SELECT * FROM codigos order by cod_presup,cod_fuente";}
else {$codigo = $_GET["Gcodigo"]; $p_letra=substr($codigo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_fuente=substr($codigo,1,2);$cod_presup=substr($codigo,3,32);}
   else{$cod_fuente=substr($codigo,0,2);$cod_presup=substr($codigo,2,32);}  $codigo=$cod_presup.$cod_fuente;
  $sql="Select * from codigos where cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";
  if ($p_letra=="P"){$sql="SELECT * FROM codigos order by cod_presup,cod_fuente";}
  if ($p_letra=="U"){$sql="SELECT * From codigos order by cod_presup desc,cod_fuente desc";}
  if ($p_letra=="S"){$sql="SELECT * From codigos Where (cod_presup>'$cod_presup') order by cod_presup,cod_fuente";}
  if ($p_letra=="A"){$sql="SELECT * From codigos Where (cod_presup<'$cod_presup') order by cod_presup desc";}
}
//echo $Cod_Emp;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (C&oacute;ndigos/Asignaci&oacute;nn)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_codigos(){  document.form2.submit(); }

function Llamar_Cargar(url,lcat){var murl;
var Gcod_presup=document.form1.txtcod_fuente.value+document.form1.txtcod_presup.value;
  if(document.form1.txtcod_presup.value.length==lcat){murl=url+Gcod_presup;document.location = murl;}
    else{alert('Longitud de Categoria Invalida');}
}
function Llamar_Ventana(url){var murl;
var Gcod_presup=document.form1.txtcod_fuente.value+document.form1.txtcod_presup.value;
    murl=url+Gcod_presup;  document.location = murl;
}

function Llamar_Distribucion(url,lcod){var murl;
var Gcod_presup=document.form1.txtcod_fuente.value+document.form1.txtcod_presup.value; 
	if(document.form1.txtcod_presup.value.length==lcod){murl=url+Gcod_presup;  document.location = murl;}
    else{alert('Longitud de Codigo Invalida');}
}
function Mover_Registro(MPos){ var murl;
   murl="Act_codigos.php";
   if(MPos=="P"){murl="Act_codigos.php?Gcodigo=P"}
   if(MPos=="U"){murl="Act_codigos.php?Gcodigo=U"}
   if(MPos=="S"){murl="Act_codigos.php?Gcodigo=S"+document.form1.txtcod_fuente.value+document.form1.txtcod_presup.value;}
   if(MPos=="A"){murl="Act_codigos.php?Gcodigo=A"+document.form1.txtcod_fuente.value+document.form1.txtcod_presup.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r; var mcod_pre=document.form1.txtcod_presup.value; var mcod_fuente=document.form1.txtcod_fuente.value;
  r=confirm("Esta seguro en Eliminar el Condigo Presupuestario:"+mcod_pre+" Fuente: "+mcod_fuente+"  ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el C&oacute;ndigo Presupuestario :"+mcod_pre+" Fuente: "+mcod_fuente+" ?");
    if (r==true) { url="Delete_codigos.php?Gcodigo="+document.form1.txtcod_fuente.value+document.form1.txtcod_presup.value;
       VentanaCentrada(url,'Eliminar C&oacute;ndigo Presupuestario','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
}
function Llamar_Consulta_disp(url,lcod){var murl;
var Gcod_presup=document.form1.txtcod_fuente.value+document.form1.txtcod_presup.value;
  if(document.form1.txtcod_presup.value.length==lcod){murl=url+Gcod_presup; window.open(murl);}
    else{alert('Longitud de Codigo Invalida');}
}
</script>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>

</head>
<?
$denominacion="";$des_fuente="";$cod_contable="";$nombre_cuenta="";$status_dist="";$func_inv="";$aplicacion="";$distribucion="ANUAL";
$asignado=0;$disponible=0;$diferido=0;$disp_diferida=0;$montod=0;$tasignado=0;$tcompromiso=0;$tcausado=0;$tpagos=0;$tdiferidos=0;$ttraslados=0;$ttrasladon=0;$tadicion=0; $tdisminucion=0;
$asignado01=0;$compromiso01=0;$causado01=0;$pagos01=0;$diferidos01=0;$traslados01=0;$trasladon01=0;$adicion01=0;$disminucion01=0;$disponible01=0;
$asignado02=0;$compromiso02=0;$causado02=0;$pagos02=0;$diferidos02=0;$traslados02=0;$trasladon02=0;$adicion02=0;$disminucion02=0;$disponible02=0;
$asignado03=0;$compromiso03=0;$causado03=0;$pagos03=0;$diferidos03=0;$traslados03=0;$trasladon03=0;$adicion03=0;$disminucion03=0;$disponible03=0;
$asignado04=0;$compromiso04=0;$causado04=0;$pagos04=0;$diferidos04=0;$traslados04=0;$trasladon04=0;$adicion04=0;$disminucion04=0;$disponible04=0;
$asignado05=0;$compromiso05=0;$causado05=0;$pagos05=0;$diferidos05=0;$traslados05=0;$trasladon05=0;$adicion05=0;$disminucion05=0;$disponible05=0;
$asignado06=0;$compromiso06=0;$causado06=0;$pagos06=0;$diferidos06=0;$traslados06=0;$trasladon06=0;$adicion06=0;$disminucion06=0;$disponible06=0;
$asignado07=0;$compromiso07=0;$causado07=0;$pagos07=0;$diferidos07=0;$traslados07=0;$trasladon07=0;$adicion07=0;$disminucion07=0;$disponible07=0;
$asignado08=0;$compromiso08=0;$causado08=0;$pagos08=0;$diferidos08=0;$traslados08=0;$trasladon08=0;$adicion08=0;$disminucion08=0;$disponible08=0;
$asignado09=0;$compromiso09=0;$causado09=0;$pagos09=0;$diferidos09=0;$traslados09=0;$trasladon09=0;$adicion09=0;$disminucion09=0;$disponible09=0;
$asignado10=0;$compromiso10=0;$causado10=0;$pagos10=0;$diferidos10=0;$traslados10=0;$trasladon10=0;$adicion10=0;$disminucion10=0;$disponible10=0;
$asignado11=0;$compromiso11=0;$causado11=0;$pagos11=0;$diferidos11=0;$traslados11=0;$trasladon11=0;$adicion11=0;$disminucion11=0;$disponible11=0;
$asignado12=0;$compromiso12=0;$causado12=0;$pagos12=0;$diferidos12=0;$traslados12=0;$trasladon12=0;$adicion12=0;$disminucion12=0;$disponible12=0;
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From codigos Order by cod_presup,cod_fuente";} if ($p_letra=="A"){$sql="SELECT * From codigos Order by cod_presup desc";}$res=pg_query($sql); $filas=pg_num_rows($res); }
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];   $cod_contable=$registro["cod_contable"];
  $func_inv=$registro["func_inv"];   $aplicacion=$registro["aplicacion"];    $status_dist=$registro["status_dist"];    $asignado=$registro["asignado"];
  $disponible=formato_monto($registro["disponible"]);   $diferido=$registro["diferido"];   $disp_diferida=formato_monto($registro["disp_diferida"]);
  $des_fuente=$registro["des_fuente_financ"];  $nombre_cuenta=$registro["nombre_cuenta"];
  $asignado01=formato_monto($registro["asignado01"]);  $asignado02=formato_monto($registro["asignado02"]);  $asignado03=formato_monto($registro["asignado03"]);  $asignado04=formato_monto($registro["asignado04"]);
  $asignado05=formato_monto($registro["asignado05"]);  $asignado06=formato_monto($registro["asignado06"]);  $asignado07=formato_monto($registro["asignado07"]);  $asignado08=formato_monto($registro["asignado08"]);
  $asignado09=formato_monto($registro["asignado09"]);  $asignado10=formato_monto($registro["asignado10"]);   $asignado11=formato_monto($registro["asignado11"]);  $asignado12=formato_monto($registro["asignado12"]);
  $compromiso01=formato_monto($registro["compromiso01"]); $compromiso02=formato_monto($registro["compromiso02"]); $compromiso03=formato_monto($registro["compromiso03"]);
  $compromiso04=formato_monto($registro["compromiso04"]); $compromiso05=formato_monto($registro["compromiso05"]); $compromiso06=formato_monto($registro["compromiso06"]);
  $compromiso07=formato_monto($registro["compromiso07"]); $compromiso08=formato_monto($registro["compromiso08"]); $compromiso09=formato_monto($registro["compromiso09"]);
  $compromiso10=formato_monto($registro["compromiso10"]); $compromiso11=formato_monto($registro["compromiso11"]); $compromiso12=formato_monto($registro["compromiso12"]);
  $causado01=formato_monto($registro["causado01"]); $causado02=formato_monto($registro["causado02"]); $causado03=formato_monto($registro["causado03"]); 
  $causado04=formato_monto($registro["causado04"]); $causado05=formato_monto($registro["causado05"]); $causado06=formato_monto($registro["causado06"]);
  $causado07=formato_monto($registro["causado07"]); $causado08=formato_monto($registro["causado08"]); $causado09=formato_monto($registro["causado09"]); 
  $causado10=formato_monto($registro["causado10"]); $causado11=formato_monto($registro["causado11"]); $causado12=formato_monto($registro["causado12"]);
  $pagos01=formato_monto($registro["pagado01"]); $pagos02=formato_monto($registro["pagado02"]); $pagos03=formato_monto($registro["pagado03"]);
  $pagos04=formato_monto($registro["pagado04"]); $pagos05=formato_monto($registro["pagado05"]); $pagos06=formato_monto($registro["pagado06"]);
  $pagos07=formato_monto($registro["pagado07"]); $pagos08=formato_monto($registro["pagado08"]); $pagos09=formato_monto($registro["pagado09"]);
  $pagos10=formato_monto($registro["pagado10"]); $pagos11=formato_monto($registro["pagado11"]); $pagos12=formato_monto($registro["pagado12"]);
  $diferidos01=formato_monto($registro["diferido01"]); $diferidos02=formato_monto($registro["diferido02"]); $diferidos03=formato_monto($registro["diferido03"]);
  $diferidos04=formato_monto($registro["diferido04"]); $diferidos05=formato_monto($registro["diferido05"]); $diferidos06=formato_monto($registro["diferido06"]);
  $diferidos07=formato_monto($registro["diferido07"]); $diferidos08=formato_monto($registro["diferido08"]); $diferidos09=formato_monto($registro["diferido09"]);
  $diferidos10=formato_monto($registro["diferido10"]); $diferidos11=formato_monto($registro["diferido11"]); $diferidos12=formato_monto($registro["diferido12"]);
  $traslados01=formato_monto($registro["traslados01"]); $traslados02=formato_monto($registro["traslados02"]); $traslados03=formato_monto($registro["traslados03"]);
  $traslados04=formato_monto($registro["traslados04"]); $traslados05=formato_monto($registro["traslados05"]); $traslados06=formato_monto($registro["traslados06"]);
  $traslados07=formato_monto($registro["traslados07"]); $traslados08=formato_monto($registro["traslados08"]); $traslados09=formato_monto($registro["traslados09"]);
  $traslados10=formato_monto($registro["traslados10"]); $traslados11=formato_monto($registro["traslados11"]); $traslados12=formato_monto($registro["traslados12"]);
  $trasladon01=formato_monto($registro["trasladon01"]); $trasladon02=formato_monto($registro["trasladon02"]); $trasladon03=formato_monto($registro["trasladon03"]);
  $trasladon04=formato_monto($registro["trasladon04"]); $trasladon05=formato_monto($registro["trasladon05"]); $trasladon06=formato_monto($registro["trasladon06"]);
  $trasladon07=formato_monto($registro["trasladon07"]); $trasladon08=formato_monto($registro["trasladon08"]); $trasladon09=formato_monto($registro["trasladon09"]);
  $trasladon10=formato_monto($registro["trasladon10"]); $trasladon11=formato_monto($registro["trasladon11"]); $trasladon12=formato_monto($registro["trasladon12"]);
  $adicion01=formato_monto($registro["adicion01"]); $adicion02=formato_monto($registro["adicion02"]); $adicion03=formato_monto($registro["adicion03"]);
  $adicion04=formato_monto($registro["adicion04"]); $adicion05=formato_monto($registro["adicion05"]); $adicion06=formato_monto($registro["adicion06"]);
  $adicion07=formato_monto($registro["adicion07"]); $adicion08=formato_monto($registro["adicion08"]); $adicion09=formato_monto($registro["adicion09"]);
  $adicion10=formato_monto($registro["adicion10"]); $adicion11=formato_monto($registro["adicion11"]); $adicion12=formato_monto($registro["adicion12"]);
  $disminucion01=formato_monto($registro["disminucion01"]); $disminucion02=formato_monto($registro["disminucion02"]); $disminucion03=formato_monto($registro["disminucion03"]);
  $disminucion04=formato_monto($registro["disminucion04"]); $disminucion05=formato_monto($registro["disminucion05"]); $disminucion06=formato_monto($registro["disminucion06"]);
  $disminucion07=formato_monto($registro["disminucion07"]); $disminucion08=formato_monto($registro["disminucion08"]); $disminucion09=formato_monto($registro["disminucion09"]);
  $disminucion10=formato_monto($registro["disminucion10"]); $disminucion11=formato_monto($registro["disminucion11"]); $disminucion12=formato_monto($registro["disminucion12"]);
  $montod=$montod+$registro["asignado01"]-$registro["compromiso01"]+$registro["traslados01"]-$registro["trasladon01"]+$registro["adicion01"]-$registro["disminucion01"];
  $disponible01=formato_monto($montod);
  $montod=$montod+$registro["asignado02"]-$registro["compromiso02"]+$registro["traslados02"]-$registro["trasladon02"]+$registro["adicion02"]-$registro["disminucion02"];
  $disponible02=formato_monto($montod);
  $montod=$montod+$registro["asignado03"]-$registro["compromiso03"]+$registro["traslados03"]-$registro["trasladon03"]+$registro["adicion03"]-$registro["disminucion03"];
  $disponible03=formato_monto($montod);
  $montod=$montod+$registro["asignado04"]-$registro["compromiso04"]+$registro["traslados04"]-$registro["trasladon04"]+$registro["adicion04"]-$registro["disminucion04"];
  $disponible04=formato_monto($montod);
  $montod=$montod+$registro["asignado05"]-$registro["compromiso05"]+$registro["traslados05"]-$registro["trasladon05"]+$registro["adicion05"]-$registro["disminucion05"];
  $disponible05=formato_monto($montod);
  $montod=$montod+$registro["asignado06"]-$registro["compromiso06"]+$registro["traslados06"]-$registro["trasladon06"]+$registro["adicion06"]-$registro["disminucion06"];
  $disponible06=formato_monto($montod);
  $montod=$montod+$registro["asignado07"]-$registro["compromiso07"]+$registro["traslados07"]-$registro["trasladon07"]+$registro["adicion07"]-$registro["disminucion07"];
  $disponible07=formato_monto($montod);
  $montod=$montod+$registro["asignado08"]-$registro["compromiso08"]+$registro["traslados08"]-$registro["trasladon08"]+$registro["adicion08"]-$registro["disminucion08"];
  $disponible08=formato_monto($montod);
  $montod=$montod+$registro["asignado09"]-$registro["compromiso09"]+$registro["traslados09"]-$registro["trasladon09"]+$registro["adicion09"]-$registro["disminucion09"];
  $disponible09=formato_monto($montod);
  $montod=$montod+$registro["asignado10"]-$registro["compromiso10"]+$registro["traslados10"]-$registro["trasladon10"]+$registro["adicion10"]-$registro["disminucion10"];
  $disponible10=formato_monto($montod);
  $montod=$montod+$registro["asignado11"]-$registro["compromiso11"]+$registro["traslados11"]-$registro["trasladon11"]+$registro["adicion11"]-$registro["disminucion11"];
  $disponible11=formato_monto($montod);
  $montod=$montod+$registro["asignado12"]-$registro["compromiso12"]+$registro["traslados12"]-$registro["trasladon12"]+$registro["adicion12"]-$registro["disminucion12"];
  $disponible12=formato_monto($montod);
  $tasignado=$registro["asignado01"]+$registro["asignado02"]+$registro["asignado03"]+$registro["asignado04"]+$registro["asignado05"]+$registro["asignado06"]+$registro["asignado07"]+$registro["asignado08"]+$registro["asignado09"]+$registro["asignado10"]+$registro["asignado11"]+$registro["asignado12"];
  $tcompromiso=$registro["compromiso01"]+$registro["compromiso02"]+$registro["compromiso03"]+$registro["compromiso04"]+$registro["compromiso05"]+$registro["compromiso06"]+$registro["compromiso07"]+$registro["compromiso08"]+$registro["compromiso09"]+$registro["compromiso10"]+$registro["compromiso11"]+$registro["compromiso12"];
  $tcausado=$registro["causado01"]+$registro["causado02"]+$registro["causado03"]+$registro["causado04"]+$registro["causado05"]+$registro["causado06"]+$registro["causado07"]+$registro["causado08"]+$registro["causado09"]+$registro["causado10"]+$registro["causado11"]+$registro["causado12"];
  $tpagos=$registro["pagado01"]+$registro["pagado02"]+$registro["pagado03"]+$registro["pagado04"]+$registro["pagado05"]+$registro["pagado06"]+$registro["pagado07"]+$registro["pagado08"]+$registro["pagado09"]+$registro["pagado10"]+$registro["pagado11"]+$registro["pagado12"];
  $tdiferidos=$registro["diferido01"]+$registro["diferido02"]+$registro["diferido03"]+$registro["diferido04"]+$registro["diferido05"]+$registro["diferido06"]+$registro["diferido07"]+$registro["diferido08"]+$registro["diferido09"]+$registro["diferido10"]+$registro["diferido11"]+$registro["diferido12"];
  $ttraslados=$registro["traslados01"]+$registro["traslados02"]+$registro["traslados03"]+$registro["traslados04"]+$registro["traslados05"]+$registro["traslados06"]+$registro["traslados07"]+$registro["traslados08"]+$registro["traslados09"]+$registro["traslados10"]+$registro["traslados11"]+$registro["traslados12"];
  $ttrasladon=$registro["trasladon01"]+$registro["trasladon02"]+$registro["trasladon03"]+$registro["trasladon04"]+$registro["trasladon05"]+$registro["trasladon06"]+$registro["trasladon07"]+$registro["trasladon08"]+$registro["trasladon09"]+$registro["trasladon10"]+$registro["trasladon11"]+$registro["trasladon12"];
  $tadicion=$registro["adicion01"]+$registro["adicion02"]+$registro["adicion03"]+$registro["adicion04"]+$registro["adicion05"]+$registro["adicion06"]+$registro["adicion07"]+$registro["adicion08"]+$registro["adicion09"]+$registro["adicion10"]+$registro["adicion11"]+$registro["adicion12"];
  $tdisminucion=$registro["disminucion01"]+$registro["disminucion02"]+$registro["disminucion03"]+$registro["disminucion04"]+$registro["disminucion05"]+$registro["disminucion06"]+$registro["disminucion07"]+$registro["disminucion08"]+$registro["disminucion09"]+$registro["disminucion10"]+$registro["disminucion11"]+$registro["disminucion12"];
}
$asignado=formato_monto($asignado); $tasignado=formato_monto($tasignado);$tcompromiso=formato_monto($tcompromiso);$tcausado=formato_monto($tcausado);
$tpagos=formato_monto($tpagos);$tdiferidos=formato_monto($tdiferidos);$ttraslados=formato_monto($ttraslados); $ttrasladon=formato_monto($ttrasladon);
$tadicion=formato_monto($tadicion); $tdisminucion=formato_monto($tdisminucion);
if($status_dist=='1'){$distribucion="ANUAL";}if($status_dist=='2'){$distribucion="MENSUAL";}
if($status_dist=='3'){$distribucion="TRIMESTRAL";}if($status_dist=='4'){$distribucion="TRIMESTRAL (%)";}
if($func_inv=="I"){$func_inv="INVERSION";}else{$func_inv="CORRIENTE";}
$formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $titulo=""; $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$titulo=$registro["campo525"];}
$len_cod=strlen($cod_presup);  $len_formato=strlen($formato_presup);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">C&Oacute;DIGOS PRESUPUESTARIOS/ASIGNACI&Oacute;N </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="535" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="531" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
	  <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_codigos()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_codigos()">Incluir</A></td>
      </tr>
	  <?}if ($Mcamino{2}=="S"){?>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cons_codigos.php?cod_fuente=<? echo $cod_fuente; ?>&cod_presup=<? echo $cod_presup; ?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cons_codigos.php?cod_fuente=<? echo $cod_fuente; ?>&cod_presup=<? echo $cod_presup; ?>" class="menu">Consultar</a></td>
        </tr>	
	  <?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_codigos.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_codigos.php?Gcodigo=');">Modificar</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Distribucion('Dist_codigos.php?Gcodigo=','<? echo $len_cod; ?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Distribucion('Dist_codigos.php?Gcodigo=','<? echo $len_cod; ?>');">Distribuir</A></td>
      </tr>
	  <?} if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_codigos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_codigos.php" class="menu">Catalogo</a></td>
  </tr>
   <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
  </tr>
  </tr>
   <?} if (($Mcamino{11}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Cargar('Borrar_cod_carga.php?codigo=<? echo $SIA_Definicion; ?>','<? echo $len_cat; ?>');"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Cargar('Borrar_cod_carga.php?codigo=<? echo $SIA_Definicion; ?>','<? echo $len_cat; ?>');" class="menu">Cargar</a></td>
  </tr>
  <?} if ($Mcamino{10}=="S"){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Consulta_disp('Consulta_dispon.php?Gcodigo=','<? echo $len_cod; ?>');" class="menu">Consulta Disponibilidad</a></td>
  </tr>
  <?} if (($Mcamino{1}=="S")and($Cod_Emp=="99") and($len_cod==$len_formato)){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Cambia_codigos.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Cambia_codigos.php?Gcodigo=');">Cambiar Codigo</A></td>
      </tr>
		
  <?} ?>
  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Ventana_002('/sia/presupuesto/ayuda/ayuda_codigos_asig.htm','Ayuda SIA','','1000','1000','true');";
				  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Ventana_002('/sia/presupuesto/ayuda/ayuda_codigos_asig.htm','Ayuda SIA','','1000','1000','true');" class="menu">Ayuda </a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:495px; z-index:1; top: 62px; left: 113px;">
            <form name="form1" method="post">
        <table width="861" border="0" align="center">
            <tr>
              <td><table width="854" border="0">
                <tr>
                  <td width="180"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                  <td width="222"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" value="<?echo $cod_presup?>" size="34" maxlength="34" readonly>  </span></td>
                  <td width="115"><span class="Estilo5">FUENTE FINANC. :</span></td>
                  <td width="33"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" value="<?echo $cod_fuente?>" size="3" maxlength="2" readonly>   </span></td>
                  <td width="282"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" value="<?echo $des_fuente?>" size="38" readonly>    </span></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="849" border="0">
                <tr>
                  <td width="109"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                  <td width="730"><textarea name="txtdenominacion" cols="84" readonly="readonly" class="headers" id="txtdenominacion"><?echo $denominacion?></textarea></td>
                </tr>
              </table>  </td>
            </tr>
            <tr>
              <td ><table width="848" border="0">
                <tr>
                  <td width="168"><span class="Estilo5">C&Oacute;DIGO CONTABLE GASTO:</span></td>
                  <td width="179"><span class="Estilo5"><input class="Estilo10" name="txtcod_contable" type="text" id="txtcod_contable" value="<?echo $cod_contable?>" size="25" readonly>  </span></td>
                  <td width="487"><span class="Estilo5"><input class="Estilo10" name="txtnombre_cuenta" type="text" id="txtnombre_cuenta" value="<?echo $nombre_cuenta?>" size="70" readonly>  </span></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td ><table width="848" border="0">
                <tr>
                  <td width="111"><span class="Estilo5">TIPO DE GASTO :</span> </td>
                  <td width="174"><span class="Estilo5"><input class="Estilo10" name="txtTipo_Gasto" type="text" id="txtTipo_Gasto" size="15" maxlength="15"  value="<?echo $func_inv?>" readonly>
                  </span></td>
                  <td width="105" class="Estilo5"><span class="Estilo5">APLICACI&Oacute;N :</span> </td>
                  <td width="150" class="Estilo5"><input class="Estilo10" name="txtAplicacion" type="text" id="txtAplicacion" readonly size="4" maxlength="1"  value="<?ECHO $aplicacion?>"></td>
                  <td width="106" class="Estilo5">DISTRIBUCI&Oacute;N :</td>
                  <td width="166" class="Estilo5"><input class="Estilo10" name="txtdistribucion" type="text" id="txtdistribucion" size="20"  value="<?ECHO $distribucion?>" readonly></td>
                </tr>
              </table>
                          </td>
            </tr>
            <tr><td ><table width="852" border="0">
              <tr>
                <td width="90"><span class="Estilo5">ASIGNACI&Oacute;N :</span></td>
                <td width="150"><span class="Estilo5"><input readonly name="txtasignado" type="text" id="txtasignado" value="<?echo $asignado?>" size="19" style="text-align:right">  </span></td>
                <td width="122"><span class="Estilo5">DISPONIBILIDAD :</span></td>
                <td width="150"><span class="Estilo5"><input readonly name="txtdisponible" type="text" id="txtdisponible" value="<?echo $disponible?>" size="19" style="text-align:right">   </span></td>
                <td width="170"><span class="Estilo5">DISPONIBILIDAD DIFERIDA:</span></td>
                <td width="140"><span class="Estilo5"><input readonly name="txtdisp_diferida" type="text" id="txtdisp_diferida" value="<?echo $disp_diferida?>" size="19" style="text-align:right">   </span></td>
              </tr>
            </table></td>
            </tr>
        </table>
        <div id="Layer2" style="position:absolute; width:865px; height:288px; z-index:2">
<script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 800;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Ejecucion";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Modificaciones";        // Requiere: <div id="T12" class="tab-body">  ... </div>
</script>
<?include ("../class/class_tab.php");?>
<script type="text/javascript" language="javascript"> DrawTabs(); </script>
<!-- PESTAÑA 1 -->
<div id="T11" class="tab-body">
<table width="830"  border="1" cellspacing='0' cellpadding='0' align="center" id="ejecucion">
 <tr height="20" class="Estilo5">
   <td width="80"  align="left" bgcolor="#99CCFF"><strong>Periodo</strong></td>
   <td width="150" align="left" bgcolor="#99CCFF"><strong>Asignacion</strong></td>
   <td width="150" align="center" bgcolor="#99CCFF"><strong>Compromiso</strong></td>
   <td width="150" align="right" bgcolor="#99CCFF" ><strong>Causado </strong></td>
   <td width="150" align="left" bgcolor="#99CCFF"><strong>Pagado</strong></td>
   <td width="150" align="left" bgcolor="#99CCFF"><strong>Diferido</strong></td>
 </tr>
 <tr class="Estilo5">
    <td height="20" class="Estilo5">ENERO</td>
    <td align="right"><? echo $asignado01; ?></td>
    <td align="right"><? echo $compromiso01; ?></td>
    <td align="right"><? echo $causado01; ?></td>
    <td align="right"><? echo $pagos01; ?></td>
    <td align="right"><? echo $diferidos01; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">FEBRERO</td>
    <td align="right"><? echo $asignado02; ?></td>
    <td align="right"><? echo $compromiso02; ?></td>
    <td align="right"><? echo $causado02; ?></td>
    <td align="right"><? echo $pagos02; ?></td>
    <td align="right"><? echo $diferidos02; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">MARZO</td>
    <td align="right"><? echo $asignado03; ?></td>
    <td align="right"><? echo $compromiso03; ?></td>
    <td align="right"><? echo $causado03; ?></td>
    <td align="right"><? echo $pagos03; ?></td>
    <td align="right"><? echo $diferidos03; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">ABRIL</td>
    <td align="right"><? echo $asignado04; ?></td>
    <td align="right"><? echo $compromiso04; ?></td>
    <td align="right"><? echo $causado04; ?></td>
    <td align="right"><? echo $pagos04; ?></td>
    <td align="right"><? echo $diferidos04; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">MAYO</td>
    <td align="right"><? echo $asignado05; ?></td>
    <td align="right"><? echo $compromiso05; ?></td>
    <td align="right"><? echo $causado05; ?></td>
    <td align="right"><? echo $pagos05; ?></td>
    <td align="right"><? echo $diferidos05; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">JUNIO</td>
    <td align="right"><? echo $asignado06; ?></td>
    <td align="right"><? echo $compromiso06; ?></td>
    <td align="right"><? echo $causado06; ?></td>
    <td align="right"><? echo $pagos06; ?></td>
    <td align="right"><? echo $diferidos06; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">JULIO</td>
    <td align="right"><? echo $asignado07; ?></td>
    <td align="right"><? echo $compromiso07; ?></td>
    <td align="right"><? echo $causado07; ?></td>
    <td align="right"><? echo $pagos07; ?></td>
    <td align="right"><? echo $diferidos07; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">AGOSTO</td>
    <td align="right"><? echo $asignado08; ?></td>
    <td align="right"><? echo $compromiso08; ?></td>
    <td align="right"><? echo $causado08; ?></td>
    <td align="right"><? echo $pagos08; ?></td>
    <td align="right"><? echo $diferidos08; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">SEPTIEMBRE</td>
    <td align="right"><? echo $asignado09; ?></td>
    <td align="right"><? echo $compromiso09; ?></td>
    <td align="right"><? echo $causado09; ?></td>
    <td align="right"><? echo $pagos09; ?></td>
    <td align="right"><? echo $diferidos09; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">OCTUBRE</td>
    <td align="right"><? echo $asignado10; ?></td>
    <td align="right"><? echo $compromiso10; ?></td>
    <td align="right"><? echo $causado10; ?></td>
    <td align="right"><? echo $pagos10; ?></td>
    <td align="right"><? echo $diferidos10; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">NOVIEMBRE</td>
    <td align="right"><? echo $asignado11; ?></td>
    <td align="right"><? echo $compromiso11; ?></td>
    <td align="right"><? echo $causado11; ?></td>
    <td align="right"><? echo $pagos11; ?></td>
    <td align="right"><? echo $diferidos11; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">DICIEMBRE</td>
    <td align="right"><? echo $asignado12; ?></td>
    <td align="right"><? echo $compromiso12; ?></td>
    <td align="right"><? echo $causado12; ?></td>
    <td align="right"><? echo $pagos12; ?></td>
    <td align="right"><? echo $diferidos12; ?></td>
  </tr>
 </table>
 <table width="830"  border="1" cellspacing='0' cellpadding='0' align="center" id="total ejecucion">
 <tr class="Estilo5">
    <td height="20" width="80" class="Estilo5">TOTALES :</td>
    <td width="150"  align="right"><? echo $tasignado; ?></td>
    <td width="150" align="right"><? echo $tcompromiso; ?></td>
    <td width="150" align="right"><? echo $tcausado; ?></td>
    <td width="150" align="right"><? echo $tpagos; ?></td>
    <td width="150" align="right"><? echo $tdiferidos; ?></td>
  </tr>
 </table>
</div>
<!--PESTAÑA 2 -->
<div id="T12" class="tab-body" >
<table width="830"  border="1" cellspacing='0' cellpadding='0' align="center" id="modificaciones">
 <tr height="20" class="Estilo5">
   <td width="80"  align="left" bgcolor="#99CCFF"><strong>Periodo</strong></td>
   <td width="150" align="left" bgcolor="#99CCFF"><strong>Traspasos(+)</strong></td>
   <td width="150" align="center" bgcolor="#99CCFF"><strong>Traspasos(-)</strong></td>
   <td width="150" align="right" bgcolor="#99CCFF" ><strong>Aumentos </strong></td>
   <td width="150" align="left" bgcolor="#99CCFF"><strong>Disminucion</strong></td>
   <td width="150" align="left" bgcolor="#99CCFF"><strong>Disponible</strong></td>
 </tr>
 <tr class="Estilo5">
    <td height="20" class="Estilo5">ENERO</td>
    <td align="right"><? echo $traslados01; ?></td>
    <td align="right"><? echo $trasladon01; ?></td>
    <td align="right"><? echo $adicion01; ?></td>
    <td align="right"><? echo $disminucion01; ?></td>
    <td align="right"><? echo $disponible01; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">FEBRERO</td>
    <td align="right"><? echo $traslados02; ?></td>
    <td align="right"><? echo $trasladon02; ?></td>
    <td align="right"><? echo $adicion02; ?></td>
    <td align="right"><? echo $disminucion02; ?></td>
    <td align="right"><? echo $disponible02; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">MARZO</td>
    <td align="right"><? echo $traslados03; ?></td>
    <td align="right"><? echo $trasladon03; ?></td>
    <td align="right"><? echo $adicion03; ?></td>
    <td align="right"><? echo $disminucion03; ?></td>
    <td align="right"><? echo $disponible03; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">ABRIL</td>
    <td align="right"><? echo $traslados04; ?></td>
    <td align="right"><? echo $trasladon04; ?></td>
    <td align="right"><? echo $adicion04; ?></td>
    <td align="right"><? echo $disminucion04; ?></td>
    <td align="right"><? echo $disponible04; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">MAYO</td>
    <td align="right"><? echo $traslados05; ?></td>
    <td align="right"><? echo $trasladon05; ?></td>
    <td align="right"><? echo $adicion05; ?></td>
    <td align="right"><? echo $disminucion05; ?></td>
    <td align="right"><? echo $disponible05; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">JUNIO</td>
    <td align="right"><? echo $traslados06; ?></td>
    <td align="right"><? echo $trasladon06; ?></td>
    <td align="right"><? echo $adicion06; ?></td>
    <td align="right"><? echo $disminucion06; ?></td>
    <td align="right"><? echo $disponible06; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">JULIO</td>
    <td align="right"><? echo $traslados07; ?></td>
    <td align="right"><? echo $trasladon07; ?></td>
    <td align="right"><? echo $adicion07; ?></td>
    <td align="right"><? echo $disminucion07; ?></td>
    <td align="right"><? echo $disponible07; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">AGOSTO</td>
    <td align="right"><? echo $traslados08; ?></td>
    <td align="right"><? echo $trasladon08; ?></td>
    <td align="right"><? echo $adicion08; ?></td>
    <td align="right"><? echo $disminucion08; ?></td>
    <td align="right"><? echo $disponible08; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">SEPTIEMBRE</td>
    <td align="right"><? echo $traslados09; ?></td>
    <td align="right"><? echo $trasladon09; ?></td>
    <td align="right"><? echo $adicion09; ?></td>
    <td align="right"><? echo $disminucion09; ?></td>
    <td align="right"><? echo $disponible09; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">OCTUBRE</td>
    <td align="right"><? echo $traslados10; ?></td>
    <td align="right"><? echo $trasladon10; ?></td>
    <td align="right"><? echo $adicion10; ?></td>
    <td align="right"><? echo $disminucion10; ?></td>
    <td align="right"><? echo $disponible10; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">NOVIEMBRE</td>
    <td align="right"><? echo $traslados11; ?></td>
    <td align="right"><? echo $trasladon11; ?></td>
    <td align="right"><? echo $adicion11; ?></td>
    <td align="right"><? echo $disminucion11; ?></td>
    <td align="right"><? echo $disponible11; ?></td>
  </tr>
  <tr class="Estilo5">
    <td height="20" class="Estilo5">DICIEMBRE</td>
    <td align="right"><? echo $traslados12; ?></td>
    <td align="right"><? echo $trasladon12; ?></td>
    <td align="right"><? echo $adicion12; ?></td>
    <td align="right"><? echo $disminucion12; ?></td>
    <td align="right"><? echo $disponible12; ?></td>
  </tr>
 </table>
 <table width="830"  border="1" cellspacing='0' cellpadding='0' align="center" id="total ejecucion">
 <tr class="Estilo5">
    <td height="20" width="80" class="Estilo5">TOTALES :</td>
    <td width="150"  align="right"><? echo $ttraslados; ?></td>
    <td width="150" align="right"><? echo $ttrasladon; ?></td>
    <td width="150" align="right"><? echo $tadicion; ?></td>
    <td width="150" align="right"><? echo $tdisminucion; ?></td>
    <td width="150" align="right"><? echo $disponible12; ?></td>
  </tr>
 </table>
</div>
                </div>
        </form>
      </div>
    </td>
</tr>
</table>


<form name="form2" method="post" action="Inc_codigos.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
     <td width="5"><input name="txtSIA_Definicion" type="hidden" id="txtSIA_Definicion" value="<?echo $SIA_Definicion?>" ></td>
	 <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value="<?echo $Rif_Emp?>"></td>
     <td width="5"><input name="txtnomb" type="hidden" id="txtnomb" value="<?echo $Nom_Emp?>"></td>
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input name="txtformato" type="hidden" id="txtformato" value="<?echo $formato_presup?>"></td>
	 <td width="5"><input name="txttitulo" type="hidden" id="txttitulo" value="<?echo $titulo?>"></td>
	  
	  
	  
  </tr>
</table>
</form>
</body>
</html>
<? pg_close();?>