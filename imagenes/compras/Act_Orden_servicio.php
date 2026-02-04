<? include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php");include ("../class/configura.inc");
$equipo=getenv("COMPUTERNAME"); $mcod_m="COMP016".$usuario_sia.$equipo; $fecha_hoy=asigna_fecha_hoy();
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103, campo104 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; $modulo="09";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $Nom_usuario=$registro["campo104"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="09"; $opcion="02-0000055"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){ $p_letra='';$criterio=''; $tipo_compromiso=''; $nro_orden=''; $sql="SELECT * FROM ORD_SERVICIO ORDER BY nro_orden desc,tipo_compromiso desc";  $codigo_mov=substr($mcod_m,0,49);}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $nro_orden=substr($criterio,1,8);  $tipo_compromiso=substr($criterio,9,4);}
   else{$nro_orden=substr($criterio,0,8);  $tipo_compromiso=substr($criterio,8,4);}
  $codigo_mov=substr($mcod_m,0,49);   $clave=$nro_orden.$tipo_compromiso;
  $sql="Select * from ORD_SERVICIO where tipo_compromiso='$tipo_compromiso' and nro_orden='$nro_orden'";
  if ($p_letra=="P"){$sql="SELECT * FROM ORD_SERVICIO Order by nro_orden,tipo_compromiso";}
  if ($p_letra=="U"){$sql="SELECT * From ORD_SERVICIO Order by nro_orden desc,tipo_compromiso desc";}
  if ($p_letra=="S"){$sql="SELECT * From ORD_SERVICIO Where (text(nro_orden)||text(tipo_compromiso)>'$clave') Order by nro_orden,tipo_compromiso";}
  if ($p_letra=="A"){$sql="SELECT * From ORD_SERVICIO Where (text(nro_orden)||text(tipo_compromiso)<'$clave') Order by text(nro_orden)||text(tipo_compromiso) desc";}
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP COMPRAS,SERVICIOS Y ALMAC&Eacute;N (Ordenes de Servicio)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(mop){if(mop=='D'){ document.form2.submit(); }}
function Mover_Registro(MPos){var murl;
   murl="Act_Orden_servicio.php";
   if(MPos=="P"){murl="Act_Orden_servicio.php?Gcriterio=P"}
   if(MPos=="S"){murl="Act_Orden_servicio.php?Gcriterio=S"+document.form1.txtnro_orden.value+document.form1.txttipo_compromiso.value;}
   if(MPos=="A"){murl="Act_Orden_servicio.php?Gcriterio=A"+document.form1.txtnro_orden.value+document.form1.txttipo_compromiso.value;}
   if(MPos=="U"){murl="Act_Orden_servicio.php?Gcriterio=U"}
   document.location = murl;
}
function Llamar_Ventana(url){var murl;
var Gnro_orden=document.form1.txtnro_orden.value; murl=url+Gnro_orden;
    if (Gnro_orden=="") {alert("Orden debe ser Seleccionada");}  else {document.location = murl;}
}
function Llama_Anular(manu){var url; var r;
var Gtipo_compromiso=document.form1.txttipo_compromiso.value;
  if ((Gtipo_compromiso=="0000")||(Gtipo_compromiso.charAt(0)=="A")||(Gtipo_compromiso=="")||(manu=="S")) { alert("ORDEN, NO PUEDE SER ANULADA"); }
  else{url="Anula_ord_servicio.php?txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtnro_orden="+document.form1.txtnro_orden.value;
    VentanaCentrada(url,'Anular Orden de Servicio','','800','380','true');}
}
function Llama_Eliminar(manu){var url; var r;
var Gtipo_compromiso=document.form1.txttipo_compromiso.value;
  if ((Gtipo_compromiso=="0000")||(Gtipo_compromiso.charAt(0)=="A")||(Gtipo_compromiso=="")) { alert("COMPROMISO, NO PUEDE SER ELIMINADA"); }
  else{
    if(manu=="S"){url="Orden de Servicio Esta ANULADA, ";}else{url="";}
    r=confirm(url+"Esta seguro en Eliminar la Orden de Servicio ?");
    if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Orden de Servicio ?");
      if (r==true) {url="Delete_ord_servicio.php?Gcriterio="+document.form1.txtnro_orden.value+document.form1.txttipo_compromiso.value;
       VentanaCentrada(url,'Eliminar Orden de Servicio','','400','400','true');}
     }else { url="Cancelado, no elimino"; }
        }
}
function Llamar_Formato(maprobado,maprueba_comp,manu){var url;var r; var a=0;
 if(manu=="S"){a=0;}else{
 if((maprueba_comp=="S")&&((maprobado=="N")||(maprobado=="D"))){alert("Orden no aprobada");a=1;}} 
if(a==0){r=confirm("Desea Generar el Formato Orden de Servicio ?");
   if (r==true) {url="/sia/compras/rpt/Formato_ord_servicio.php?txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtnro_orden="+document.form1.txtnro_orden.value; window.open(url);  } 
 }else{ r=confirm("Desea Generar Borrador Orden de Servicio ?");
    if (r==true) {url="/sia/compras/rpt/Borrador_ord_servicio.php?txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtnro_orden="+document.form1.txtnro_orden.value;  window.open(url); }
 } 
}

