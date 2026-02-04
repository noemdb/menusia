<?php  include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php");
$equipo=getenv("COMPUTERNAME"); $mcod_m="COMP007".$usuario_sia.$equipo; $fecha_hoy=asigna_fecha_hoy();

$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103, campo104 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; $modulo="09";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $Nom_usuario=$registro["campo104"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="09"; $opcion="02-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){ $p_letra='';$criterio=''; $nro_requisicion=''; $sql="SELECT * FROM REQUISICIONES  ORDER BY nro_requisicion desc";  $codigo_mov=substr($mcod_m,0,49);}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $nro_requisicion=substr($criterio,1,8);}
   else{$nro_requisicion=substr($criterio,0,8); }
  $codigo_mov=substr($mcod_m,0,49);   $clave=$nro_requisicion;
  $sql="Select * from REQUISICIONES  where nro_requisicion='$nro_requisicion'";
  if ($p_letra=="P"){$sql="SELECT * FROM REQUISICIONES  Order by nro_requisicion";}
  if ($p_letra=="U"){$sql="SELECT * From REQUISICIONES  Order by nro_requisicion desc";}
  if ($p_letra=="S"){$sql="SELECT * From REQUISICIONES  Where nro_requisicion>'$clave' Order by nro_requisicion";}
  if ($p_letra=="A"){$sql="SELECT * From REQUISICIONES  Where nro_requisicion<'$clave' Order by nro_requisicion";}
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP COMPRAS Y ALMAC&Eacute;N (Requisici&oacute;n de Art&iacute;culos)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url,maprob){var murl;
var Gnro_requisicion=document.form1.txtnro_requisicion.value;  murl=url+Gnro_requisicion;
    if (maprob=="SI") {alert("Requisicion no puede ser modificada, Esta Aprobada");}  else {document.location = murl;}
}
function Llamar_Inc_Orden(mop){if(mop=='D'){ document.form2.submit(); }}
function Mover_Registro(MPos){var murl;
   murl="Act_Req_Articulos.php";
   if(MPos=="P"){murl="Act_Req_Articulos.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_Req_Articulos.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_Req_Articulos.php?Gcriterio=S"+document.form1.txtnro_requisicion.value;}
   if(MPos=="A"){murl="Act_Req_Articulos.php?Gcriterio=A"+document.form1.txtnro_requisicion.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar la Requisicion ?");
  if (r==true) {  r=confirm("Esta Realmente seguro en Eliminar la Requisicion ?");
    if (r==true) {
       url="Delete_requisicion.php?txtnro_requisicion="+document.form1.txtnro_requisicion.value;
       VentanaCentrada(url,'Eliminar Requisicion','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
  
}
function Llamar_Formato(maprobado){var url;var r; var a=0;
 if(a==0){r=confirm("Desea Generar el Formato Requisicion ?");
   if (r==true) {url="/sia/compras/rpt/Formato_req_articulo.php?txtnro_requisicion="+document.form1.txtnro_requisicion.value;  window.open(url); }
 }
}
function Llama_Aprobar(maprobado){var url; var mnomb='<?php echo $Nom_usuario?>'   
   if (maprobado=="SI") {alert("Requisicion no puede ser modificada, Ya esta Aprobada");}  
   else { url="Aprobar_Requisicion.php?txtnro_requisicion="+document.form1.txtnro_requisicion.value+"&mnomb="+mnomb;  VentanaCentrada(url,'Aprobar Requisicion','','800','380','true');}
}
function Llama_Recibir(mrecibida){var url; var mnomb='<?php echo $Nom_usuario?>'   
   if (mrecibida=="SI") {alert("Requisicion Esta Recibida");}  
   else { url="Recibir_Requisicion.php?txtnro_requisicion="+document.form1.txtnro_requisicion.value+"&mnomb="+mnomb;  VentanaCentrada(url,'Aprobar Requisicion','','800','380','true');}
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
</head>
<?php  
if ($codigo_mov==""){$codigo_mov="";}else{
 $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
 $res=pg_exec($conn,"SELECT BORRAR_COMP042('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
 $res=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
}$mconf="";$Ssql="Select * from SIA005 where campo501='05'";$resultado=pg_query($Ssql);
if($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"];}$nro_aut=substr($mconf,1,1); $fecha_aut=substr($mconf,2,1); $aprueba_comp=substr($mconf,15,1);
$mconf="";$tipo_ordc="0001"; $cod_tipoc="000001"; $nomb_a_ordc="O/C"; $cod_imp_unico="S"; $cod_imp_part="S"; $cod_part_iva="403-18-01-00"; $mconf73="";
$Ssql="Select * from SIA005 where campo501='09'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $mconf73=$registro["campo573"]; $tipo_ordc=$registro["campo504"]; $cod_tipoc=$registro["campo507"]; $cod_part_iva=$registro["campo509"]; }
$valida_requis=substr($mconf,1,1); $valida_req_aprobada=substr($mconf,2,1); $nro_aut=substr($mconf,3,1); $fecha_aut=substr($mconf,4,1); $modifc_presup=substr($mconf,7,1); $cod_imp_unico=substr($mconf73,1,1); $cod_imp_part=substr($mconf73,2,1);

$fecha=""; $unidad_solicitante=""; $nombre_departamento=""; $tipo_requisicion=""; $externa=""; $fecha_externa=""; $nro_externa=""; $aprobado=""; $fecha_aprobada=""; $aprobado_por=""; $status_requisicion=""; $des_status=""; 
$recibida=""; $fecha_recibida=""; $recibida_por=""; $ajustado=""; $fecha_ajuste=""; $des_ajuste=""; $nro_expediente=""; $nro_comprobante=""; $usuario_req=""; $usuario_sia_aprueba=""; 
$usuario_sia_ajuste=""; $usuario_sia_recibe=""; $inf_usuario=""; $status_1=""; $status_2=""; $campo_str1=""; $campo_str2=""; $campo_num1=""; $campo_num2=""; $observacion="";  $des_unidad_sol="";		

$res=pg_query($sql); $filas=pg_num_rows($res);if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM REQUISICIONES Order by nro_requisicion";}  if ($p_letra=="S"){$sql="SELECT * From REQUISICIONES Order by nro_requisicion desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){$registro=pg_fetch_array($res);
  $nro_requisicion=$registro["nro_requisicion"];   $des_unidad_sol=$registro["denominacion_cat"];
  $fecha=$registro["fecha"]; $unidad_solicitante=$registro["unidad_solicitante"];  $nombre_departamento=$registro["nombre_departamento"]; 
  $tipo_requisicion=$registro["tipo_requisicion"]; $externa=$registro["externa"]; $fecha_externa=$registro["fecha_externa"]; $nro_externa=$registro["nro_externa"]; 
  $aprobado=$registro["aprobado"]; $fecha_aprobada=$registro["fecha_aprobada"]; $aprobado_por=$registro["aprobado_por"]; $status_requisicion=$registro["status_requisicion"]; $des_status=$registro["des_status"]; 
  $recibida=$registro["recibida"]; $fecha_recibida=$registro["fecha_recibida"]; $recibida_por=$registro["recibida_por"]; $ajustado=$registro["ajustado"]; $fecha_ajuste=$registro["fecha_ajuste"]; $des_ajuste=$registro["des_ajuste"]; 
  $nro_expediente=$registro["nro_expediente"]; $nro_comprobante=$registro["nro_comprobante"]; $usuario_req=$registro["usuario_sia"]; $usuario_sia_aprueba=$registro["usuario_sia_aprueba"]; 
  $usuario_sia_ajuste=$registro["usuario_sia_ajuste"]; $usuario_sia_recibe=$registro["usuario_sia_recibe"]; 
   $status_1=$registro["status_1"]; $status_2=$registro["status_2"]; $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"]; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"]; 
   $observacion=$registro["observacion"]; $inf_usuario=$registro["inf_usuario"];
}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($fecha_externa==""){$fecha_externa="";}else{$fecha_externa=formato_ddmmaaaa($fecha_externa);}
if($fecha_recibida==""){$fecha_recibida="";}else{$fecha_recibida=formato_ddmmaaaa($fecha_recibida);}
if($fecha_aprobada==""){$fecha_aprobada="";}else{$fecha_aprobada=formato_ddmmaaaa($fecha_aprobada);}
if($fecha_ajuste==""){$fecha_ajuste="";}else{$fecha_ajuste=formato_ddmmaaaa($fecha_ajuste);}
if($fecha_ajuste==""){$fecha_ajuste="";}else{$fecha_ajuste=formato_ddmmaaaa($fecha_ajuste);}$clave=$nro_requisicion;
$total_requisicion=$campo_num1; $total_orden=formato_monto($total_requisicion); $campo_num1=formato_monto($campo_num1); $campo_num2=formato_monto($campo_num2);
$msta="";  if($aprobado=='S'){$msta="APROBADO"; $aprobado='SI';} if($aprobado=='D'){$msta="DEVUELTA";}
if($aprobado=='N'){$aprobado='NO';$fecha_aprobada=""; $aprobado_por="";} if($externa=='S'){$externa='SI';} else{$externa='NO';} 
if($status_requisicion=="A"){$status_requisicion="ATENDIDA";}else{$status_requisicion="PROCESO";}
if($tipo_requisicion=="C"){$tipo_requisicion="COMPRAS";}else{$tipo_requisicion="ALMACEN";}
if($recibida=='S'){$recibida='SI';} else{$recibida='NO';$fecha_recibida=""; $recibida_por="";}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REQUISICI&Oacute;N DE ART&Iacute;CULOS </div></td>
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
			    <?php if ($Mcamino{0}=="S"){?>
                <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Orden('D')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_Orden('D')">Incluir</A></td>
                </tr>
				<?php } if ($Mcamino{1}=="S"){?> 
                <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Modifica_Req.php?Gnro_req=','<?php echo $aprobado?>')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Modifica_Req.php?Gnro_req=','<?php echo $aprobado?>');">Modificar</A></td>
				</tr>
				<?php } if ($Mcamino{2}=="S"){?> 
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
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_req_articulos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_req_articulos.php" class="menu">Catalogo</a></td>
        </tr>
        <?php } if ($Mcamino{6}=="S"){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar('<?php echo $aprobado?>');" class="menu">Eliminar</a></td>
        </tr>
		<?php } if ($Mcamino{4}=="S"){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato('<?php echo $aprobado?>');" class="menu">Formato Requisicion</a></td>
        </tr>
        <?php } if ($Mcamino{9}=="S"){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Aprobar('<?php echo $aprobado?>');;" class="menu">Aprobar</a></td>
        </tr>
		<?php } if ($Mcamino{10}=="S"){?>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Estatus('<?php echo $status_requisicion?>');" class="menu">Estatus</a></td>
        </tr>
        <?php } if ($Mcamino{11}=="S"){?>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Recibir('<?php echo $recibida?>');" class="menu">Recibir</a></td>
        </tr>
        <?php }?>
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
              <table width="868" align="center">
                <tr>
                  <td width="865"><table width="861">
                      <tr>
                        <td width="173"><p><span class="Estilo5">N&Uacute;MERO DE REQUISICI&Oacute;N :</span></p></td>
                        <td width="110"><input name="txtnro_requisicion" type="text"  id="txtnro_requisicion" value="<?php echo $nro_requisicion?>" size="10"  class="Estilo5"readonly></td>
                        <td width="90"><span class="Estilo5">FECHA   :</span></td>
						<td width="125"><span class="Estilo5"><input name="txtfecha" type="text" class="Estilo5" id="txtfecha"  value="<?php echo $fecha?>" size="11" maxlength="10" readonly> </span></td>
					    <td width="127"><span class="Estilo5">TIPO REQUISICI&Oacute;N   :</span></td>
                        <td width="100"><span class="Estilo5"><input name="txttipo_requisicion" type="text" class="Estilo5" id="txttipo_requisicion"  value="<?php echo $tipo_requisicion?>" size="12" maxlength="11" readonly>  </span></td>
                        <td width="35"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                      </tr>
                  </table></td>
                </tr>
				<tr><td><table width="865">
                        <tr>
                          <td width="178"><p><span class="Estilo5">CATEGORIA PRESUPUESTARIA:</span></p> </td>
                          <td width="136"><input name="txtunidad_sol" type="text"  id="txtunidad_sol" value="<?php echo $unidad_solicitante?>" size="20" class="Estilo5" readonly></td>
                          <td width="485"><input name="txtdes_unidad_sol" type="text"  id="txtdes_unidad_sol" value="<?php echo $des_unidad_sol?>" size="70" class="Estilo5" readonly></td>
                        </tr>
                      </table></td>
                </tr>
               <tr>
                  <td><table width="865">
                    <tr>
                      <td width="160"><span class="Estilo5">UNIDAD SOLICITANTE :</span></td>
                      <td width="700"><span class="Estilo5"><input name="txtnombre_departamento" type="text" id="txtnombre_departamento" size="100" readonly class="Estilo5" value="<?php echo $nombre_departamento?>"></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="865" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="124"><span class="Estilo5">OBSERVACIONES : </span></td>
                      <td width="734"><span class="Estilo5"><textarea name="txtobservacion" cols="80" readonly="readonly" class="headers" id="txtobservacion"><?php echo $observacion?></textarea></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="865">
                    <tr>
                      <td width="161"><span class="Estilo5">REQUISICI&Oacute;N EXTERNAS : </span></td>
                      <td width="62"><span class="Estilo5"><input name="txtexterna" type="text" class="Estilo5" id="txtexterna"  value="<?php echo $externa?>" size="3" maxlength="2" readonly></span></td>
                      <td width="200"><span class="Estilo5">NRO. REQUISICI&Oacute;N ALTERNA : </span></td>
                      <td width="132"><span class="Estilo5"><input name="txtnro_externa" type="text" class="Estilo5" id="txtnro_externa"  value="<?php echo $nro_externa?>" size="22" maxlength="20" readonly> </span></td>
                      <td width="190"><span class="Estilo5">FECHA REQUISICI&Oacute;N  ALTERNA :</span></td>
                      <td width="92"><span class="Estilo5"><input name="txtfecha_externa" type="text" class="Estilo5" id="txtfecha_externa"  value="<?php echo $fecha_externa?>" size="12" maxlength="10" readonly></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="865" >
                    <tr>
                      <td width="90"><span class="Estilo5">RECIBIDA : </span></td>
					  <td width="64"><span class="Estilo5"><input name="txtrecibida" type="text" class="Estilo5" id="txtrecibida"  value="<?php echo $recibida?>" size="3" maxlength="2" readonly></span></td>
                      
                      <td width="120"><span class="Estilo5">FECHA RECIBIDO  : </span></td>
                      <td width="86"><span class="Estilo5"><input name="txtfecha_recibida" type="text" class="Estilo5" id="txtfecha_recibida"  value="<?php echo $fecha_recibida?>" size="12" maxlength="10" readonly> </span></td>
                      <td width="100"><span class="Estilo5">RECIBIDO POR  : </span></td>
                      <td width="400"><span class="Estilo5"><input name="txtrecibida_por" type="text" class="Estilo5" id="txtrecibida_por"  value="<?php echo $recibida_por?>" size="70" maxlength="70" readonly></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="865" >
                    <tr>
                      <td width="80"><span class="Estilo5">APROBADA : </span></td>
                      <td width="100"><span class="Estilo5"><input name="txtaprobado" type="text" class="Estilo5" id="txtaprobado"  value="<?php echo $aprobado?>" size="3" maxlength="2" readonly> </span></td>
                      <td width="120"><span class="Estilo5">FECHA APROBACI&Oacute;N  : </span></td>
                      <td width="110"><span class="Estilo5"><input name="txtfecha_aprobada" type="text" class="Estilo5" id="txtfecha_aprobada"  value="<?php echo $fecha_aprobada?>" size="12" maxlength="10" readonly></span></td>
                      <td width="100"><span class="Estilo5">APROBADO POR :</span></td>
                      <td width="250"><span class="Estilo5"><input name="txtaprobado_por" type="text" class="Estilo5" id="txtaprobado_por"  value="<?php echo $aprobado_por?>" size="60" maxlength="60" readonly></span></td>    
					</tr>
                  </table></td>
                </tr>                
                <tr>
                  <td><table width="865" >
                    <tr>
                      <td width="70"><span class="Estilo5">ESTATUS : </span></td>
                      <td width="100"><span class="Estilo5"><input name="txtstatus_requisicion" type="text" class="Estilo5" id="txtstatus_requisicion"  value="<?php echo $status_requisicion?>" size="15" maxlength="15" readonly> </span></td>
                      <td width="485"><span class="Estilo5"><input name="txtdes_status" type="text" class="Estilo5" id="txtdes_status"  value="<?php echo $des_status?>" size="80" maxlength="100" readonly> </span></td>
					  <td width="110"><span class="Estilo5">ELABORADA POR:</span></td>
                      <td width="100"><span class="Estilo5"><input name="txtusuario_sia" type="text" class="Estilo5" id="txtusuario_sia"  value="<?php echo $usuario_req?>" size="20" maxlength="20" readonly></span></td>                
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                
          </table>
         <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:312px; z-index:2; left: 2px; top: 270px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Articulos";        // Requiere: <div id="T11" class="tab-body">  ... </div>
            </script>
              <?php include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_cons_art_req.php?criterio=<?php echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>              
            </div></td>
         </tr>
        </table>
                <div id="Layer3" style="position:absolute; width:868px; height:60px; z-index:2; left: 2px; top: 610px;">
                <table width="865" border="0">
                <tr>
                <td width="100"> <span class="Estilo5">SUB-TOTAL : </span> </td>
                <td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><?php  echo $campo_num1; ?></td> </tr>
         </table></td>
                <td width="120" align="right"> <span class="Estilo5">IMPUESTO : </span> </td>
                <td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><?php  echo $campo_num2; ?></td> </tr>
         </table></td>
                 <td width="160" align="right"> <span class="Estilo5">TOTAL REQUISICION : </span> </td>
                <td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><?php  echo $total_orden; ?></td> </tr>
         </table></td>
                </tr>

         </table></div>
        </form>
<form name="form2" method="post" action="Inc_Requisicion.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
	 <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtcod_imp_unico" type="hidden" id="txtcod_imp_unico" value="<?php echo $cod_imp_unico?>" ></td>
     <td width="5"><input name="txtcod_imp_part" type="hidden" id="txtcod_imp_part" value="<?php echo $cod_imp_part?>" ></td>
     <td width="5"><input name="txtcod_part_iva" type="hidden" id="txtcod_part_iva" value="<?php echo $cod_part_iva?>" ></td>
	 <td width="5"><input name="txtnro_req" type="hidden" id="txtnro_req" value="" ></td>
     <td width="5"><input name="txtasig_req" type="hidden" id="txtasig_req" value="S" ></td>
     <td width="5"><input name="txtfecha_req" type="hidden" id="txtfecha_req" value="<?php echo $fecha_hoy?>" ></td>
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?php echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?php echo $fecha_aut?>" ></td>	 
     <td width="5"><input name="txttipo_req" type="hidden" id="txttipo_req" value="C" ></td>
	 <td width="5"><input name="txtuni_sol" type="hidden" id="txtuni_sol" value=""></td>
     <td width="5"><input name="txtdes_unidad" type="hidden" id="txtdes_unidad" value=""></td>
     <td width="5"><input name="txtnombre_dep" type="hidden" id="txtnombre_dep" value=""></td>    
	 <td width="5"><input name="txtconcep" type="hidden" id="txtconcep" value="" ></td>	 
	 <td width="5"><input name="txtreq_ext" type="hidden" id="txtreq_ext" value="N" ></td>	 
	 <td width="5"><input name="txtnro_ext" type="hidden" id="txtnro_ext" value="" ></td>
     <td width="5"><input name="txtfecha_ext" type="hidden" id="txtfecha_ext" value="<?php echo $fecha_hoy?>" ></td>  
     <td width="5"><input name="txtrecibe_req" type="hidden" id="txtrecibe_req" value="<?php echo $Nom_usuario?>" ></td>  	 
  </tr>
</table>
</form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>