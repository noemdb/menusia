<?php include ("../class/conect.php");  include ("../class/funciones.php"); $equipo = getenv("COMPUTERNAME"); $mcod_m="BAN027".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
if (!$_GET){$ano_fiscal=""; $mes_fiscal=""; $nro_comprobante=""; $criterio="";} else{$criterio=$_GET["criterio"]; $nro_comprobante=substr($criterio,6,8);  $ano_fiscal=substr($criterio,0,4);  $mes_fiscal=substr($criterio,4,2);}
$fecha_hoy=asigna_fecha_hoy();  $clave=$ano_fiscal.$mes_fiscal.$nro_comprobante;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Modificar Comprobante Retenciones IVA)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
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
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtnro_comprobante.value==""){alert("Numero de Comprobante no puede estar Vacio");return false;}
      else{f.txtnro_orden.value=f.txtnro_orden.value;}
  document.form1.submit;
return true;}
</script>
<?php 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$resultado=pg_exec($conn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$sql="Select * from COMP_IVA where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $fecha_e=$registro["fecha_emision"];  $ced_rif=$registro["ced_rif"];  $nombre_benef=$registro["nombre"]; $referencia=$registro["referencia"];  $inf_usuario=$registro["inf_usuario"];}
if($fecha_e==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha_e);}
$sql="SELECT * FROM BAN027 where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante' order by nro_operacion";$res=pg_query($sql);
while($registro=pg_fetch_array($res))
{ $referencia=$registro["referencia"]; $tipo_r= $registro["nro_operacion"]; $fecha_e=$registro["fecha_emision"]; $nro_orden=$registro["referencia"];  $aux_orden=$registro["referencia"]; $tipo_transaccion=$registro["tipo_transaccion"];
  $tipo_operacion=$registro["tipo_operacion"]; $tipo_documento=$registro["tipo_documento"]; $nro_d=$registro["nro_documento"]; $nro_con_fac=$registro["nro_con_documento"]; $nro_doc_afectado=$registro["nro_doc_afectado"]; $fecha_f=$registro["fecha_documento"];
  $monto_p=$registro["monto_documento"]; $monto1=$registro["monto_exento_iva"];  $tasa=$registro["tasa_iva"];  $monto_o=$registro["base_imponible"]; $monto_r=$registro["monto_iva_retenido"];  $monto2=$registro["monto_iva"];  $monto3=$registro["tasa_retencion"];
  $ssql="SELECT INCLUYE_BAN029('$codigo_mov','0000','O/P','$referencia','$tipo_r','$tipo_transaccion','$ced_rif','$fecha_e','$nro_orden','$aux_orden','$tipo_operacion','$tipo_r','$tipo_documento','$nro_d','$nro_con_fac','$nro_doc_afectado','$fecha_f','00000000','',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";  $resultado=pg_exec($conn,$ssql); $error=pg_errormessage($conn);
}
?>
</head>
<body>
<table width="989" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR COMPROBANTE RETENCI&Oacute;N IVA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="510" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="502" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_comp_ret_iva.php?Gcriterio=C<?php echo $criterio?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_comp_ret_iva.php?Gcriterio=C<?php echo $criterio?>">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:491px; z-index:1; top: 62px; left: 118px;">
        <form name="form1" method="post" action="Update_comp_ret_iva.php" onSubmit="return revisar()">
          <table width="856" border="0" >
                <tr> <td width="850" height="14">&nbsp;</td>  </tr>
                <tr>
                  <td height="14"><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="155"><span class="Estilo5">PERIODO FISCAL A&Ntilde;O  : </span></td>
                      <td width="80"><span class="Estilo5"> <input class="Estilo10" name="txtano_fiscal" type="text" id="txtano_fiscal" size="5" maxlength="5"  readonly value="<?php echo $ano_fiscal?>" ></span></td>
                      <td width="45"><span class="Estilo5">MES :</span></td>
                      <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtmes_fiscal" type="text" id="txtmes_fiscal" size="2" maxlength="2"  readonly value="<?php echo $mes_fiscal?>" ></span></td>
                      <td width="170"><span class="Estilo5">N&Uacute;MERO COMPROBANTE  :</span></td>
                      <td width="120"><span class="Estilo5"><div id="nrocomp"> <input class="Estilo10" name="txtnro_comprobante" type="text" id="txtnro_comprobante" size="10" maxlength="10"  readonly value="<?php echo $nro_comprobante?>" > </div></span></td>
                      <td width="120"><span class="Estilo5">FECHA EMISI&Oacute;N  : </span></td>
                      <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_e" type="text" id="txtfecha_e" size="10" maxlength="10"  readonly  value="<?php echo $fecha?>" > </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
              <table width="889" border="0">
                <tr>
                  <td width="883"><table width="861" >
                    <tr>
                      <td width="95" height="24"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                      <td width="115"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="12" maxlength="12"  value="<?php echo $ced_rif?>" readonly > </span></td>
                      <td width="95"><span class="Estilo5"> NOMBRE :</span></td>
                      <td width="550"><span class="Estilo5">  <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="90"  readonly value="<?php echo $nombre_benef?>" >  </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
          <table width="889" border="0" >
                <tr>
                  <td width="883" height="14"><table width="861">
                    <tr>
                      <td width="156"><span class="Estilo5">N&Uacute;MERO DE ORDEN : </span></td>
                      <td width="77"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden" type="text" id="txtnro_orden" size="10" maxlength="8"  readonly value="<?php echo $referencia?>" > </span></td>
                      <td width="649">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td> </tr>
          </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_inc_comp_iva.php?codigo_mov=<?php echo $codigo_mov?>&agregar=N" width="870" height="310" scrolling="auto" frameborder="1"></iframe>
              </div>
         <table width="863" border="0"> <tr> <td height="5">&nbsp;</td> </tr> </table>
         <table width="812">
          <tr>
            <td width="654">&nbsp;</td>
            <td width="10"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>