function Llamar_Anexo_pre(){var url;var r;
   r=confirm("Desea Generar el Anexo de Codigos Presupuestarios ?");
   if (r==true) {url="/sia/compras/rpt/Rpt_anexo_cod_presup_os.php?txtnro_orden="+document.form1.txtnro_orden.value+"&txttipo_compromiso="+document.form1.txttipo_compromiso.value;   window.open(url); }
}

function Llama_Copiar(){var url;
 url="Copia_ord_servicio.php?Gcriterio="+document.form1.txtnro_orden.value+document.form1.txttipo_compromiso.value;
 VentanaCentrada(url,'Copiar Orden de Servicio','','400','400','true');
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
<style type="text/css">

</style>
</head>
<? if ($codigo_mov==""){$codigo_mov="";}else{
 $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $res=pg_exec($conn,"SELECT BORRAR_COMP042('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $res=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
}$mconf="";$Ssql="Select * from SIA005 where campo501='05'";$resultado=pg_query($Ssql);
if($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"];}$nro_aut=substr($mconf,1,1); $fecha_aut=substr($mconf,2,1); $aprueba_comp=substr($mconf,15,1); 
$mconf="";$tipo_ords="0002"; $cod_tipos="000002"; $nomb_a_ordc="O/S"; $cod_imp_unico="S"; $cod_imp_part="S"; $cod_part_iva="403-18-01-00"; $mconf73="";
$Ssql="Select * from SIA005 where campo501='09'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $mconf73=$registro["campo573"]; $tipo_ords=$registro["campo505"]; $cod_tipos=$registro["campo508"]; $cod_part_iva=$registro["campo509"]; }
$valida_requis=substr($mconf,9,1); $valida_req_aprobada=substr($mconf,10,1); $nro_aut=substr($mconf,11,1); $fecha_aut=substr($mconf,12,1); $modifc_presup=substr($mconf,13,1); $cod_imp_unico=substr($mconf73,1,1); $cod_imp_part=substr($mconf73,2,1);
$fecha_orden=""; $unidad_solicitante=""; $tipo_documento=""; $nro_documento=""; $rif_proveedor=""; $nro_solicitud=""; $inf_canc=""; $nombre_abrev_comp=""; $nombre=""; $des_fuente_financ=""; $concepto="";
$fecha_solicitud=""; $tiempo_entrega=""; $lugar_entrega=""; $direccion_entrega=""; $operacion=""; $dias_credito=""; $afecta_presupuesto=""; $fuente_financ=""; $anulado=""; $fecha_anulado=""; $cancelada="";
$fecha_cancelacion=""; $nro_ord_pago=""; $nro_linea=""; $redondeo_total=""; $redondeo_impuesto=""; $aplica_impuesto=""; $cod_presup_imp=""; $tasa_flete=""; $monto_flete=""; $cod_presup_flete=""; $des_unidad_sol="";
$tasa_otros=""; $monto_otros=""; $cod_presup_otros=""; $tasa_imp1=""; $monto_obj_imp1=""; $cod_presup_imp1=""; $tasa_imp2=""; $monto_obj_imp2=""; $cod_presup_imp2=""; $tasa_imp3=""; $monto_obj_imp3=""; $cod_presup_imp3="";
$status=""; $fecha_vencim=""; $nro_cod_pre=""; $campo_str1=""; $campo_str2=""; $campo_num1=0; $campo_num2=0; $aprobado=""; $fecha_aprobada=""; $usuario_sia_aprueba=""; $nro_expediente=""; $usuario_sia_ord=""; $inf_usuario="";
$res=pg_query($sql); $filas=pg_num_rows($res);if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM ORD_SERVICIO Order by nro_orden,tipo_compromiso";}  if ($p_letra=="S"){$sql="SELECT * From ORD_SERVICIO Order by nro_orden desc,tipo_compromiso desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){$registro=pg_fetch_array($res);
  $nro_orden=$registro["nro_orden"];  $tipo_compromiso=$registro["tipo_compromiso"];   $fecha_orden=$registro["fecha_orden"]; $nombre_abrev_comp=$registro["nombre_abrev_comp"]; $nombre=$registro["nombre"]; $concepto=$registro["concepto"];
  $unidad_solicitante=$registro["unidad_solicitante"];  $nro_solicitud=$registro["nro_solicitud"]; $fecha_solicitud=$registro["fecha_solicitud"]; $des_unidad_sol=$registro["denominacion_cat"];
  $rif_proveedor=$registro["rif_proveedor"];  $tiempo_entrega=$registro["tiempo_entrega"]; $lugar_entrega=$registro["lugar_entrega"];  $direccion_entrega=$registro["direccion_entrega"];  $operacion=$registro["operacion"]; $dias_credito=$registro["dias_credito"];
  $afecta_presupuesto=$registro["afecta_presupuesto"]; $fuente_financ=$registro["fuente_financ"]; $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $cancelada=$registro["cancelada"];
  $fecha_cancelacion=$registro["fecha_cancelacion"]; $nro_ord_pago=$registro["nro_ord_pago"]; $nro_linea=$registro["nro_linea"]; $redondeo_total=$registro["redondeo_total"]; $redondeo_impuesto=$registro["redondeo_impuesto"]; $aplica_impuesto=$registro["aplica_impuesto"];
  $cod_presup_imp=$registro["cod_presup_imp"]; $tasa_flete=$registro["tasa_flete"]; $monto_flete=$registro["monto_flete"]; $cod_presup_flete=$registro["cod_presup_flete"]; $status=$registro["status"]; $fecha_vencim=$registro["fecha_vencim"];
  $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"]; $monto_obj_imp3=$registro["monto_obj_imp3"]; $campo_str1=$registro["campo_str1"];
  $aprobado=$registro["aprobado"]; $fecha_aprobada=$registro["fecha_aprobada"]; $usuario_sia_aprueba=$registro["usuario_sia_aprueba"]; $nro_expediente=$registro["nro_expediente"]; $usuario_sia_ord=$registro["usuario_sia"];$inf_usuario=$registro["inf_usuario"];
}
if($fecha_orden==""){$fecha_orden="";}else{$fecha_orden=formato_ddmmaaaa($fecha_orden);}
if($fecha_solicitud==""){$fecha_solicitud="";}else{$fecha_solicitud=formato_ddmmaaaa($fecha_solicitud);}
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
If($operacion=="C"){ $operacion="CREDITO";}else{ $operacion="CONTADO";} if($aplica_impuesto=="S"){$aplica_impuesto="SI";}else{$aplica_impuesto="NO";}
$Ssql="Select * from COMPROMISOS where tipo_compromiso='$tipo_compromiso' and referencia_comp='$nro_orden'" ;
$resultado=pg_query($Ssql); $filasp=pg_num_rows($resultado);$cod_comp="";$func_inv="";$tiene_anticipo="";$tasa_anticipo="";$cod_con_anticipo="";
if($filasp>0){$reg=pg_fetch_array($resultado);$cod_comp=$reg["cod_comp"]; $tipo_documento=$reg["tipo_documento"]; $nro_documento=$reg["nro_documento"]; $func_inv=$reg["func_inv"]; $tiene_anticipo=$reg["tiene_anticipo"]; $tasa_anticipo=$reg["tasa_anticipo"]; $cod_con_anticipo=$reg["cod_con_anticipo"]; }
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
if($tiene_anticipo=="S"){$tiene_anticipo="SI";}else{$tiene_anticipo="NO";} $clave=$nro_orden.$tipo_compromiso.$cod_comp;
$total_orden=$monto_obj_imp3+$campo_num2; $total_orden=formato_monto($total_orden); $monto_obj_imp3=formato_monto($monto_obj_imp3); $campo_num2=formato_monto($campo_num2);
$msta="";  if($aprobado=='S'){$msta="APROBADO";} if($aprobado=='D'){$msta="DEVUELTA";}
$fecha_f=formato_ddmmaaaa($Fec_Fin_Ejer);  if(FDate($fecha_hoy)>FDate($fecha_f)){$fecha_hoy=$fecha_f;}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ORDENES DE SERVICIO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="543" border="0" id="tablacuerpo">
  <tr>
    <td><div id="Layer2" style="position:absolute; width:102px; height:434px; z-index:2; top: 61px; left: 7px;">
      <table width="92" height="524" border="1" cellpadding="0" cellspacing="0" id="tablam">
        <td width="86">
            <td>
              <table width="92" height="522" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
			    <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
                <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Orden('D')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_Orden('D')">Incluir</A></td>
                </tr>
                <?} if ($Mcamino{2}=="S"){?>  
                <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
                </tr>
                <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
                </tr><tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
        </tr>
        <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
        </tr>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_Act_Orden_Servicio.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_Act_Orden_Servicio.php" class="menu">Catalogo</a></td>
        </tr>
		<?} if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Anular('<?echo $anulado?>');" class="menu">Anular</a></td>
        </tr>
		<?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar('<?echo $anulado?>');" class="menu">Eliminar</a></td>
        </tr>
		<?} if ($Mcamino{4}=="S"){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato('<?echo $aprobado?>','<?echo $aprueba_comp?>','<?echo $anulado?>');" class="menu">Formato Orden</a></td>
        </tr>
		<tr>
           <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llamar_Anexo_pre();" class="menu">Anexos Cod. Presupuestarios</a></div></td>
        </tr>
		<? if(($aprueba_comp=="S")and($SIA_Cierre=="N")){?>
	    <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:LlamarURL('List_orden_serv_aprob.php');" class="menu">Ordenes por Aprobar</a></td>
        </tr>		
	    <? } }
		if ($Mcamino{2}=="S"){?>		
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Copiar();" class="menu">Copiar</a></td>
        </tr>	
		<? } ?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
            </table></td>
      </table>
    </div>
    <p>&nbsp;</p></td><td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:866px; height:532px; z-index:1; top: 67px; left: 118px;">
            <form name="form1" method="post">
              <table width="862" align="center">
                <tr>
                  <td width="861"><table width="861">
                      <tr>
                        <td width="100"><p><span class="Estilo5">N&Uacute;MERO ORDEN:</span></p></td>
                        <td width="110"><input name="txtnro_orden" type="text"  id="txtnro_orden" value="<?echo $nro_orden?>" size="10" readonly></td>
                        <td width="168"><span class="Estilo5">DOCUMENTO COMPROMISO: </span></td>
                        <td width="48"><span class="Estilo5"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" value="<?echo $tipo_compromiso?>" size="4" readonly></span> </td>
                        <td width="66"><span class="Estilo5"><input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" value="<?echo $nombre_abrev_comp?>" size="4" readonly></span></td>
                        <? if($anulado=='S'){?> <td width="109"><span class="Estilo15">ANULADO</span></td>
                        <? }else{if($cancelada=='S'){?> <td width="109"><a class="Estilo11" href="javascript:alert('<?echo $inf_canc?>');">CANCELADA</a>
                         <? }else{?> <td width="109"><span class="Estilo5"><? echo $msta ?></span></td><? }}?>
                        <td width="49"><span class="Estilo5">FECHA :</span> </td>
                        <td width="78"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" value="<?echo $fecha_orden?>" size="12" readonly> </span></td>
                        <td width="30"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                       </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="861">
                    <tr>
                      <td width="130"><span class="Estilo5">SOLICITUD NRO. :</span></td>
                      <td width="110"><span class="Estilo5"><input name="txtnro_solicitud" type="text" id="txtnro_solicitud" size="8" value="<?echo $nro_solicitud?>" readonly>  </span></td>
                      <td width="145"><span class="Estilo5">FECHA SOLICITUD :</span></td>
                      <td width="120"><span class="Estilo5"><input name="txtfecha_solicitud" type="text" id="txtfecha_solicitud" value="<?echo $fecha_solicitud?>" size="10" readonly>  </span></td>
                      <td width="130"><span class="Estilo5">TIPO OPERACI&Oacute;N : </span></td>
                      <td width="115"><span class="Estilo5"> <input name="txtoperacion" type="text" id="txtoperacion" value="<?echo $operacion?>" size="10" readonly></span></td>
                      <td width="40"><span class="Estilo5">DIAS : </span></td>
                      <td width="66"><span class="Estilo5"> <input name="txtdias_credito" type="text" id="txtdias_credito" size="4" value="<?echo $dias_credito?>" readonly>  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td><table width="861">
                        <tr>
                          <td width="183"><p><span class="Estilo5">CATEGORIA PRESUPUESTARIA:</span></p> </td>
                          <td width="136"><input name="txtunidad_sol" type="text"  id="txtunidad_sol" value="<?echo $unidad_solicitante?>" size="20" readonly></td>
                          <td width="480"><input name="txtdes_unidad_sol" type="text"  id="txtdes_unidad_sol" value="<?echo $des_unidad_sol?>" size="70" readonly></td>
                        </tr>
                      </table></td>
                </tr>
                <tr>
                  <td><table width="861">
                    <tr>
                      <td width="160"><span class="Estilo5">UNIDAD SOLICITANTE :</span></td>
                      <td width="700"><span class="Estilo5"> <input name="txtlugar_entrega" type="text" id="txtlugar_entrega" size="98" readonly  value="<?echo $lugar_entrega?>">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="861">
                    <tr>
                      <td width="120"><span class="Estilo5">PROVEEDOR:</span></td>
                      <td width="134"><span class="Estilo5"><input name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="12"  value="<?echo $rif_proveedor?>" readonly> </span></td>
                      <td width="586"><span class="Estilo5"><input name="txtnombre" type="text" id="txtnombre" value="<?echo $nombre?>" size="89" readonly>  </span></td>
                    </tr>
                  </table></td>
                </tr>

                <tr>
                  <td><table width="861">
                      <tr>
                        <td width="106"><span class="Estilo5">CONCEPTO:</span></td>
                        <td width="694"><textarea name="txtconcepto" cols="89" readonly="readonly" class="headers" id="txtconcepto"><?echo $concepto?></textarea></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                    <td><table width="861">
                        <tr>
                          <td width="145"><span class="Estilo5">FECHA VENCIMIENTO:</span></td>
                          <td width="110"><span class="Estilo5"><input name="txtfecha_vencim" type="text" id="txtfecha_vencim" value="<?echo $fecha_vencim?>" size="12" readonly> </span></td>
                          <td width="130"><span class="Estilo5">APLICA IMPUESTO :</span></td>
                          <td width="65"><span class="Estilo5"><input name="txtaplica_impuesto" type="text" id="txtaplica_impuesto" size="2"  value="<?echo $aplica_impuesto?>" readonly> </span></td>
                          <td width="170"><span class="Estilo5">COD. PRESUP. IMPUESTO:</span></td>
                          <td width="240"><span class="Estilo5"><input name="txtcod_presup_imp" type="text" id="txtcod_presup_imp" size="30"  value="<?echo $cod_presup_imp?>" readonly> </span></td>
                         </tr>
                    </table></td>
                </tr>
				    <tr>
                      <td><table width="832">
                        <tr>
                          <td width="114"><span class="Estilo5">TIPO DE GASTO :</span></td>
                          <td width="147"><span class="Estilo5"><input name="txtfunc_inv" type="text" id="txtfunc_inv"  value="<?echo $func_inv?>" size="15" readonly>  </span></td>
                          <td width="120" align="center"><span class="Estilo5">TIPO FLETE:</span</td>
                          <td width="167"><span class="Estilo5"><input name="txtcampo_str1" type="text" id="txtcampo_str1"  value="<?echo $campo_str1?>" size="20" readonly></span></td>
                          <td width="154" align="center"><span class="Estilo5">TIENE ANTICIPO :</span></td>
                          <td width="89"><span class="Estilo5"><input name="txttiene_anticipo" type="text" id="txttiene_anticipo" size="3"  value="<?echo $tiene_anticipo?>" readonly> </span></td>
                          <td width="44"><input name="txtcodigo_comp" type="hidden" id="txtcodigo_comp" value="<?echo $cod_comp?>"></td>
                        </tr>
                      </table></td>
                    </tr>                               
                    <tr>
                      <td><table width="826">
                        <tr>
                          <td width="197"><span class="Estilo5">PORCENTAJE DE ANTICIPO(%):</span></td>
                          <td width="210"><span class="Estilo5"><input readonly name="txttasa_anticipo" type="text" id="txttasa_anticipo" value="<?ECHO $tasa_anticipo?>" size="8">   </span></td>
                          <td width="148"><span class="Estilo5">CUENTA DE ANTICIPO:</span></td>
                          <td width="251"><span class="Estilo5"><input name="txtcod_con_anticipo" type="text" id="txtcod_con_anticipo" value="<?echo $cod_con_anticipo?>" size="30" readonly>   </span></td>
                        </tr>
                      </table></td>
                    </tr>
              </table>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:312px; z-index:2; left: 2px; top: 330px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Servicios";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "C&oacute;d. Presupuestario";        // Requiere: <div id="T12" class="tab-body">  ... </div>
            </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_cons_serv_orden.php?criterio=<?echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_cons_cod_orden.php?criterio=<?echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
                <div id="Layer3" style="position:absolute; width:868px; height:60px; z-index:2; left: 2px; top: 660px;">
                <table width="865" border="0">
                <tr>
                <td width="130"> <span class="Estilo5">SUB-TOTAL : </span> </td>
                <td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $monto_obj_imp3; ?></td> </tr>
         </table></td>
                <td width="130" align="right"> <span class="Estilo5">IMPUESTO : </span> </td>
                <td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $campo_num2; ?></td> </tr>
         </table></td>
                 <td width="130" align="right"> <span class="Estilo5">TOTAL ORDEN : </span> </td>
                <td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total_orden; ?></td> </tr>
         </table></td>
                </tr>

         </table></div>
        </form>
<form name="form2" method="post" action="Inc_Orden_Servicio.php">
<table width="10">
  <tr>
      <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtcod_tipos" type="hidden" id="txtcod_tipos" value="<?echo $cod_tipos?>" ></td>
     <td width="5"><input name="txttipo_ords" type="hidden" id="txttipo_ords" value="<?echo $tipo_ords?>" ></td>
     <td width="5"><input name="txtnombre_abrev" type="hidden" id="txtnombre_abrev" value="<?echo $nomb_a_ordc?>" ></td>
     <td width="5"><input name="txtmodifc_presup" type="hidden" id="txtmodifc_presup" value="<?echo $modifc_presup?>" ></td>
     <td width="5"><input name="txtcod_imp_unico" type="hidden" id="txtcod_imp_unico" value="<?echo $cod_imp_unico?>" ></td>
     <td width="5"><input name="txtcod_imp_part" type="hidden" id="txtcod_imp_part" value="<?echo $cod_imp_part?>" ></td>
     <td width="5"><input name="txtcod_part_iva" type="hidden" id="txtcod_part_iva" value="<?echo $cod_part_iva?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtbloqueada" type="hidden" id="txtbloqueada" value="N" ></td>
     <td width="5"><input name="txtnro_ord" type="hidden" id="txtnro_ord" value="" ></td>
     <td width="5"><input name="txtasig_orden" type="hidden" id="txtasig_orden" value="S" ></td>
     <td width="5"><input name="txtfecha_ord" type="hidden" id="txtfecha_ord" value="<?echo $fecha_hoy?>" ></td>     	 
	 <td width="5"><input name="txtnro_sol" type="hidden" id="txtnro_sol" value="00000000"></td>
     <td width="5"><input name="txtfecha_sol" type="hidden" id="txtfecha_sol" value="<?echo $fecha_hoy?>"></td>
     <td width="5"><input name="txtdias_c" type="hidden" id="txtdias_c" value="30"></td>
     <td width="5"><input name="txtoper" type="hidden" id="txtoper" value="C"></td>
     <td width="5"><input name="txtcod_est" type="hidden" id="txtconcep" value="" ></td>
	 <td width="5"><input name="txtuni_sol" type="hidden" id="txtuni_sol" value=""></td>
     <td width="5"><input name="txtdes_unidad" type="hidden" id="txtdes_unidad" value=""></td>
     <td width="5"><input name="txtlugar_ent" type="hidden" id="txtlugar_ent" value=""></td>   
     <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value=""></td>
     <td width="5"><input name="txtnomb_r" type="hidden" id="txtnomb_r" value=""></td>     
     <td width="5"><input name="txtfecha_ven" type="hidden" id="txtfecha_ven" value="<?echo $fecha_hoy?>"></td>	 
	 <td width="5"><input name="txtaplica_imp" type="hidden" id="txtaplica_imp" value="S" ></td>
     <td width="5"><input name="txtcod_pre_imp" type="hidden" id="txtcod_pre_imp" value="<?echo $cod_part_iva?>" ></td>
	 <td width="5"><input name="txtfuente_imp" type="hidden" id="txtfuente_imp" value="00" ></td>
	 <td width="5"><input name="txtf_inv" type="hidden" id="txtf_inv" value="C" ></td>
     <td width="5"><input name="txttipo_f" type="hidden" id="txttipo_f" value="N" ></td>
     <td width="5"><input name="txttiene_ant" type="hidden" id="txttiene_ant" value="N" ></td>
     <td width="5"><input name="txttasa_ant" type="hidden" id="txttasa_ant" value="0"></td>
     <td width="5"><input name="txtcta_ant" type="hidden" id="txtcta_ant" value=""></td>
     <td width="5"><input name="txtfecha_d" type="hidden" id="txtfecha_d" value=""></td>
     <td width="5"><input name="txtfecha_h" type="hidden" id="txtfecha_h" value=""></td>
  </tr>
</table>
</form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>